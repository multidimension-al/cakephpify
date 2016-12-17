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

namespace Multidimensional\Shopify\Shell\Helper;

use Cake\Console\Shell;
use Cake\Console\Helper;

class TableHelper extends Helper
{

	public function output($data, $columns = 10, $terminal_width = 80)
	{
		while((count($data)%$columns != 0) && ($columns > 5)) {
			$columns--;	
		}
 				
		$max_length = max(array_map('strlen', $data));
		
		while(((($columns * ($max_length+3)) + 3) > $terminal_width) && ($columns >= 1)) {
			$columns--;
		}
		
		$this->_io->out(' ' . str_repeat('+-' . str_repeat('-', $max_length) . '-', $columns) . '+ ');
		
		for($i = 0; $i < count($data); ) {
			$output = " ";
			$j = $i;
			for($k = $i; $k < ($columns+$j); $k++) {
				if (!isset($data[$i])) {
					$data[$i] = '';	
				}
				$output .= '| ' . str_repeat(' ', floor(($max_length - strlen($data[$i]))/2)) . $data[$i] . str_repeat(' ', ceil(($max_length - strlen($data[$i]))/2)) . ' ';
				$i++;
			}
			$this->_io->out($output . '|');
			$this->_io->out(' ' . str_repeat('+-' . str_repeat('-', $max_length) . '-', $columns) . '+ ');	
		}		
		
	}
	
}
