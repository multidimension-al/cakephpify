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

namespace Multidimensional\Shopify\Controller\Component;

use Cake\Core\Configure;
use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Network\Http\Client;
use Cake\Network\Exception\NotImplementedException;

class ShopifyAPIComponent extends Component {
        
    public $api_key;
    
    private $shop_domain;
    private $token;
    private $shared_secret;
    private $is_private_app;
    private $private_app_password;
    private $nonce;
        
    public function initialize(array $config = []) {
        
        parent::initialize($config);
		
        $this->api_key = isset($config['api_key']) ? $config['api_key'] : '';
				
		if (!empty($this->api_key)) {
		
			$this->shared_secret = Configure::read('Multidimensional/Shopify.' . $this->api_key . '.shared_secret');
			$this->scope = Configure::read('Multidimensional/Shopify.' . $this->api_key . '.scope');
			$this->is_private_app = Configure::read('Multidimensional/Shopify.' . $this->api_key . '.is_private_app');
			$this->private_app_password = Configure::read('Multidimensional/Shopify.' . $this->api_key . '.private_app_password');        
			
		} else {
			
			throw new NotImplementedException(__('Shopify API key not found'));
			
		}
		
		if (!$this->shared_secret) {
		
			throw new NotImplementedException(__('Shopify shared secret not found'));
			
		}
		
    }

    public function setShopDomain($shop_domain) {
        return $this->shop_domain = $shop_domain;
    }
    
    public function getShopDomain() {
        return $this->shop_domain;
    }
    
    public function setAccessToken($token) {
        return $this->token = $token;
    }
    
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
        
        if (!$this->_isReady()) {
            return false;
        }
        
        if (!in_array($method, array('POST','PUT','GET','DELETE'))) {
            return false;    
        }
        
        $http = new Client([
            'host' => $this->shop_domain,
            'scheme' => 'https',
            'headers' => (($this->is_private_app != 'true') ? (['X-Shopify-Access-Token' => $this->token]) : []),
            'auth' => (($this->is_private_app != 'true') ? [] : (['username' => $this->api_key, 'password' => $this->private_app_password]))
        ]);
                            
        $this->response = $http->{strtolower($method)}(
            $path,
            ((in_array($method, array('POST','PUT'))) ? json_encode($params) : $params),
            ((in_array($method, array('POST','PUT'))) ? ['type' => 'json'] : [])
        );
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
    
        $this->shop_domain = $shop_domain;
    
        $http = new Client([
            'host' => $shop_domain,
            'scheme' => 'https'
        ]);
  
        $response = $http->post('/admin/oauth/access_token', 'client_id=' . $this->api_key . 
                                    '&client_secret=' . $this->shared_secret .
                                    '&code=' . $code);
        $response = $response->json;;
        
        if (isset($response['access_token'])) {
            $this->token = $response['access_token'];
            return $this->token;
        } else {
            return false;
        }
    
      }

    public function setNonce($shop_domain) {
        
        return $this->nonce = md5(strtolower($shop_domain));
        
    }

    
    public function getNonce($shop_domain) {
        
        return md5(strtolower($shop_domain));
        
    }
    
    public function validDomain($shop_domain) {
    
        return true;
        
    }
    
    public function getShopData() {
    
        return $this->call('GET', '/admin/shop.json');
    
    }
    
    public function validateHMAC($query) {
            
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

    private function _urlEncode($url) {
    
        $url = str_replace('&', '%26', $url);
        $url = str_replace('%', '%25', $url);
        return $url;
        
    }
    
    private function _isReady() {
        return strlen($this->shop_domain) > 0 && strlen($this->token) > 0;
    }
    
}

?>