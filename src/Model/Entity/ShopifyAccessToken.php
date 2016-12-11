<?php
namespace Shopify\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopifyAccessToken Entity
 *
 * @property int $id
 * @property string $domain
 * @property string $token
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 * @property \Cake\I18n\Time $expired_at
 */
class ShopifyAccessToken extends Entity
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

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
	
	
	protected function _getDomain($domain) {
        return ((substr($domain, -14) == '.myshopify.com') ? $domain : $domain.'.myshopify.com'); 
    }
	
	protected function _setDomain($domain) {
        return str_replace('.myshopify.com', '', $domain); 
    }
	
}
