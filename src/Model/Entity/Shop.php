<?php
namespace Multidimensional\Shopify\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shop Entity
 *
 * @property int $id
 * @property string $domain
 * @property string $name
 * @property string $email
 * @property string $shop_owner
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $province_code
 * @property string $province
 * @property string $zip
 * @property string $country
 * @property string $country_code
 * @property string $country_name
 * @property string $source
 * @property string $phone
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 * @property string $customer_email
 * @property float $latitude
 * @property float $longitude
 * @property int $primary_location_id
 * @property string $primary_locale
 * @property string $currency
 * @property string $iana_timezone
 * @property string $money_format
 * @property string $money_with_currency_format
 * @property bool $taxes_included
 * @property bool $tax_shipping
 * @property bool $county_taxes
 * @property string $plan_display_name
 * @property string $plan_name
 * @property bool $has_discounts
 * @property bool $has_gift_cards
 * @property string $myshopify_domain
 * @property string $google_apps_domain
 * @property string $google_apps_login_enabled
 * @property string $money_in_emails_format
 * @property string $money_with_currency_in_emails_format
 * @property bool $eligible_for_payments
 * @property bool $requires_extra_payments_agreement
 * @property bool $password_enabled
 * @property bool $has_storefront
 * @property bool $eligible_for_card_reader_giveaway
 * @property bool $finances
 * @property bool $setup_required
 * @property bool $force_ssl
 */
class Shop extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
	
	protected function _getDomain($domain) {
        return ((substr($domain, -14) == '.myshopify.com') ? $domain : $domain.'.myshopify.com'); 
    }
	
	protected function _setDomain($domain) {
        return str_replace('.myshopify.com', '', $domain); 
    }
	
}
