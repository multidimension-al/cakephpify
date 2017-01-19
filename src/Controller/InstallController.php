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

namespace Multidimensional\Shopify\Controller;

use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;

use Multidimensional\Shopify\Controller\AppController;

class InstallController extends AppController
{

    private $error;

    public function initialize()
    {

        parent::initialize();
        $this->loadComponent('Multidimensional/Shopify.ShopifyDatabase');
        $this->loadComponent('Multidimensional/Shopify.ShopifyAPI');
        $this->loadComponent('Flash');
        $this->error = false;
    }

    public function validate($apiKey = null)
    {

        $isAuthorized = $this->ShopifyAPI->validateHMAC($this->request->query);

        if ($isAuthorized) {
            $accessToken = $this->ShopifyAPI->getAccessToken(
                $this->request->query['shop'],
                $this->request->query['code']
            );

            if ($accessToken) {
                $shop = $this->ShopifyAPI->getShopData();

                if (isset($shop['id'])) {
                    $shopEntity = $this->ShopifyDatabase->shopDataToDatabase($shop);

                    if ($shopEntity) {
                        $accessTokenEntity = $this->ShopifyDatabase->accessTokenToDatabase(
                            $accessToken,
                            $shopEntity->id,
                            $this->ShopifyAPI->api_key
                        );

                        if ($accessTokenEntity) {
                            $this->request->session()->write([
                                'shopify_access_token_' . $this->ShopifyAPI->api_key => $accessToken,
                                'shopify_shop_domain_' . $this->ShopifyAPI->api_key => $this->ShopifyAPI->getShopDomain()
                            ]);

                            //$this->Auth->setUser($shop_entity);

                            return $this->redirect([
                                'controller' => 'Shopify',
                                'plugin' => false]);
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

    public function index()
    {

        if (!empty($this->request->query['code']) && !$this->error) {
            $this->render('validate');
        } elseif (!empty($this->request->data['shop_domain']) && !$this->error) {
            $validDomain = $this->ShopifyAPI->validDomain(
                $this->request->data['shop_domain']
            );

            if ($validDomain) {
                $this->request->session()->write([
                    'shopify_shop_domain_' . $this->ShopifyAPI->api_key => $this->request->data['shop_domain']
                ]);

                $redirectUrl = Router::url([
                    'controller' => 'Install',
                    'action' => 'validate',
                    'plugin' => 'Multidimensional/Shopify',
                    'id' => $this->ShopifyAPI->api_key
                ], true);

                $authUrl = $this->ShopifyAPI->getAuthorizeUrl(
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

    public function redirect($url, $status = 302)
    {

        $this->set('shopify_auth_url', $url);
        $this->render('redirect');
    }
}
