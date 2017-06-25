<?php
/**
 *      __  ___      ____  _     ___                           _                    __
 *     /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *    / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *   / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *  /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * CakePHPify : CakePHP Plugin for Shopify API Authentication
 * Copyright (c) Multidimension.al (http://multidimension.al)
 * Github : https://github.com/multidimension-al/cakephpify
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2016-2017 Multidimension.al (http://multidimension.al)
 * @link             https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Cakephpify\Controller\Shopify;

use Cake\Event\Event;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Multidimensional\Cakephpify\Controller\AppController;

class InstallController extends AppController
{

    private $error;

    /**
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Multidimensional/Cakephpify.ShopifyDatabase');
        $this->loadComponent('Multidimensional/Cakephpify.ShopifyAPI', ['apiKey' => $this->request->apiKey]);
        $this->loadComponent('Flash');
        $this->error = false;
    }

    /**
     * @return void|redirect
     */
    public function add()
    {
        $isAuthorized = $this->shopifyApi->validateHMAC($this->request->query);

        if ($isAuthorized) {
            $accessToken = $this->shopifyApi->requestAccessToken(
                $this->request->query['shop'],
                $this->request->query['code']
            );

            if ($accessToken) {
                $shop = $this->shopifyApi->getShopData();

                if (isset($shop['id'])) {
                    $shopEntity = $this->shopifyDatabase->shopDataToDatabase($shop);

                    if ($shopEntity) {
                        $accessTokenEntity = $this->shopifyDatabase->accessTokenToDatabase(
                            $accessToken,
                            $shopEntity->id,
                            $this->shopifyApi->apiKey
                        );

                        if ($accessTokenEntity) {
                            $this->request->session()->write(
                                [
                                'shopify_access_token_' . $this->shopifyApi->apiKey => $accessToken,
                                'shopify_shop_domain_' . $this->shopifyApi->apiKey => $this->shopifyApi->getShopDomain()
                                ]
                            );


                            $this->Auth->setUser($shopEntity);

                            return $this->redirect(
                                [
                                'controller' => 'Shopify',
                                'plugin' => false,
                                'apiKey' => $this->shopifyApi->apiKey]
                            );
                        } else {
                            $this->Flash->set("Error saving access token. Please try again.");
                        }
                    } else {
                        $this->Flash->set("Error inserting Shopify shop data. Please try again.");
                    }
                } else {
                    $this->Flash->set("Error accessing Shopify API. Please try again later.");
                }
            } else {
                $this->Flash->set("Invalid access token. Pleasy try again.");
            }
        } else {
            $this->Flash->set("Invalid authoization code. Please try again.");
        }

        $this->error = true;
        $this->render('index');
    }

    /**
     * @return void|redirect
     */
    public function index()
    {
        if (!empty($this->request->query['code']) && !$this->error) {
            $this->render('add');
        } elseif (!empty($this->request->data['shop_domain']) && !$this->error) {
            $validDomain = $this->shopifyApi->validDomain(
                $this->request->data['shop_domain']
            );

            if ($validDomain) {
                $this->request->session()->write(
                    [
                    'shopify_shop_domain_' . $this->shopifyApi->apiKey => $this->request->data['shop_domain']
                    ]
                );

                $redirectUrl = Router::url(
                    [
                    'controller' => 'Install',
                    'action' => 'add',
                    'plugin' => 'Multidimensional/Cakephpify',
                    'apiKey' => $this->shopifyApi->apiKey
                    ],
                    true
                );

                $authUrl = $this->shopifyApi->getAuthorizeUrl(
                    $this->request->data['shop_domain'],
                    $redirectUrl
                );

                $this->redirect($authUrl);
            } else {
                $this->Flash->set("Invalid Shopify Domain");
            }
        } elseif (!empty($this->error)) {
            $this->Flash->set($this->error);
        }
    }

    /**
     * @param string $url
     * @param int    $status
     * @return void
     */
    public function redirect($url, $status = 302)
    {
        $this->set('shopify_auth_url', $url);
        $this->render('redirect');
    }
}
