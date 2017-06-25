<?php
/**
 *      __  ___      ____  _     ___                           _                    __
 *     /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *    / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *   / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *  /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 * CakePHPify : CakePHP Plugin for Shopify API Authentication
 * Copyright (c) Multidimension.al (http://multidimension.al)
 * Github : https://github.com/multidimension-al/cakephpify
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2016-2017 Multidimension.al (http://multidimension.al)
 * @link             https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Cakephpify\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotImplementedException;
use Cake\Network\Http\Client;
use Cake\Routing\Router;

class ShopifyAPIComponent extends Component
{

    public $apiKey;

    private $shopDomain;
    private $token;
    private $sharedSecret;
    private $privateApp;
    private $privateAppPassword;
    private $nonce;

    public $controller = null;

    /**
     * @param array $config
     * @return void
     */
    public function initialize(array $config = [])
    {
        parent::initialize($config);

        $this->apiKey = isset($config['apiKey']) ? $config['apiKey'] : '';

        if (!empty($this->apiKey)) {
            $this->sharedSecret = Configure::read('Multidimensional/Cakephpify.' . $this->apiKey . '.sharedSecret');
            $this->scope = Configure::read('Multidimensional/Cakephpify.' . $this->apiKey . '.scope');
            $this->privateApp = Configure::read('Multidimensional/Cakephpify.' . $this->apiKey . '.privateApp');
            $this->privateAppPassword = Configure::read('Multidimensional/Cakephpify.' . $this->apiKey . '.privateAppPassword');
        } else {
            throw new NotImplementedException(__('Shopify API key not found'));
        }

        if (!$this->sharedSecret) {
            throw new NotImplementedException(__('Shopify Shared Secret not found'));
        }
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
    }

    /**
     * @param string $shopDomain
     * @return string|null
     */
    public function setShopDomain($shopDomain)
    {
        return $this->shopDomain = $shopDomain;
    }

    /**
     * @return string|null
     */
    public function getShopDomain()
    {
        return $this->shopDomain;
    }

    /**
     * @param string $shopDomain
     * @return bool
     */
    public function validDomain($shopDomain)
    {
        return preg_match('/^([A-Za-z0-9]{1}(?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9]{1})?)\.myshopify\.com$/i', $shopDomain) !== 0;
    }
    
    /**
     * @param string $token
     * @return string|null
     */
    public function setAccessToken($token)
    {
        return $this->token = $token;
    }
    
    /**
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->token;
    }

    /**
     * @return int|null
     */
    public function callsMade()
    {
        return $this->shopApiCallLimitParam(0);
    }

    /**
     * @return int|null
     */
    public function callLimit()
    {
        return $this->shopApiCallLimitParam(1);
    }

    /**
     * @param Response $responseHeaders
     * @return int|null
     */
    public function callsLeft($responseHeaders)
    {
        return $this->callLimit() - $this->callsMade();
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $params
     * @return array|null
     */
    public function call($method, $path, $params = [])
    {
        if (!$this->_isReady()) {
            return false;
        }

        if (!in_array($method, ['POST', 'PUT', 'GET', 'DELETE'])) {
            return false;
        }

        $http = new Client(
            [
            'host' => $this->shopDomain,
            'scheme' => 'https',
            'headers' => (($this->privateApp != 'true') ? (['X-Shopify-Access-Token' => $this->token]) : []),
            'auth' => (($this->privateApp != 'true') ? [] : (['username' => $this->apiKey, 'password' => $this->privateAppPassword]))
            ]
        );

        $this->response = $http->{strtolower($method)}(
            $path,
            ((in_array($method, ['POST', 'PUT'])) ? json_encode($params) : $params),
            ((in_array($method, ['POST', 'PUT'])) ? ['type' => 'json'] : [])
        );
        $this->response = $this->response->json;

        return (is_array($this->response) && (count($this->response) > 0)) ? array_shift($this->response) : $this->response;
    }

    /**
     * @param int $index
     * @return int
     */
    private function shopApiCallLimitParam($index)
    {
        $params = explode("/", $this->response->getHeaderLine('http_x_shopify_shop_api_call_limit'));

        return (int)$params[$index];
    }

    /**
     * @param string $shopDomain
     * @param string $redirectUrl
     * @return string
     */
    public function getAuthorizeUrl($shopDomain, $redirectUrl)
    {
        $url = 'https://' . $shopDomain . '/admin/oauth/authorize?client_id=' . $this->apiKey;
        $url .= '&scope=' . urlencode($this->scope);
        $url .= '&redirect_uri=' . urlencode($redirectUrl);
        $url .= '&state=' . $this->getNonce($shopDomain);

        return $url;
    }

    /**
     * @param string $shopDomain
     * @param string $code
     * @return string|false
     */
    public function requestAccessToken($shopDomain, $code)
    {
        $this->shopDomain = $shopDomain;

        $http = new Client(
            [
            'host' => $shopDomain,
            'scheme' => 'https'
            ]
        );

        $response = $http->post(
            '/admin/oauth/access_token',
            'client_id=' . $this->apiKey .
                                    '&client_secret=' . $this->sharedSecret .
            '&code=' . $code
        );
        $response = $response->json;
        ;

        if (isset($response['access_token'])) {
            $this->token = $response['access_token'];

            return $this->token;
        } else {
            return false;
        }
    }

    /**
     * @param string $shopDomain
     * @return string|null
     */
    public function setNonce($shopDomain)
    {
        return $this->nonce = md5(strtolower($shopDomain));
    }

    /**
     * @return string|null
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @return json
     */
    public function getShopData()
    {
        return $this->call('GET', '/admin/shop.json');
    }

    /**
     * @param array $query
     * @return bool
     */
    public function validateHMAC($query)
    {
        if (!is_array($query) || empty($query['hmac']) || !is_string($query['hmac']) || (isset($query['state']) && $query['state'] != $this->getNonce($query['shop']))) {
            return false;
        }

        $dataString = [];

        foreach ($query as $key => $value) {
            $key = $this->_urlEncode(str_replace('=', '%3D', $key));
            $value = $this->_urlEncode($value);
            if ($key != 'hmac') {
                $dataString[] = $key . '=' . $value;
            }
        }

        sort($dataString);
        $string = implode("&", $dataString);

        return $query['hmac'] === hash_hmac('sha256', $string, $this->sharedSecret);
    }

    /**
     * @param string $url
     * @return string
     */
    private function _urlEncode($url)
    {
        $url = str_replace('&', '%26', $url);
        $url = str_replace('%', '%25', $url);

        return $url;
    }

    /**
     * @return bool
     */
    private function _isReady()
    {
        return strlen($this->shopDomain) > 0 && strlen($this->token) > 0;
    }
}
