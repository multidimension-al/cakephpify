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
 
namespace Multidimensional\Shopify\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ShopsFixture extends TestFixture
{

    public $fields = [
        'id' => ['type' => ''],
        'domain' => ['type' => ''],
        'name' => ['type' => ''],
        'email' => ['type' => ''],
        'shop_owner' => ['type' => ''],
        'address1' => ['type' => ''],
        'address2' => ['type' => ''],
        'city' => ['type' => ''],
        'province_code' => ['type' => ''],
        'province' => ['type' => ''],
        'zip' => ['type' => ''],
        'country' => ['type' => ''],
        'country_code' => ['type' => ''],
        'country_name' => ['type' => ''],
        'source' => ['type' => ''],
        'phone' => ['type' => ''],
        'created_at' => ['type' => ''],
        'updated_at' => ['type' => ''],
        'customer_email' => ['type' => ''],
        'latitude' => ['type' => ''],
        'longitude' => ['type' => ''],
        'primary_location_id' => ['type' => ''],
        'primary_locale' => ['type' => ''],
        'currency' => ['type' => ''],
        'iana_timezone' => ['type' => ''],
        'money_format' => ['type' => ''],
        'money_with_currency_format' => ['type' => ''],
        'taxes_included' => ['type' => ''],
        'tax_shipping' => ['type' => ''],
        'country_taxes' => ['type' => ''],
        'plan_display_name' => ['type' => ''],
        'plan_name' => ['type' => ''],
        'has_discounts' => ['type' => ''],
        'has_gift_cards' => ['type' => ''],
        'myshopify_domain' => ['type' => ''],
        'google_apps_domain' => ['type' => ''],
        'google_apps_login_enabled' => ['type' => ''],
        'money_in_emails_format' => ['type' => ''],
        'money_with_currency_in_emails_format' => ['type' => ''],
        'eligible_for_payments' => ['type' => ''],
        'requires_extra_payments_agreement' => ['type' => ''],
        'password_enabled' => ['type' => ''],
        'has_storefont' => ['type' => ''],
        'eligible_for_card_reader_giveaway' => ['type' => ''],
        'finances' => ['type' => ''],
        'setup_required' => ['type' => ''],
        'force_ssl' => ['type' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
         ]
    ];
      
}
