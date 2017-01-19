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
 * @copyright     (c) Multidimension.al (http://multidimension.al)
 * @link          https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Shopify\Auth;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Controller\ComponentRegistry;
use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Network\Session;
use Cake\Error\Debugger;

use Multidimensional\Shopify\Auth\Event;

class ShopifyAuthAuthenticate extends BaseAuthenticate
{

    public $api_key;
    private $ShopifyAPI;
    private $ShopifyDatabase;

    public function __construct($registry, array $config = [])
    {
        parent::__construct($registry, $config);

        $this->api_key = isset($config['api_key']) ? $config['api_key'] : Configure::read('Shopify.api_key');

        $this->ShopifyAPI = $registry->load('Multidimensional/Shopify.ShopifyAPI', [
            'api_key' => $this->api_key,
            'shared_secret' => isset($config['shared_secret']) ? $config['shared_secret'] : Configure::read('Shopify.shared_secret'),
            'scope' => isset($config['scope']) ? $config['scope'] : Configure::read('Shopify.scope'),
            'is_private_app' => isset($config['is_private_app']) ? $config['is_private_app'] : Configure::read('Shopify.is_private_app'),
            'private_app_password' => isset($config['private_app_password']) ? $config['private_app_password'] : Configure::read('Shopify.private_app_password')
        ]);

        $this->ShopifyDatabase = $registry->load('Multidimensional/Shopify.ShopifyDatabase');
    }

    public function authenticate(Request $request, Response $response)
    {

        return $this->getUser($request);
    }

    public function unauthenticated(Request $request, Response $response)
    {

        if (isset($request->query['hmac'])
            && isset($request->query['shop'])) {
            return null;
        }

        if (empty($this->api_key)) {
            return null;
        }

        if (!empty($request->session()->read('shopify_access_token_' . $this->api_key))
            && !empty($request->session()->read('shopify_shop_domain_' . $this->api_key))) {
            return null;
        }

        $request->session()->delete('shopify_access_token_' . $this->api_key);
        $request->session()->delete('shopify_shop_domain_' . $this->api_key);

        return $response->location($this->_generateLoginUrl());
    }

    public function getUser(Request $request)
    {

        $accessToken = $request->session()->read('shopify_access_token_' . $this->api_key);
        $shopDomain = $request->session()->read('shopify_shop_domain_' . $this->api_key);

        if ($shopDomain) {
            $this->ShopifyAPI->setShopDomain($shopDomain);
        }

        if ((isset($request->query['hmac']) && isset($request->query['shop']))
            && (!$shopDomain || $request->query['shop'] != $shopDomain)) {
            $isValid = $this->ShopifyAPI->validateHMAC($request->query);
            if ($isValid) {
                $shopDomain = $this->ShopifyAPI->setShopDomain($request->query['shop']);

                if (isset($request->query['code'])) {
                    $accessToken = $this->ShopifyAPI->getAccessToken($shopDomain, $request->query['code']);
                } else {
                    $accessToken = $this->ShopifyDatabase->getAccessTokenFromShopDomain($shopDomain, $this->api_key);
                }
            }
        }

        if ($accessToken) {
            $this->ShopifyAPI->setAccessToken($accessToken);
            $this->ShopifyAPI->setShopDomain($shopDomain);

            $request->session()->write('shopify_access_token_' . $this->api_key, $accessToken);
            $request->session()->write('shopify_shop_domain_' . $this->api_key, $shopDomain);

            $shop = $this->ShopifyDatabase->getShopDataFromAccessToken($accessToken, $this->api_key);

            if ($shop && is_array($shop)) {
                return ['id' => $shop['id'], 'username' => $shop['myshopify_domain']];
            }
        }

        return false;
    }

    protected function _authenticate(Request $request)
    {
    }

    public function implementedEvents()
    {
        return [
            'Auth.afterIdentify' => 'afterIdentify',
            'Auth.logout' => 'logout'
        ];
    }

    public function afterIdentify(Event $event, array $user)
    {
    }

    public function logout(Event $event, array $user)
    {

        //$request->session()->delete('shopify_access_token_' . $this->api_key);
        //$request->session()->delete('shopify_shop_domain_' . $this->api_key);
    }

    private function _generateLoginUrl()
    {
        return Router::url(['controller' => 'Install', 'action' => 'index', 'plugin' => 'Multidimensional/Shopify']);
    }
}
