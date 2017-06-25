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

namespace Multidimensional\Cakephpify\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;
use Multidimensional\Cakephpify\Controller\Component\ShopifyDatabaseComponent;
use Multidimensional\Cakephpify\Test\Fixture\AccessTokensFixture;
use Multidimensional\Cakephpify\Test\Fixture\ShopsFixture;

class ShopifyDatabaseComponentTest extends TestCase
{

    public $component = null;
    public $controller = null;

    public $fixtures = ['plugin.Multidimensional/Cakephpify.Shops',
                            'plugin.Multidimensional/Cakephpify.AccessTokens'];

    public function setUp()
    {
        parent::setUp();
        $request = new Request();
        $response = new Response();
        $this->controller = $this->getMockBuilder('Cake\Controller\Controller')
            ->setConstructorArgs([$request, $response])
            ->setMethods(null)
            ->getMock();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new ShopifyDatabaseComponent($registry);
        $event = new Event('Controller.startup', $this->controller);
        $this->component->startup($event);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }

    public function testShopDataToDatabase()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testAccessTokenToDatabase()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetShopIdFromDomain()
    {
        //$return = $this->component->getShopIdFromDomain('test.myshopify.com');
        //$this->assertSame($return, 8675309);
        //$this->assertEquals($return, 8675309);

        $return = $this->component->getShopIdFromDomain('false.myshopify.com');
        $this->assertFalse($return);
        
        $return = $this->component->getShopIdFromDomain('not-a-domain.com');
        $this->assertFalse($return);
        
        $return = $this->component->getShopIdFromDomain(null);
        $this->assertFalse($return);
        
        $return = $this->component->getShopIdFromDomain(true);
        $this->assertFalse($return);
        
        $return = $this->component->getShopIdFromDomain(false);
        $this->assertFalse($return);
    }

    public function testGetShopDataFromAccessToken()
    {
        $return = $this->component->getShopDataFromAccessToken(null, null);
        $this->assertFalse($return);
        
        $return = $this->component->getShopDataFromAccessToken(null, true);
        $this->assertFalse($return);
        
        $return = $this->component->getShopDataFromAccessToken(true, null);
        $this->assertFalse($return);
        
        $return = $this->component->getShopDataFromAccessToken(null, false);
        $this->assertFalse($return);
        
        $return = $this->component->getShopDataFromAccessToken(false, null);
        $this->assertFalse($return);
        
        $return = $this->component->getShopDataFromAccessToken(false, false);
        $this->assertFalse($return);
        
        $return = $this->component->getShopDataFromAccessToken(true, true);
        $this->assertFalse($return);

        $return = $this->component->getShopDataFromAccessToken('', '');
        $this->assertFalse($return);
        
        $return = $this->component->getShopDataFromAccessToken(0, 0);
        $this->assertFalse($return);
    }

    public function testGetAccessTokenFromShopDomain()
    {
        $return = $this->component->getAccessTokenFromShopDomain(null, null);
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain(null, true);
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain(true, null);
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain(null, false);
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain(false, null);
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain(false, false);
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain(true, true);
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain('', '');
        $this->assertFalse($return);
        
        $return = $this->component->getAccessTokenFromShopDomain(0, 0);
        $this->assertFalse($return);              
    }
}
