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

class ShopifyAuthAuthenticate extends BaseAuthenticate {

    //public $shopifyAPI;
	public $api_key;

    public function __construct($registry, array $config = []) {
        parent::__construct($registry, $config);
		
		$this->api_key = isset($config['api_key']) ? $config['api_key'] : Configure::read('Shopify.api_key');
		
		$registry->load('Multidimensional/Shopify.ShopifyAPI', [
            'api_key' => $this->api_key,
            'shared_secret' => isset($config['shared_secret']) ? $config['shared_secret'] : Configure::read('Shopify.shared_secret'),
            'scope' => isset($config['scope']) ? $config['scope'] : Configure::read('Shopify.scope'),
            'is_private_app' => isset($config['is_private_app']) ? $config['is_private_app'] : Configure::read('Shopify.is_private_app'),
            'private_app_password' => isset($config['private_app_password']) ? $config['private_app_password'] : Configure::read('Shopify.private_app_password')
        ]);
    }

    public function authenticate(Request $request, Response $response) {

		debug($request);

		$accessToken = $request->session()->read('shopify_access_token_' . $this->api_key);
		$shopDomain = $request->session()->read('shopify_shop_domain_' . $this->api_key);
		
		if ($accessToken) {
			$this->ShopifyAPI->setAccessToken($accessToken);
		}
		
		if ($shopDomain) {
			$this->ShopifyAPI->setShopDomain($shopDomain);
		}
		
		if (($request->query['HMAC'] && $request->query['shop']) && (!$shopDomain || $request->query['shop'] != $shopDomain)) {
			
			$is_valid = $this->ShopifyAPI->validateHMAC($request->query);
			
			if ($is_valid) {
				
				$shopDomain = $this->ShopifyAPI->setShopDomain($request->query['shop']);					
				$accessToken = $this->ShopifyDatabase->getAccessTokenFromShopDomain($shopDomain, $this->api_key);
					
			}
			
		}
	
		if (!$accessToken && $shopDomain && $request->query['code']) {
			$accessToken = $this->shopifyAPI->getAccessToken($shopDomain, $request->query['code']);
		}
		
        if ($accessToken) {
            
			$request->session()->write('shopify_access_token_' . $this->api_key, $accessToken);
			$request->session()->write('shopify_shop_domain_'.$this->api_key, $shopDomain);
			
			$shop = $this->ShopifyDatabase->getShopDataFromAccessToken($accessToken, $this->api_key);
			
            //return $shop;
			return true;
			
        }
		
        return false;
		
    }

	public function unauthenticated(Request $request, Response $response) {
		
		$request->session()->delete('shopify_access_token_' . $this->api_key);
		$request->session()->delete('shopify_shop_domain_' . $this->api_key);
		return $response->location($this->_generateLoginUrl());
		
	}

    public function getUser(Request $request) {
        return false;
    }

    public function implementedEvents() {
        return [
			'Auth.afterIdentify' => 'afterIdentify',
            'Auth.logout' => 'logout'
        ];
    }
	
	public function afterIdentify(Event $event, array $user) {
			
	}

    public function logout(Event $event, array $user) {
        
    }

    private function _generateLoginUrl() {
        return Router::url(['controller' => 'Install', 'action' => 'index', 'plugin' => 'Multidimensional/Shopify']);
    }

}
