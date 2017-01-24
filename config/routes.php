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

use Cake\Core\Configure;
use Cake\Routing\Router;

Router::plugin(
    'Multidimensional/Cakephpify',
    ['path' => '/'],
    function ($routes) {
        $routes->prefix('shopify', function ($routes) {
        $shopifyAPIKeys = array_keys(Configure::read('Multidimensional/Cakephpify'));
        if (is_array($shopifyAPIKeys) && count($shopifyAPIKeys) >= 0) {
            $routes->connect(
                ':apiKey/install',
                ['controller' => 'Install', 'action' => 'index'],
                ['apiKey' => implode('|', $shopifyAPIKeys), 'pass' => ['apiKey']]
            );
        }
        });
    }
);
