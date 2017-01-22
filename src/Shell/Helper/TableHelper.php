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

namespace Multidimensional\Cakephpify\Shell\Helper;

use Cake\Console\Helper;
use Cake\Console\Shell;

class TableHelper extends Helper
{

    /**
     * @param array $data
     * @param int   $columns
     * @param int   $terminalWidth
     * @return void
     */
    public function output($data, $columns = 10, $terminalWidth = 80)
    {
        $dataCount = count($data);
        while ($dataCount % $columns != 0 && $columns > 5) {
            $columns--;
        }

        $maxLength = max(array_map('strlen', $data));

        while (((($columns * ($maxLength + 3)) + 3) > $terminalWidth) && ($columns >= 1)) {
            $columns--;
        }

        $this->_io->out(' ' . str_repeat('+-' . str_repeat('-', $maxLength) . '-', $columns) . '+ ');

        $dataCount = count($data);
        for ($i = 0; $i < $dataCount;) {
            $output = " ";
            $j = $i;
            for ($k = $i; $k < ($columns + $j); $k++) {
                if (!isset($data[$i])) {
                    $data[$i] = '';
                }
                $output .= '| ' . str_repeat(' ', floor(($maxLength - strlen($data[$i])) / 2)) . $data[$i] . str_repeat(' ', ceil(($maxLength - strlen($data[$i])) / 2)) . ' ';
                $i++;
            }
            $this->_io->out($output . '|');
            $this->_io->out(' ' . str_repeat('+-' . str_repeat('-', $maxLength) . '-', $columns) . '+ ');
        }
    }
}
