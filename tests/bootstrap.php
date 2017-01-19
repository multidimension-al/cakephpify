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

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;

require dirname(__DIR__) . '/vendor/autoload.php';

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('ROOT', dirname(__DIR__));
define('APP_DIR', 'src');
define('APP', ROOT . DS . APP_DIR . DS);
define('CONFIG', ROOT . DS . 'config' . DS);
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);
define('WEBROOT_DIR', 'webroot');
define('TESTS', ROOT . DS . 'tests' . DS);
define('TMP', ROOT . DS . 'tmp' . DS);
define('LOGS', ROOT . DS . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

require_once CORE_PATH . 'config' . DS . 'bootstrap.php';

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);

Configure::write('App', [
    'namespace' => 'App',
    'encoding' => env('APP_ENCODING', 'UTF-8'),
    'defaultLocale' => env('APP_DEFAULT_LOCALE', 'en_US'),
    'base' => false,
    'dir' => 'src',
    'webroot' => WEBROOT_DIR,
    'wwwRoot' => WWW_ROOT,
    // 'baseUrl' => env('SCRIPT_NAME'),
    'fullBaseUrl' => false,
    'imageBaseUrl' => 'img/',
    'cssBaseUrl' => 'css/',
    'jsBaseUrl' => 'js/',
    'paths' => [
        'plugins' => [ROOT . DS . 'plugins' . DS],
        'templates' => [APP . 'Template' . DS],
        'locales' => [APP . 'Locale' . DS],
    ],
]);

Plugin::load('Multidimensional/Shopify', ['path' => ROOT, 'autoload' => true]);

if (!getenv('DB_DSN')) {
    putenv('DB_DSN=sqlite:///:memory:');
}

ConnectionManager::config('test', [
    'url' => getenv('DB_DSN'),
    'timezone' => 'UTC'
]);
