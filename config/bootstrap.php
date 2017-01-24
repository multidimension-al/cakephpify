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

/*
 *
 *  DO NOT EDIT THIS CONFIGURATION! YOUR CHANGES WON'T SAVE THROUGH
 *  UPDATES! ONLY EDIT THE CONFIG/SHOPIFY.PHP FILE IN THE MAIN CONFIG
 *
 */

$config = ['{API_KEY_HERE}' =>
    [
      'sharedSecret' => '{SHARED_SECRET_HERE}',
      'scope' => '{SCOPE_HERE}',
      'privateApp' => '{TRUE/FALSE_HERE}',
      'privateAppPassword' => '{PRIVATE_APP_PASSWORD_HERE}'
    ]
];

if (file_exists(CONFIG . 'shopify.php')) {
    Configure::load('shopify');
} else {
    Configure::write('Multidimensional/Cakephpify', $config);
}
Plugin::load('Migrations');
