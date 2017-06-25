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

namespace Multidimensional\Cakephpify\Shell\Helper;

use Cake\Console\Helper;

class TableHelper extends Helper
{

    /**
     * @param array $data          array of data to be displayed
     * @param int   $columns       maximum number of table columns
     * @param int   $terminalWidth maximum table width in characters1
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
            $output = ' ';
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
