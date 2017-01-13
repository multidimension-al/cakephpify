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

class InstallController extends AppController {
    
    private $error;
    
    public function initialize() {

        parent::initialize();
        $this->loadComponent('Multidimensional/Shopify.ShopifyDatabase');
        $this->loadComponent('Multidimensional/Shopify.ShopifyAPI');
        $this->loadComponent('Flash');
        $this->error = false;
        
    }
        
    public function validate($api_key = null) {

        $is_authorized = $this->ShopifyAPI->validateHMAC($this->request->query);
        
        if ($is_authorized) {
        
            $access_token = $this->ShopifyAPI->getAccessToken(
                $this->request->query['shop'],
                $this->request->query['code']
            );
        
            if ($access_token) {
                
                $shop = $this->ShopifyAPI->getShopData();
                
                if (isset($shop['id'])) {
                
                    $shop_entity = $this->ShopifyDatabase->shopDataToDatabase($shop);
                    
                    if ($shop_entity) {
                        
                        $access_token_entity = $this->ShopifyDatabase->accessTokenToDatabase(
                            $access_token,
                            $shop_entity->id,
                            $this->ShopifyAPI->api_key
                        );
                        
                        if ($access_token_entity) {
                        
                            $this->request->session()->write([
                                'shopify_access_token_' . $this->ShopifyAPI->api_key => $access_token,
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
  
    public function index() {
                    
        if (!empty($this->request->query['code']) && !$this->error) {
      
            $this->render('validate');
              
            } elseif (!empty($this->request->data['shop_domain']) && !$this->error) {
            
            $valid_domain = $this->ShopifyAPI->validDomain(
                $this->request->data['shop_domain']
            );
            
            if ($valid_domain) {
                
                $this->request->session()->write([
                    'shopify_shop_domain_' . $this->ShopifyAPI->api_key => $this->request->data['shop_domain']
                ]);
            
                $redirect_url = Router::url([
                    'controller' => 'Install',
                    'action' => 'validate',
                    'plugin' => 'Multidimensional/Shopify',
                    'id' => $this->ShopifyAPI->api_key
                ], true);
                
                $auth_url = $this->ShopifyAPI->getAuthorizeUrl(
                    $this->request->data['shop_domain'],
                    $redirect_url
                );
                
                $this->redirect($auth_url);
                
            } else {
                
                $this->Flash->set("Invalid Shopify Domain");
                
            }
            
        } elseif (!empty($this->error)) {
            
            $this->Flash->set($this->error);

        }
      
    }
    
    public function redirect($url, $status = 302) {
        
        $this->set('shopify_auth_url', $url);
        $this->render('redirect');
        
    }
  
}

?>
