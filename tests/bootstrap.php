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

// @codingStandardsIgnoreFile

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;

require_once 'vendor/autoload.php';

// Path constants to a few helpful things.
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('ROOT', dirname(__DIR__) . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
define('CORE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('TESTS', ROOT . 'tests');
define('APP', ROOT . 'tests' . DS . 'test_files' . DS . 'app' . DS);
define('APP_DIR', 'app');
define('WEBROOT_DIR', 'webroot');
define('WWW_ROOT', dirname(APP) . DS . 'webroot' . DS);
define('TMP', sys_get_temp_dir() . DS);
define('CONFIG', dirname(APP) . DS . 'config' . DS);
define('CACHE', TMP);
define('LOGS', TMP);

require_once CORE_PATH . 'config/bootstrap.php';

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);
Configure::write('App', [
    'namespace' => 'App',
    'encoding' => 'UTF-8',
    'base' => false,
    'baseUrl' => false,
    'dir' => 'src',
    'webroot' => WEBROOT_DIR,
    'www_root' => WWW_ROOT,
    'fullBaseUrl' => 'http://localhost',
    'imageBaseUrl' => 'img/',
    'jsBaseUrl' => 'js/',
    'cssBaseUrl' => 'css/',
    'paths' => [
        'plugins' => [dirname(APP) . DS . 'plugins' . DS],
        'templates' => [APP . 'Template' . DS]
    ]
]);

Plugin::load('Multidimensional/Shopify', ['path' => ROOT]);

if (!getenv('DB_DSN')) {
    putenv('DB_DSN=mysql://root:password@localhost/my_database');
}

ConnectionManager::config('test', [
    'url' => getenv('DS_DSN'),
    'timezone' => 'UTC'
]);

/*ConnectionManager::config('test', [
    'datasource' => getenv('db_datasource'),
    'persistent' => getenv('db_persistent'),
    'host' => getenv('db_host'),
    'username' => getenv('db_username'),
    'password' => getenv('db_password'),
    'database' => getenv('db_database')
]);

ConnectionManager::alias('test', 'default');
*/
