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
 * @link       https://github.com/multidimension-al/cakephpify CakePHPify Github
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\Cakephpify\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Multidimensional\Cakephpify\Controller\InstallController;

class InstallControllerTest extends IntegrationTestCase
{

    public $fixtures = ['plugin.Multidimensional/Cakephpify.Shops',
                        'plugin.Multidimensional/Cakephpify.AccessTokens'];

    public function setUp()
    {
        parent::setUp();
    }

    public function testValidate()
    {
        $this->markTestIncomplete('Not implemented yet.');
        /*$this->get('/shopify/install/');
        $this->assertResponseOk();
        $this->get('/shopify/' . md5(rand(1, 10)) . '/install/');
        $this->assertResponseError();*/
    }

    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
        /*$this->get('/shopify/install/');
        $this->assertResponseOk();*/
    }

    public function testRedirect()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
