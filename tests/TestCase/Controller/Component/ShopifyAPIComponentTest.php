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
        $registry = new ComponentRegistry($this->controller);
        $this->component = new ShopifyAPIComponent($registry, ['apiKey' => 'abc123']);
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
        $shopDomain = 'test.myshopify.com';
        $return = $this->component->setShopDomain($shopDomain);
        $this->assertSame($return, $shopDomain);
        $return = $this->component->getShopDomain();
        $this->assertSame($return, $shopDomain);
        
        $shopDomain = 'random.myshopify.com';
        $this->component->setShopDomain($shopDomain);
        $return = $this->component->setShopDomain($shopDomain);
        $this->assertSame($return, $shopDomain);
        $return = $this->component->getShopDomain();
        $this->assertSame($return, $shopDomain);
        
        $shopDomain = null;
        $this->assertNull($shopDomain);
        $return = $this->component->setShopDomain($shopDomain);
        $this->assertNull($return);
        $return = $this->component->getShopDomain();
        $this->assertNull($return);
        
        $shopDomain = false;
        $this->assertFalse($shopDomain);
        $return = $this->component->setShopDomain($shopDomain);
        $this->assertFalse($return);
        $return = $this->component->getShopDomain();
        $this->assertFalse($return);
        
        $shopDomain = true;
        $this->assertTrue($shopDomain);
        $return = $this->component->setShopDomain($shopDomain);
        $this->assertTrue($return);
        $return = $this->component->getShopDomain();
        $this->assertTrue($return);
        
        $shopDomain = 'test.myshopify.com';
        $return = $this->component->validDomain($shopDomain);
        $this->assertTrue($return);
        
        $shopDomain = 'TEST.MYshopify.COM';
        $return = $this->component->validDomain($shopDomain);
        $this->assertTrue($return);
        
        $shopDomain = 'random.myshopify.com';
        $return = $this->component->validDomain($shopDomain);
        $this->assertTrue($return);
        
        $shopDomain = 'www.myshopify.com';
        $return = $this->component->validDomain($shopDomain);
        $this->assertTrue($return);
        
        $shopDomain = 'test.myshopify.net';
        $return = $this->component->validDomain($shopDomain);
        $this->assertFalse($return);
        
        $shopDomain = 'http://test.myshopify.com/';
        $return = $this->component->validDomain($shopDomain);
        $this->assertFalse($return);
        
        $shopDomain = 'google.com';
        $return = $this->component->validDomain($shopDomain);
        $this->assertFalse($return);
        
        $shopDomain = null;
        $this->assertNull($shopDomain);
        $return = $this->component->validDomain($shopDomain);
        $this->assertFalse($return);
        
        $shopDomain = false;
        $this->assertFalse($shopDomain);
        $return = $this->component->validDomain($shopDomain);
        $this->assertFalse($return);
        
        $shopDomain = true;
        $this->assertTrue($shopDomain);
        $return = $this->component->validDomain($shopDomain);
        $this->assertFalse($return);
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
        $shopDomain = "test.myshopify.com"; //339fdccae930940993141bde32be560f
        $return = $this->component->setNonce($shopDomain);
        $this->assertSame($return, '339fdccae930940993141bde32be560f');
        $return = $this->component->getNonce();
        $this->assertSame($return, '339fdccae930940993141bde32be560f');
        
        $shopDomain = "TeSt.MySHoPiFy.CoM"; //339fdccae930940993141bde32be560f
        $return = $this->component->setNonce($shopDomain);
        $this->assertSame($return, '339fdccae930940993141bde32be560f');
        $return = $this->component->getNonce();
        $this->assertSame($return, '339fdccae930940993141bde32be560f');
        
        $shopDomain = "example.com"; //5ababd603b22780302dd8d83498e5172
        $return = $this->component->setNonce($shopDomain);
        $this->assertSame($return, '5ababd603b22780302dd8d83498e5172');
        $return = $this->component->getNonce();
        $this->assertSame($return, '5ababd603b22780302dd8d83498e5172');
        
        $shopDomain = null; //d41d8cd98f00b204e9800998ecf8427e
        $this->assertNull($shopDomain);
        $return = $this->component->setNonce($shopDomain);
        $this->assertSame($return, 'd41d8cd98f00b204e9800998ecf8427e');
        $return = $this->component->getNonce();
        $this->assertSame($return, 'd41d8cd98f00b204e9800998ecf8427e');
        
        $shopDomain = false; //d41d8cd98f00b204e9800998ecf8427e
        $this->assertFalse($shopDomain);
        $return = $this->component->setNonce($shopDomain);
        $this->assertSame($return, 'd41d8cd98f00b204e9800998ecf8427e');
        $return = $this->component->getNonce();
        $this->assertSame($return, 'd41d8cd98f00b204e9800998ecf8427e');
        
        $shopDomain = true; //c4ca4238a0b923820dcc509a6f75849b
        $this->assertTrue($shopDomain);
        $return = $this->component->setNonce($shopDomain);
        $this->assertSame($return, 'c4ca4238a0b923820dcc509a6f75849b');
        $return = $this->component->getNonce();
        $this->assertSame($return, 'c4ca4238a0b923820dcc509a6f75849b');
    }
    
    public function testValidateHMAC()
    {
        $return = $this->component->validateHMAC(null);
        $this->assertFalse($return);
        
        $return = $this->component->validateHMAC([]);
        $this->assertFalse($return);
        
        $return = $this->component->validateHMAC(['hmac' => null]);
        $this->assertFalse($return);
        
        $return = $this->component->validateHMAC(['hmac' => 'string']);
        $this->assertFalse($return);
    }
}
