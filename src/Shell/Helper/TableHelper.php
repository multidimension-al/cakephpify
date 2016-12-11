<?php
namespace Shopify\Shell\Helper;

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
