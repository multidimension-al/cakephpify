<?php

namespace Multidimensional\Shopify\Controller\Component;

use Cake\Core\Configure;
use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Network\Http\Client;

class ShopifyAPIComponent extends Component {
		
	public $api_key;
	public $shop_domain;
	public $token;
	public $isAuthorized;

	private $shared_secret;
	private $is_private_app;
	private $private_app_password;
	private $nonce;
	
	/*public function startup(Event $event) {
		
	}*/
	
	public function initialize(array $config = []) {
		
		$this->api_key = ((isset($config['api_key'])) ? $config['api_key'] : Configure::read('Multidimensional/Shopify.api_key'));
		$this->shared_secret = ((isset($config['shared_secret'])) ? $config['shared_secret'] : Configure::read('Multidimensional/Shopify.shared_secret'));
		$this->scope = ((isset($config['scope'])) ? $config['scope'] : Configure::read('Multidimensional/Shopify.scope'));
   		$this->is_private_app = ((isset($config['is_private_app'])) ? $config['is_private_app'] : Configure::read('Multidimensional/Shopify.is_private_app'));
		$this->private_app_password = ((isset($config['private_app_password'])) ? $config['private_app_password'] : Configure::read('Multidimensional/Shopify.private_app_password'));		
		
	}

	public function getShopDomain() {
		return $this->shop_domain;
	}

	/*public function isAuthorized() {
		return strlen($this->shop_domain) > 0 && strlen($this->token) > 0;
	}*/
	
	public function callsMade() {
		return $this->shopApiCallLimitParam(0);
	}

	public function callLimit() {
		return $this->shopApiCallLimitParam(1);
	}

	public function callsLeft($response_headers) {
		return $this->callLimit() - $this->callsMade();
	}

	public function call($method, $path, $params=array()) {
		
		if (!$this->isAuthorized()) {
			return;
		}
		
		if (!in_array($method, array('POST','PUT','GET','DELETE'))) {
			return;	
		}
		
		$http = new Client([
			'host' => $this->shop_domain,
			'scheme' => 'https',
			'headers' => (($this->is_private_app != 'true') ? (['X-Shopify-Access-Token' => $this->token]) : ''),
			'auth' => (($this->is_private_app != 'true') ? '' : (['username' => $this->api_key, 'password' => $this->private_app_password]))]);
							
		$this->response = $http->{strtolower($method)}($path, ((in_array($method, array('POST','PUT'))) ? json_encode($params) : $params), ((in_array($method, array('POST','PUT'))) ? ['type' => 'json'] : NULL));
		$this->response = $this->response->json;

		return (is_array($this->response) && (count($this->response) > 0)) ? array_shift($this->response) : $this->response;
		
	}
	
	private function shopApiCallLimitParam($index) {
		$params = explode("/",$this->response->getHeaderLine('http_x_shopify_shop_api_call_limit'));
		return (int) $params[$index];
	}
	
	public function getAuthorizeUrl($shop_domain, $redirect_url) {
				
		$url = 'https://' . $shop_domain . '/admin/oauth/authorize?client_id=' . $this->api_key;
		$url .= '&scope=' . urlencode($this->scope);
		$url .= '&redirect_uri=' . urlencode($redirect_url);
		$url .= '&state=' . $this->getNonce($shop_domain);
		return $url;
		
	}

	public function getAccessToken($shop_domain, $code) {
	
		$http = new Client([
			'host' => $shop_domain,
			'scheme' => 'https'
		]);
  
		$response = $http->post('/admin/oauth/access_token', 'client_id=' . $this->api_key . 
									'&client_secret=' . $this->shared_secret .
									'&code=' . $code);
		$response = $response->json;;
		
		if (isset($response['access_token'])) {
			return $response['access_token'];
		} else {
			return false;
		}
	
  	}
	
	public function getNonce($shop_domain) {
		
		return md5(strtolower($shop_domain));
		
	}
	
	public function validDomain($shop_domain) {
	
		return true;
		
	}
	
	public function isAuthorized($query) {
	  
		if (!is_array($query) || empty($query['hmac']) || !is_string($query['hmac']) || (isset($query['state']) && $query['state'] != $this->getNonce($query['shop']))) {
			return false;
		}
 
		$dataString = array();
		
		foreach ($query as $key => $value) {
			$key = $this->_urlEncode(str_replace('=', '%3D', $key));
			$value = $this->_urlEncode($value);
			if ($key != 'hmac') {
				$dataString[] = $key . '=' . $value;
			}
		}

		sort($dataString);
		$string = implode("&", $dataString);
		return $query['hmac'] == hash_hmac('sha256', $string, $this->shared_secret);
	
  	}

	private function _urlEncode($url){
	
		$url = str_replace('&', '%26', $url);
		$url = str_replace('%', '%25', $url);
		return $url;
		
	}
	
}

?>