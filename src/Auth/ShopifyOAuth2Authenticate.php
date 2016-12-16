<?php
namespace Multidimensional\Shopify\Auth;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Controller\ComponentRegistry;
use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;

class ShopifyOAuth2Authenticate extends BaseAuthenticate {

    //public $shopifyAPI;

    public function __construct($registry, array $config = []) {
        parent::__construct($registry, $config);
		
		$registry->load('Multidimensional/Shopify.ShopifyAPI', [
            'api_key' => isset($config['api_key']) ? $config['api_key'] : Configure::read('Multidimensional/Shopify.api_key'),
            'shared_secret' => isset($config['shared_secret']) ? $config['shared_secret'] : Configure::read('Multidimensional/Shopify.shared_secret'),
            'scope' => isset($config['scope']) ? $config['scope'] : Configure::read('Multidimensional/Shopify.scope'),
            'is_private_app' => isset($config['is_private_app']) ? $config['is_private_app'] : Configure::read('Multidimensional/Shopify.is_private_app'),
            'private_app_password' => isset($config['private_app_password']) ? $config['private_app_password'] : Configure::read('Multidimensional/Shopify.private_app_password')
        ]);
    }

    public function authenticate(Request $request, Response $response) {

        /*$accessToken = $this->shopifyAPI->getAccessToken();
        if ($accessToken) {
            $user = $this->getShopifyDomain($accessToken);
            $request->session()->write('shopify_access_token', (string) $accessToken);
            return $user;
        }*/
        return false;
    }

	public function unauthenticated(Request $request, Response $response) {
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
        return Router::url(['controller' => 'install', 'plugin' => 'Multidimensional/Shopify']);
    }

}
