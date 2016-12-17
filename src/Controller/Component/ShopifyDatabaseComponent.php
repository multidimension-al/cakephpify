<?php
namespace Multidimensional\Shopify\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ShopifyDatabaseComponent extends Component {
	
	private $shops;
	private $access_tokens;
	
	public function initialize(array $config = []){
	
		$this->shops = TableRegistry::get('Shops');
		$this->access_tokens = TableRegistry::get('AccessTokens');
		
	}
	
	public function shopDataToDatabase(array $data) {
		
		$shop_entity = $this->shops->newEntity();

		unset($data['created_at']);
		unset($data['updated_at']);
					
		$shop_entity->set($data);
		
		$shop_entity->set(['updated_at' => new \DateTime('now')]);
		
		if (!$shop_entity->errors() && $this->shops->save($shop_entity)) {
			return $shop_entity;
		} else {
			return false;	
		}
		
	}
	
		
	public function accessTokenToDatabase($access_token, $shop_id, $api_key) {
		
		$access_token_entity = $this->access_tokens->newEntity();
		
		$access_token_array = [
			'shop_id' => $shop_id,
			'api_key' => $api_key,
			'token' => $access_token];
	
		$access_token_entity->set($access_token_array);
	
		$access_token_id = $this->access_tokens
			->find()
			->where($access_token_array)
			->first();
	
		if($access_token_id){
		
			$access_token_entity->set([
				'id' => $access_token_id->id,
				'updated_at' => new \DateTime('now')
			]);
			
		}
									
		if(!$access_token_entity->errors() && $this->access_tokens->save($access_token_entity)) {
			return $access_token_entity;
		} else {
			return false;	
		}
		
	}
	
	public function getShopIdFromDomain($domain) {
		
		$shop_entity = $this->shops->findByDomain($domain)->first();
		if($shop_entity->id){
			return (int) $shop_entity->id;		
		}else{
			return false;
		}
		
	}
	
	
}