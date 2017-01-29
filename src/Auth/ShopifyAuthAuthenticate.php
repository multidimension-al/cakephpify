<?php
/**
 * CakePHPify : CakePHP Plugin for Shopify API Authentication
 * Copyright (c) Multidimension.al (http://multidimension.al)
 * Github : https://github.com/multidimension-al/cakephpify
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright (c) Multidimension.al (http://multidimension.al)
 * @link      https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Cakephpify\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Network\Session;
use Cake\Routing\Router;
use Multidimensional\Cakephpify\Auth\Event;

class ShopifyAuthAuthenticate extends BaseAuthenticate
{

    public $apiKey;
    private $shopifyApi;
    private $shopifyDatabase;

    /**
     * @param registry $registry
     * @param array    $config
     * @return void
     */
    public function __construct($registry, array $config = [])
    {
        parent::__construct($registry, $config);

        $this->apiKey = isset($config['apiKey']) ? $config['apiKey'] : '';

        if (empty($this->apiKey)) {
            $controller = $this->_registry->getController();

            if (isset($controller->request->apiKey)) {
                $this->apiKey = $controller->request->apiKey;
            }
        }

        $this->shopifyApi = $registry->load(
            'Multidimensional/Cakephpify.ShopifyAPI',
            [
            'apiKey' => $this->apiKey
            ]
        );

        $this->shopifyDatabase = $registry->load('Multidimensional/Cakephpify.ShopifyDatabase');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @return array
     */
    public function authenticate(Request $request, Response $response)
    {
        return $this->getUser($request);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @return null|Response
     */
    public function unauthenticated(Request $request, Response $response)
    {
        if (isset($request->query['hmac'])
            && isset($request->query['shop'])
        ) {
            return null;
        }

        if (empty($this->apiKey)) {
            return null;
        }

        if (!empty($request->session()->read('shopify_access_token_' . $this->apiKey))
            && !empty($request->session()->read('shopify_shop_domain_' . $this->apiKey))
        ) {
            return null;
        }

        $request->session()->delete('shopify_access_token_' . $this->apiKey);
        $request->session()->delete('shopify_shop_domain_' . $this->apiKey);

        return $response->location($this->_generateLoginUrl());
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function getUser(Request $request)
    {
        $accessToken = $request->session()->read('shopify_access_token_' . $this->apiKey);
        $shopDomain = $request->session()->read('shopify_shop_domain_' . $this->apiKey);

        if ($shopDomain) {
            $this->shopifyApi->setShopDomain($shopDomain);
        }

        if ((isset($request->query['hmac']) && isset($request->query['shop']))
            && (!$shopDomain || $request->query['shop'] != $shopDomain)
        ) {
            $isValid = $this->shopifyApi->validateHMAC($request->query);
            if ($isValid) {
                $shopDomain = $this->shopifyApi->setShopDomain($request->query['shop']);

                if (isset($request->query['code'])) {
                    $accessToken = $this->shopifyApi->requestAccessToken($shopDomain, $request->query['code']);
                } else {
                    $accessToken = $this->shopifyDatabase->getAccessTokenFromShopDomain($shopDomain, $this->apiKey);
                }
            }
        }

        if ($accessToken) {
            $this->shopifyApi->setAccessToken($accessToken);
            $this->shopifyApi->setShopDomain($shopDomain);

            $request->session()->write('shopify_access_token_' . $this->apiKey, $accessToken);
            $request->session()->write('shopify_shop_domain_' . $this->apiKey, $shopDomain);

            $shop = $this->shopifyDatabase->getShopDataFromAccessToken($accessToken, $this->apiKey);

            if ($shop && is_array($shop)) {
                return ['id' => $shop['id'], 'username' => $shop['myshopify_domain']];
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @return void
     */
    protected function _authenticate(Request $request)
    {
    }

    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Auth.afterIdentify' => 'afterIdentify',
            'Auth.logout' => 'logout'
        ];
    }

    /**
     * @param Event $event
     * @param array $user
     * @return void
     */
    public function afterIdentify(Event $event, array $user)
    {
    }

    /**
     * @param Event $event
     * @param array $user
     * @return void
     */
    public function logout(Event $event, array $user)
    {
        //$request->session()->delete('shopify_access_token_' . $this->apiKey);
        //$request->session()->delete('shopify_shop_domain_' . $this->apiKey);
    }

    /**
     * @return Router
     */
    private function _generateLoginUrl()
    {
        return Router::url(['controller' => 'Install', 'action' => 'index', 'plugin' => 'Multidimensional/Cakephpify']);
    }
}
