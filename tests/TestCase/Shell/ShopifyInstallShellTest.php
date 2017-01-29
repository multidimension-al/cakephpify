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

namespace Multidimensional\Cakephpify\Test\TestCase\Shell;

use Cake\Console\ConsoleIo;
use Cake\TestSuite\Stub\ConsoleOutput;
use Cake\TestSuite\TestCase;
use Multidimensional\Cakephpify\Shell\ShopifyInstallShell;
use Symfony\Component\Console\Output\NullOutput;

class ShopifyInstallShellTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        
		$this->out = new ConsoleOutput();
        $io = new ConsoleIo($this->out);
        $this->Shell = $this->getMockBuilder('ShopifyInstallShell')
            ->setMethods(['in', 'err', '_stop', 'clear'])
            ->setConstructorArgs([$io])
            ->getMock();			
	}
    
    public function tearDown()
    {
        parent::tearDown();
        unset($this->shell);
    }
    
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.'); 
		/*$this->Shell->main();
        $output = $this->out->messages();
		$expected = "/(.*)/";
        $this->assertRegExp($expected, $output);
		*/
    }
}
