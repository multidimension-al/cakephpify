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

namespace Multidimensional\Cakephpify\Test\TestCase\Shell\Helper;

use Cake\Console\ConsoleIo;
use Cake\TestSuite\Stub\ConsoleOutput;
use Cake\TestSuite\TestCase;
use Multidimensional\Cakephpify\Shell\Helper\HeaderHelper;

class HeaderHelperTest extends TestCase
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
     * @var HeaderHelper
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
        $this->helper = new HeaderHelper($this->io);
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
