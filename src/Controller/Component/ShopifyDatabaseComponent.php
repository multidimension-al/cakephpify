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
 * @copyright (c) Multidimension.al (http://multidimension.al)
 * @link      https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Cakephpify\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class ShopifyDatabaseComponent extends Component
{

    private $shops;
    private $access_tokens;

    public $controller = null;

    /**
     * @param array $config
     * @return void
     */
    public function initialize(array $config = [])
    {
        $this->shops = TableRegistry::get('Multidimensional/Cakephpify.Shops');
        $this->access_tokens = TableRegistry::get('Multidimensional/Cakephpify.AccessTokens');
    }

    /**
     * @param Event $event
     * @return void
     */
    public function startup(Event $event)
    {
        $this->setController($event->subject());
    }

    /**
     * @param controller $controller
     * @return void
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        if (!isset($this->controller->paginate)) {
            $this->controller->paginate = [];
        }
    }

    /**
     * @param array $data
     * @return array|bool
     */
    public function shopDataToDatabase(array $data)
    {
        $shopEntity = $this->shops->newEntity();

        unset($data['created_at']);
        unset($data['updated_at']);

        $shopEntity->set($data);

        $shopEntity->set(['updated_at' => new \DateTime('now')]);

        if (!$shopEntity->errors() && $this->shops->save($shopEntity)) {
            return $shopEntity->toArray();
        } else {
            return false;
        }
    }

    /**
     * @param string $accessToken
     * @param int    $shopId
     * @param string $apiKey
     * @return array|bool
     */
    public function accessTokenToDatabase($accessToken, $shopId, $apiKey)
    {
        $accessTokenEntity = $this->access_tokens->newEntity();

        $accessTokenArray = [
            'shop_id' => $shopId,
            'api_key' => $apiKey,
            'token' => $accessToken];

        $accessTokenEntity->set($accessTokenArray);

        $accessTokenId = $this->access_tokens
            ->find()
            ->where($accessTokenArray)
            ->first();

        if ($accessTokenId) {
            $accessTokenEntity->set(
                [
                'id' => $accessTokenId->id,
                'updated_at' => new \DateTime('now')
                ]
            );
        }

        if (!$accessTokenEntity->errors() && $this->access_tokens->save($accessTokenEntity)) {
            return $accessTokenEntity->toArray();
        } else {
            return false;
        }
    }

    /**
     * @param string $domain
     * @return int|false
     */
    public function getShopIdFromDomain($domain)
    {
		if (empty($domain)) {
			return false;	
		}

        $shopEntity = $this
			->shops
			->findByMyshopifyDomain($domain)
			->first();
			
		if ($shopEntity->isEmpty()) {
			return false;	
		}
			
        if ($shopEntity->id) {
            return (int)$shopEntity->id;
        } else {
            return false;
        }
    }

    /**
     * @param string $accessToken
     * @param string $apiKey
     * @return array|false
     */
    public function getShopDataFromAccessToken($accessToken, $apiKey)
    {
		if (empty($accessToken) || empty($apiKey)) {
			return false;	
		}
		
        $query = $this->access_tokens->find();
        $query = $query->contain(['Shops']);
        $query = $query->where(['api_key' => $apiKey, 'token' => $accessToken]);
        $query = $query->where(
            function ($exp, $q) {
                return $exp->isNull('expired_at');
            }
        );

        $shopEntity = $query->first();
		
		if ($shopEntity->isEmpty()) {
			return false;	
		}
		
		$shopArray = $shopEntity->toArray();

        if (is_array($shopArray['shop'])) {
            return $shopArray['shop'];
        } else {
            return false;
        }
    }

    /**
     * @param string $shopDomain
     * @param string $apiKey
     * @return string|bool
     */
    public function getAccessTokenFromShopDomain($shopDomain, $apiKey)
    {
		if (empty($shopDomain) || empty($apiKey)) {
			return false;	
		}
		
        $query = $this->access_tokens->find();
        $query = $query->contain(['Shops']);
        $query = $query->where(['api_key' => $apiKey, 'Shops.myshopify_domain' => $shopDomain]);
        $query = $query->where(
            function ($exp, $q) {
                return $exp->isNull('expired_at');
            }
        );

        $accessTokenEntity = $query->first();

		if ($accessTokenEntity->isEmpty()) {
			return false;	
		}

        if ($accessTokenEntity->token) {
            return $accessTokenEntity->token;
        } else {
            return false;
        }
    }
}
