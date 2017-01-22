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

namespace Multidimensional\Cakephpify\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class AccessTokensFixture extends TestFixture
{

    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'null' => false],
        'shop_id' => ['type' => 'integer', 'length' => 10, 'null' => false],
        'api_key' => ['type' => 'string', 'length' => 32, 'null' => false],
        'token' => ['type' => 'string', 'length' => 255, 'null' => false],
        'created_at' => ['type' => 'datetime', 'null' => false],
        'updated_at' => ['type' => 'datetime', 'null' => false],
        'expired_at' => ['type' => 'datetime', 'null' => true],
        '_constraints' => [
            'PRIMARY' => ['type' => 'primary', 'columns' => ['id']],
            'UNIQUE' => ['type' => 'unique', 'columns' => ['shop_id', 'api_key', 'token']]
        ]
    ];
}
