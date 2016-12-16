<?php
namespace Multidimensional\Shopify\Controller;

use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

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
		
		if ($is_authorized) {
		
			$access_token = $this->ShopifyAPI->getAccessToken($this->request->query['shop'], $this->request->query['code']);
		
			if ($access_token) {
				
				//Download / Update Shop Info
				$shop = getShopData();
				
				if (isset($shop['id'])) {
				
					$shops_table = TableRegistry::get('Shops');
					$shop_entity = $shops_table->newEntity();
					
					$shop_entity->set([
						'id' => $shop['id'],
						'name' => $shop['name'],
						'email' => $shop['email'],
						'domain' => $shop['domain'],
						'created_at' => $shop['created_at'],
						'province' => $shop['province'],
						'country' => $shop['country'],
						'address1' => $shop['address1'],
						'zip' => $shop['zip'],
						'city' => $shop['city'],
						'source' => $shop['source'],
						'phone' => $shop['phone'],
						'updated_at' => $shop['updated_at'],
						'customer_email' => $shop['customer_email'],
						'latitude' => $shop['latitude'],
						'longitude' => $shop['longitude'],
						'primary_location_id' => $shop['primary_location_id'],
						'primary_locale' => $shop['primary_locale'],
						'address2' => $shop['address2'],
						'country_code' => $shop['country_code'],
						'country_name' => $shop['country_name'],
						'currency' => $shop['currency'],
						'timezone' => $shop['timezone'],
						'iana_timezone' => $shop['iana_timezone'],
						'shop_owner' => $shop['shop_owner'],
						'money_format' => $shop['money_format'],
						'money_with_currency_format' => $shop['money_with_currency_format'],
						'province_code' => $shop['province_code'],
						'taxes_included' => $shop['taxes_included'],
						'tax_shipping' => $shop['tax_shipping'],
						'county_taxes' => $shop['county_taxes'],
						'plan_display_name' => $shop['plan_display_name'],
						'plan_name' => $shop['plan_name'],
						'has_discounts' => $shop['has_discounts'],
						'has_gift_cards' => $shop['has_gift_cards'],
						'myshopify_domain' => $shop['myshopify_domain'],
						'google_apps_domain' => $shop['google_apps_domain'],
						'google_apps_login_enabled' => $shop['google_apps_login_enabled'],
						'money_in_emails_format' => $shop['money_in_emails_format'],
						'money_with_currency_in_emails_format' => $shop['money_with_currency_in_emails_format'],
						'eligible_for_payments' => $shop['eligible_for_payments'],
						'requires_extra_payments_agreement' => $shop['requires_extra_payments_agreement'],
						'password_enabled' => $shop['password_enabled'],
						'has_storefront' => $shop['has_storefront'],
						'eligible_for_card_reader_giveaway' => $shop['eligible_for_card_reader_giveaway'],
						'finances' => $shop['finances'],
						'setup_required' => $shop['setup_required'],
						'force_ssl' => $shop['force_ssl']
					]);
					
					if (!$shop_entity->errors()) {
						
						if ($shops_table->save($shop_entity)) {
					
							//Save Access Token
							$access_tokens_table = TableRegistry::get('AccessTokens');
							$access_token_entity = $access_tokens_table->newEntity();
							
							$access_token_entity->set([
								'shop_id' => $shop_entity->id,
								'token' => $access_token,
								'updated_at' => new DateTime('now')
							]);
							
							if(!$access_token_entity->errors()){
								
								if ($access_tokens_table->save($access_token_entity)) {
								
									$this->Auth->setUser($shop_entity->toArray());
									
									$this->redirect(['controller' => 'Shopify', 'action' => 'index', 'plugin' => false]);
									
								} else {
								
									//Error Saving Access Token
									
								}
								
							} else {
							
								//Access Token Validation Error	
								
							}
							
						} else {
						
							//DB Save Error
							
						}
					
					} else {
					
						//Validation Error	
						
					}
					
				}
				
			} else {
			
				$this->Flash->set("Invalid Access Token.");
				$this->render('index');
				
			}
			
		} else {
		
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
