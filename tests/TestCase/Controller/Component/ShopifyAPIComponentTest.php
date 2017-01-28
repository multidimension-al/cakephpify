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

namespace Multidimensional\Cakephpify\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;
use Multidimensional\Cakephpify\Controller\Component\ShopifyAPIComponent;
use Multidimensional\Cakephpify\Test\Fixture\AccessTokensFixture;
use Multidimensional\Cakephpify\Test\Fixture\ShopsFixture;

class ShopifyAPIComponentTest extends TestCase
{

    public $component = null;
    public $controller = null;
    public $fixtures = ['plugin.Multidimensional/Cakephpify.Shops', 'plugin.Multidimensional/Cakephpify.AccessTokens'];

    public function setUp()
    {
        parent::setUp();
		
		Configure::write('Multidimensional/Cakephpify', [
				'abc123' =>
					[
					'sharedSecret' => 'abc123',
					'scope' => '',
					'privateApp' => false,
					'privateAppPassword' => NULL]
					]);
		
        $request = new Request();
        $response = new Response();
        $this->controller = $this->getMockBuilder('Cake\Controller\Controller')
            ->setConstructorArgs([$request, $response])
            ->setMethods(null)
            ->getMock();
        $registry = new ComponentRegistry($this->controller, ['apiKey' => 'abc123']);
        $this->component = new ShopifyAPIComponent($registry);
        $event = new Event('Controller.startup', $this->controller);
        $this->component->startup($event);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }

    public function testShopDomain()
    {
		$shopDomain = "test.myshopify.com";
		$return = $this->component->setShopDomain($shopDomain);
		$this->assertSame($return, $shopDomain);
		$return = $this->component->getShopDomain();
		$this->assertSame($return, $shopDomain);
		
		$shopDomain = "random.myshopify.com";
		$this->component->setShopDomain($shopDomain);
		$return = $this->component->setShopDomain($shopDomain);
		$this->assertSame($return, $shopDomain);
		$return = $this->component->getShopDomain();
		$this->assertSame($return, $shopDomain);
		
		$shopDomain = NULL;
		$return = $this->component->setShopDomain($shopDomain);
		$this->assertNull($return);
		$return = $this->component->getShopDomain();
		$this->assertNull($return);
		
		$shopDomain = false;
		$return = $this->component->setShopDomain($shopDomain);
		$this->assertFalse($return);
		$return = $this->component->getShopDomain();
		$this->assertFalse($return);
		
		$shopDomain = true;
		$return = $this->component->setShopDomain($shopDomain);
		$this->assertTrue($return);
		$return = $this->component->getShopDomain();
		$this->assertTrue($return);
		
		$shopDomain = "test.myshopify.com";
		$return = $this->component->validDomain($shopDomain);
		$this->assertTrue($return);
		
		$shopDomain = "TEST.MYshopify.COM";
		$return = $this->component->validDomain($shopDomain);
		$this->assertTrue($return);
		
		$shopDomain = "random.myshopify.com";
		$return = $this->component->validDomain($shopDomain);
		$this->assertTrue($return);
		
		$shopDomain = "www.myshopify.com";
		$return = $this->component->validDomain($shopDomain);
		$this->assertTrue($return);
		
		/*$shopDomain = "test.myshopify.net";
		$return = $this->component->validDomain($shopDomain);
		$this->assertFalse($return);
		
		$shopDomain = "http://test.myshopify.com/";
		$return = $this->component->validDomain($shopDomain);
		$this->assertFalse($return);
		
		$shopDomain = "google.com";
		$return = $this->component->validDomain($shopDomain);
		$this->assertFalse($return);
		
		$shopDomain = NULL;
		$return = $this->component->validDomain($shopDomain);
		$this->assertFalse($return);
		
		$shopDomain = false;
		$return = $this->component->validDomain($shopDomain);
		$this->assertFalse($return);
		
		$shopDomain = true;
		$return = $this->component->validDomain($shopDomain);
		$this->assertFalse($return);*/
    }

    public function testSetAccessToken()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetAuthorizeUrl()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetAccessToken()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testNonce()
    {
		$nonce = md5(rand());
		$return = $this->component->setNonce($nonce);
		$this->assertSame($return, $nonce);
		$return = $this->component->getNonce();
		$this->assertSame($return, $nonce);
		
		$nonce = md5(rand());
		$this->component->setNonce($nonce);
		$return = $this->component->setNonce($nonce);
		$this->assertSame($return, $nonce);
		$return = $this->component->getNonce();
		$this->assertSame($return, $nonce);
		
		$nonce = NULL;
		$return = $this->component->setNonce($nonce);
		$this->assertNull($return);
		$return = $this->component->getNonce();
		$this->assertNull($return);
		
		$nonce = false;
		$return = $this->component->setNonce($nonce);
		$this->assertFalse($return);
		$return = $this->component->getNonce();
		$this->assertFalse($return);
		
		$nonce = true;
		$return = $this->component->setNonce($nonce);
		$this->assertTrue($return);
		$return = $this->component->getNonce();
		$this->assertTrue($return);
    }
}
