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
use Cake\Event\Event;

class ShopifyDatabaseComponent extends Component {
    
    private $shops;
    private $access_tokens;
    
    public function initialize(array $config = []) {
        $this->shops = TableRegistry::get('Multidimensional/Shopify.Shops');
        $this->access_tokens = TableRegistry::get('Multidimensional/Shopify.AccessTokens');    
    }
    
    public function startup(Event $event) {
        $this->setController($event->subject());
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
        
        $query = $this->access_tokens->find();
        $query = $query->contain(['Shops']);
        $query = $query->where(['api_key' => $api_key, 'token' => $access_token]);
        $query = $query->where(function($exp, $q) {
            return $exp->isNull('expired_at');
        });
                
        $shop_entity = $query->first()->toArray();
                                
        if (is_array($shop_entity['shop'])) {
            return $shop_entity['shop'];        
        } else {
            return false;
        }
        
    }
    
    public function getAccessTokenFromShopDomain($shop_domain, $api_key) {
        
        $query = $this->access_tokens->find();
        $query = $query->contain(['Shops']);
        $query = $query->where(['api_key' => $api_key, 'Shops.myshopify_domain' => $shop_domain]);
        $query = $query->where(function($exp, $q) {
            return $exp->isNull('expired_at');
        });
                
        $access_token_entity = $query->first();
                
        if ($access_token_entity->token) {
            return $access_token_entity->token;        
        } else {
            return false;
        }
        
    }
    
    
}
