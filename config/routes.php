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

namespace Multidimensional\Cakephpify\Config;

use Cake\Routing\Router;
use Cake\Core\Configure;

Router::plugin('Multidimensional/Cakephpify', ['path' => '/'], function ($routes) {
    $shopifyAPIKeys = array_keys(Configure::read('Multidimensional/Cakephpify'));
    if (is_array($shopifyAPIKeys) && count($shopifyAPIKeys) >= 0) {
        $routes->connect(
            '/shopify/:api_key/install',
            ['controller' => 'Install', 'action' => 'index'],
            ['api_key' => implode('|', $shopifyAPIKeys), 'pass' => ['api_key']]
        );

        $routes->connect(
            '/shopify/:api_key/install',
            ['controller' => 'Install', 'action' => 'add'],
            ['api_key' => implode('|', $shopifyAPIKeys), 'pass' => ['api_key']]
        );
    }
});
