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

namespace Multidimensional\Cakephpify\Test\TestCase\Shell\Helper;

use Cake\Console\ConsoleIo;
use Cake\TestSuite\Stub\ConsoleOutput;
use Cake\TestSuite\TestCase;
use Multidimensional\Cakephpify\Shell\Helper\TableHelper;

class TableHelperTest extends TestCase
{

    /**
     * @var ConsoleOutput
     */
    public $stub;

    /**
     * @var ConsoleIo
     */

    public $io;

    /**
     * @var TableHelper
     */
    public $helper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->stub = new ConsoleOutput();
        $this->io = new ConsoleIo($this->stub);
        $this->helper = new TableHelper($this->io);
    }

    public function testOutput()
    {
        $this->markTestIncomplete('Not implemented yet.');
        /*$data = [

        ];
        $this->helper->output($data);
        $expected = [

        ];
        $this->assertEquals($expected, $this->stub->messages());*/
    }
}
