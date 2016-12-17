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

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ShopifyDatabaseComponent extends Component {
	
	private $shops;
	private $access_tokens;
	
	public function initialize(array $config = []) {
	
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
	
		if ($access_token_id) {
		
			$access_token_entity->set([
				'id' => $access_token_id->id,
				'updated_at' => new \DateTime('now')
			]);
			
		}
									
		if (!$access_token_entity->errors() && $this->access_tokens->save($access_token_entity)) {
			return $access_token_entity;
		} else {
			return false;	
		}
		
	}
	
	public function getShopIdFromDomain($domain) {
		
		$shop_entity = $this->shops->findByMyshopifyDomain($domain)->first();
		if ($shop_entity->id) {
			return (int) $shop_entity->id;		
		} else {
			return false;
		}
		
	}
	
	public function getShopDataFromAccessToken($access_token, $api_key) {
		
		$query = $this->shops->find();
		$shop_entity = $query->matching('AccessTokens', function ($q) {
			return $q->where(['AccessTokens.access_token' => $access_token, 'AccessTokens.api_key' => $api_key, 'AccessTokens.expires_at' => NULL]);
		})->first()->toArray();

		if (is_array($shop_entity)) {
			return $shop_entity;		
		} else {
			return false;
		}
		
	}
	
	public function getAccessTokenFromShopDomain($shop_domain, $api_key) {
		
		$query = $this->access_tokens->find();
		$access_token_entity = $query->matching('Shops', function ($q) {
			return $q->where(['Shops.myshopify_domain' => $shop_domain, 'api_key' => $api_key]);
		})->first();

		if ($access_token_entity->access_token) {
			return $access_token_entity->access_token;		
		} else {
			return false;
		}
		
	}
	
	
}