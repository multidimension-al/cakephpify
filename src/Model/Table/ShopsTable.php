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

namespace Multidimensional\Shopify\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Shops Model
 *
 * @method \App\Model\Entity\Shop get($primaryKey, $options = [])
 * @method \App\Model\Entity\Shop newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Shop[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shop|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shop patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Shop[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shop findOrCreate($search, callable $callback = null)
 */
class ShopsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        //$this->table('shops');
        $this->displayField('myshopify_domain');
        //$this->primaryKey('id');

        $this->hasMany('AccessTokens', [
            'className' => 'Multidimensional/Shopify.AccessTokens'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('domain', 'create')
            ->notEmpty('domain');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('shop_owner', 'create')
            ->notEmpty('shop_owner');

        $validator
            ->requirePresence('address1', 'create')
            ->notEmpty('address1');

        $validator
            ->requirePresence('address2', 'create')
            ->notEmpty('address2');

        $validator
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->requirePresence('province_code', 'create')
            ->notEmpty('province_code');

        $validator
            ->requirePresence('province', 'create')
            ->notEmpty('province');

        $validator
            ->requirePresence('zip', 'create')
            ->notEmpty('zip');

        $validator
            ->requirePresence('country', 'create')
            ->notEmpty('country');

        $validator
            ->requirePresence('country_code', 'create')
            ->notEmpty('country_code');

        $validator
            ->requirePresence('country_name', 'create')
            ->notEmpty('country_name');

        $validator
            ->allowEmpty('source');

        $validator
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');

        $validator
            ->requirePresence('customer_email', 'create')
            ->allowEmpty('customer_email');

        $validator
            ->decimal('latitude')
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->decimal('longitude')
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->requirePresence('primary_locale', 'create')
            ->notEmpty('primary_locale');

        $validator
            ->requirePresence('currency', 'create')
            ->notEmpty('currency');

        $validator
            ->requirePresence('iana_timezone', 'create')
            ->notEmpty('iana_timezone');

        $validator
            ->requirePresence('money_format', 'create')
            ->notEmpty('money_format');

        $validator
            ->requirePresence('money_with_currency_format', 'create')
            ->notEmpty('money_with_currency_format');

        $validator
            ->boolean('taxes_included')
            ->allowEmpty('taxes_included');

        $validator
            ->boolean('tax_shipping')
            ->allowEmpty('tax_shipping');

        $validator
            ->boolean('county_taxes')
            ->allowEmpty('county_taxes');

        $validator
            ->requirePresence('plan_display_name', 'create')
            ->notEmpty('plan_display_name');

        $validator
            ->requirePresence('plan_name', 'create')
            ->notEmpty('plan_name');

        $validator
            ->boolean('has_discounts')
            ->allowEmpty('has_discounts');

        $validator
            ->boolean('has_gift_cards')
            ->allowEmpty('has_gift_cards');

        $validator
            ->requirePresence('myshopify_domain', 'create')
            ->notEmpty('myshopify_domain');

        $validator
            ->allowEmpty('google_apps_domain');

        $validator
            ->allowEmpty('google_apps_login_enabled');

        $validator
            ->requirePresence('money_in_emails_format', 'create')
            ->notEmpty('money_in_emails_format');

        $validator
            ->requirePresence('money_with_currency_in_emails_format', 'create')
            ->notEmpty('money_with_currency_in_emails_format');

        $validator
            ->boolean('eligible_for_payments')
            ->allowEmpty('eligible_for_payments');

        $validator
            ->boolean('requires_extra_payments_agreement')
            ->allowEmpty('requires_extra_payments_agreement');

        $validator
            ->boolean('password_enabled')
            ->allowEmpty('password_enabled');

        $validator
            ->boolean('has_storefront')
            ->allowEmpty('has_storefront');

        $validator
            ->boolean('eligible_for_card_reader_giveaway')
            ->allowEmpty('eligible_for_card_reader_giveaway');

        $validator
            ->boolean('finances')
            ->allowEmpty('finances');

        $validator
            ->boolean('setup_required')
            ->allowEmpty('setup_required');

        $validator
            ->boolean('force_ssl')
            ->allowEmpty('force_ssl');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
