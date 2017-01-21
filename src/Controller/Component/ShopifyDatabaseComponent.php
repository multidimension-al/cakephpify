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

namespace Multidimensional\Cakephpify\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class ShopifyDatabaseComponent extends Component
{

    private $shops;
    private $access_tokens;

    public $controller = null;

    public function initialize(array $config = [])
    {
        $this->shops = TableRegistry::get('Multidimensional/Cakephpify.Shops');
        $this->access_tokens = TableRegistry::get('Multidimensional/Cakephpify.AccessTokens');
    }

    public function startup(Event $event)
    {
        $this->setController($event->subject());
    }

    public function setController($controller)
    {
        $this->controller = $controller;
        if (!isset($this->controller->paginate)) {
            $this->controller->paginate = [];
        }
    }

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
            $accessTokenEntity->set([
                'id' => $accessTokenId->id,
                'updated_at' => new \DateTime('now')
            ]);
        }

        if (!$accessTokenEntity->errors() && $this->access_tokens->save($accessTokenEntity)) {
            return $accessTokenEntity->toArray();
        } else {
            return false;
        }
    }

    public function getShopIdFromDomain($domain)
    {
        $shopEntity = $this->shops->findByMyshopifyDomain($domain)->first();
        if ($shopEntity->id) {
            return (int)$shopEntity->id;
        } else {
            return false;
        }
    }

    public function getShopDataFromAccessToken($accessToken, $apiKey)
    {
        $query = $this->access_tokens->find();
        $query = $query->contain(['Shops']);
        $query = $query->where(['api_key' => $apiKey, 'token' => $accessToken]);
        $query = $query->where(function ($exp, $q) {
            return $exp->isNull('expired_at');
        });

        $shopEntity = $query->first()->toArray();

        if (is_array($shopEntity['shop'])) {
            return $shopEntity['shop'];
        } else {
            return false;
        }
    }

    public function getAccessTokenFromShopDomain($shopDomain, $apiKey)
    {
        $query = $this->access_tokens->find();
        $query = $query->contain(['Shops']);
        $query = $query->where(['api_key' => $apiKey, 'Shops.myshopify_domain' => $shopDomain]);
        $query = $query->where(function ($exp, $q) {
            return $exp->isNull('expired_at');
        });

        $accessTokenEntity = $query->first();

        if ($accessTokenEntity->token) {
            return $accessTokenEntity->token;
        } else {
            return false;
        }
    }
}
