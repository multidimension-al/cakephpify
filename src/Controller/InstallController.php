<?php
namespace Multidimensional\Shopify\Controller;

use Cake\Event\Event;
use Cake\Routing\Router;
//use Cake\Controller\Component\AuthComponent;
//use Cake\Controller\Component;

class InstallController extends AppController {
    
	private $error;
	
	public function initialize() {

		parent::initialize();
		$this->loadComponent('Multidimensional/Shopify.ShopifyAPI');
		$this->loadComponent('Flash');
		$this->error = false;

	}
		
	public function validate($api_key = null) {

		$is_authorized = $this->ShopifyAPI->isAuthorized($this->request->query);
		
		if($is_authorized) {
		
			$access_token = $this->ShopifyAPI->getAccessToken($this->request->query['shop'], $this->request->query['code']);
		
			if($access_token){
				
				//Save Access Token
				
				//Download / Update Shop Info
				
				//$this->auth? Log them in
				
				$this->redirect(['controller' => 'Shopify', 'action' => 'index', 'plugin' => false]);
				
			}else{
			
				$this->Flash->set("Invalid Access Token.");
				$this->render('index');
				
			}
		}else{
		
			$this->Flash->set("Invalid Authoization");
			$this->render('index');
			
		}
		
	}
  
	public function index() {
  	  
		if(!empty($this->request->query['code']) && !$this->error) {
	  
			$this->render('validate');
			  
  		} elseif (!empty($this->request->data['shop_domain']) && !$this->error) {
			
			$valid_domain = $this->ShopifyAPI->validDomain($this->request->data['shop_domain']);
			
			if($valid_domain){
			
				$redirect_url = Router::url(array('controller' => 'Install', 'action' => 'validate', 'plugin' => 'Multidimensional/Shopify', 'id' => $this->ShopifyAPI->api_key), true);
				$auth_url = $this->ShopifyAPI->getAuthorizeUrl($this->request->data['shop_domain'], $redirect_url);
				$this->redirect($auth_url);
				
			}else{
				
				$this->Flash->set("Invalid Shopify Domain");
				$this->render('index');
				
			}
			
		} elseif (!empty($this->error)) {
			
			$this->Flash->set($this->error);

		}
	  
	}
  
}

?>
