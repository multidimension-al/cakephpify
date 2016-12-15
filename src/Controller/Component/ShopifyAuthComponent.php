<!--
namespace Multidimensional\Shopify\Controller\Component;

use Cake\Core\Configure;
use Cake\Controller\Component;
use Cake\Routing\Router;
use Cake\Network\Http\Client;

class ShopifyAuthComponent extends Component {

  private $_excludeCheckOnList = [['controller'=>'Install', 'action'=>'index']];

  private $skipAuthCheck = false;

  public $isAuthorized = false;
  public $shop_domain;
  public $token;
  public $nonce;

	public function __construct(&$controller, $settings=array()) {
		parent::__construct($controller, $settings);
		
		if (isset($settings['skipAuthCheck'])) {
			$this->skipAuthCheck = $settings['skipAuthCheck'];
		}
		
		if (!empty($settings['exclude_check_on'])) {
			foreach ($settings['exclude_check_on'] as $exclude_check_on){
				$this->_excludeCheckOnList[] = $exclude_check_on;
			}
		}
	
	}

  function initialize(array $config) {
    
    $this->api_key = ((isset($config['api_key'])) ? $config['api_key'] : Configure::read('Multidimensional/Shopify.api_key'));
    $this->shared_secret = ((isset($config['shared_secret'])) ? $config['shared_secret'] : Configure::read('Multidimensional/Shopify.shared_secret'));
    $this->scope = ((isset($config['scope'])) ? $config['scope'] : Configure::read('Multidimensional/Shopify.scope'));

	if ((empty($this->api_key)) || (empty($this->shared_secret))) {
		die("Invalid Credentials");
	}

	$this->nonce = md5($this->api_key . $this->shared_secret);

    $controller = $this->_registry->getController();

    if (!$this->isAuthorized) {
				
		if (isset($controller->request->query['code'])) {
        	
			$code = $controller->request->query['code'];
			$shop_domain = $controller->request->query['shop'];

	        if ($this->_isAuthorized($controller->request->query)) {
    
		        //$shop = $controller->Shop->findByShopDomain($shop_domain);
        	    $token = '';
            	
				//if ($hasCode) {
		            $token = $this->getAccessToken($shop_domain, $code);
        	    /*} else {
            		
					  if (isset($shop["Shop"]) && isset($shop["Shop"]["token"])) {
		                $token = $shop["Shop"]["token"];
		              }
        	    }*/
				
				           	
				if ($token) {
              		
					//$this->logout();

		            /*if ($hasCode) {
        		
				        // save the shop
                		$shop = $controller->Shop->findByShopDomain($shop_domain);
		                if (!isset($shop["Shop"])) {
        			        $shop["Shop"] = array();
			                $shop["Shop"]["shop_domain"] = $shop_domain;
            			}else {
			                unset($shop["Shop"]["modified"]);
				            unset($shop["Shop"]["created"]);
                		}

		                $shop["Shop"]["token"] = $token;
        		        $controller->Shop->save($shop);
              		}*/

	              	$this->isAuthorized = true;
    	          	//$controller->request->session()->write('Multidimensional/Shopify.shop_domain', $shop_domain);
        	      	//$controller->request->session()->write('Multidimensional/Shopify.token', $token);
            	  	$this->shop_domain = $shop_domain;
              		$this->token = $token;
              		//$controller->redirect('/');
					
					debug($this->ShopifyAPI->call('GET', '/admin/shop.json'));
					
            	}
			}
		  
		} elseif (isset($controller->request->data['shop']) || isset($controller->request->query['shop'])) {
		
			$shop_domain = (isset($controller->request->data['shop']) ? $controller->request->data['shop'] : $controller->request->query['shop']);
	
			$return_url = Router::url(['controller' => 'install', 'plugin'=>'Shopify'], true);
			$auth_url = $this->getAuthorizeUrl($shop_domain, $return_url);
			$controller->redirect($auth_url);
			
		}
	
		if ($this->skipAuthCheck) {
			return;
		} else if (!$this->isAuthorized && !$this->_excludeCheckOn($controller)) {
			$controller->redirect(array('controller'=>'install', 'plugin'=>'Shopify'));
		}
	
	}
	
  }

	/*public function setAuth($apiAuth) {
		
		$this->shop_domain = $apiAuth['shop_domain'];
		$this->token = $apiAuth['token'];
	
	}*/



	
	public function logout() {
		
		$this->isAuthorized = false;
		return $this->redirect($this->Auth->logout());
		
	}



	private function _excludeCheckOn(&$controller) {
		
		foreach ($this->_excludeCheckOnList as $exclude_check_on) {
			if ($controller->name == $exclude_check_on['controller'] && array_key_exists('action', $exclude_check_on) && $controller->request->action == $exclude_check_on['action']) {
				return true;
			}
			if ($controller->name == $exclude_check_on['controller'] && $controller->name == 'Pages') {
				if (is_array($controller->passedArgs) && count($controller->passedArgs) > 0 && $controller->passedArgs[0] == $exclude_check_on['page'])
					return true;
				}
			}
		return false;
		
	}

}

-->