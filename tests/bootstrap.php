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
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);

Plugin::load('Multidimensional/Cakephpify', ['autoload' => true, 'bootstrap' => true, 'routes' => true]);

if (!getenv('DB_DSN')) {
    putenv('DB_DSN=sqlite:///:memory:');
}

ConnectionManager::config('test', [
    'url' => getenv('DB_DSN'),
    'timezone' => 'UTC'
]);

