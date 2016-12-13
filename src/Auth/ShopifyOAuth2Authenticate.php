<?php

namespace Shopify\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;

class ShopifyOAuth2Authenticate extends BaseAuthenticate {

    var $components = array('Shopify.ShopifyAPI');
    public $shopifyAPI;

    public function initialize(Cake\Controller\ComponentRegistry $registry, array $config = []) {
        parent::__construct($registry, $config);

        $this->shopifyAPI = new Shopify\Controller\Component\ShopifyAPIComponent($registry, [
            'api_key' => ((isset($config['api_key'])) ? $config['api_key'] : Configure::read('Shopify.api_key')),
            'shared_secret' => ((isset($config['shared_secret'])) ? $config['shared_secret'] : Configure::read('Shopify.shared_secret')),
            'scope' => ((isset($config['scope'])) ? $config['scope'] : Configure::read('Shopify.scope')),
            'is_private_app' => ((isset($config['is_private_app'])) ? $config['is_private_app'] : Configure::read('Shopify.is_private_app')),
            'private_app_password' => ((isset($config['private_app_password'])) ? $config['private_app_password'] : Configure::read('Shopify.private_app_password'))
        ]);
    }

    public function authenticate(Request $request, Response $response) {

        $accessToken = $this->shopifyAPI->getAccessToken();
        if ($accessToken) {
            $user = $this->getShopifyDomain($accessToken);
            $request->session()->write('shopify_access_token', (string) $accessToken);
            return $user;
        } else {
            $response->location($this->generateLoginUrl());
        }
        return false;
    }

    public function getUser(Cake\Network\Request $request) {
        
    }

    public function generateLoginUrl() {
        return Router::url(['controller' => 'install', 'plugin' => 'Shopify']);
    }

    public function getShopifyDomain($accessToken) {
        $query = $this->ShopifyShops->findByToken($accessToken);
        debug($query->toArray());
    }

    public function implementedEvents() {
        return [
            'Auth.logout' => 'logout'
        ];
    }

    public function logout(Event $event, array $user) {
        
    }

}
