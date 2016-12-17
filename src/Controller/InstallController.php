<?php
namespace Multidimensional\Shopify\Controller;

use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

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

		$is_authorized = $this->ShopifyAPI->isAuthorized($this->request->query);
		
		if ($is_authorized) {
		
			$access_token = $this->ShopifyAPI->getAccessToken(
				$this->request->query['shop'],
				$this->request->query['code']
			);
		
			if ($access_token) {
				
				//Download / Update Shop Info
				$shop = $this->ShopifyAPI->getShopData();
				
				if (isset($shop['id'])) {
				
					$shop_entity = $this->ShopifyDatabase->shopDataToDatabase($shop);
					
					if($shop_entity){
						
						$access_token_entity = $this->ShopifyDatabase->accessTokenToDatabase(
							$access_token,
							$shop_entity->id,
							$this->ShopifyAPI->api_key
						);
						
						if ($access_token_entity) {
						
							//$this->Auth->setUser($shop_entity);
							
							$this->redirect(
								Router::url([
									'controller' => 'Shopify',
									'action' => 'index',
									'plugin' => false]
								)
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
		
		$this->render('index');
		
	}
  
	public function index() {
  	  	  
		if(!empty($this->request->query['code']) && !$this->error) {
	  
			$this->render('validate');
			  
  		} elseif (!empty($this->request->data['shop_domain']) && !$this->error) {
			
			$valid_domain = $this->ShopifyAPI->validDomain(
				$this->request->data['shop_domain']
			);
			
			if($valid_domain){
			
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
				$this->render('index');
				
			}
			
		} elseif (!empty($this->error)) {
			
			$this->Flash->set($this->error);

		}
	  
	}
  
}

?>
