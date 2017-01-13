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
 
namespace Multidimensional\Shopify\Tests\Controller;

use Multidimensional\Shopify\Controller\InstallController;

use Cake\TestSuite\IntegrationTestCase;

class InstallControllerTest extends IntegrationTestCase {
 
    public function setUp() {
        parent::setUp();
    }
    
    public function testValidate() {
        $this->get('/shopify/install/');
        $this->assertResponseOk();
        $this->get('/shopify/' . md5(rand(1,10)) . '/install/');
        $this->assertResponseError();
    }
    
    public function testIndex() {
        $this->get('/shopify/install/');
        $this->assertResponseOk();
    }
    
    public function testRedirect() {
        
    }

}
