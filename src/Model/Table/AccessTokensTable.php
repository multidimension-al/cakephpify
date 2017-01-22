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

namespace Multidimensional\Cakephpify\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccessTokens Model
 *
 * @method \Shopify\Model\Entity\AccessToken get($primaryKey, $options = [])
 * @method \Shopify\Model\Entity\AccessToken newEntity($data = null, array $options = [])
 * @method \Shopify\Model\Entity\AccessToken[] newEntities(array $data, array $options = [])
 * @method \Shopify\Model\Entity\AccessToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shopify\Model\Entity\AccessToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shopify\Model\Entity\AccessToken[] patchEntities($entities, array $data, array $options = [])
 * @method \Shopify\Model\Entity\AccessToken findOrCreate($search, callable $callback = null)
 */
class AccessTokensTable extends Table
{

    /**
     * Initialize method
     *
     * @param  array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        //$this->table('access_tokens');
        $this->displayField('token');
        //$this->primaryKey('id');

        $this->belongsTo(
            'Shops',
            [
            'className' => 'Multidimensional/Cakephpify.Shops']
        );
    }

    /**
     * Default validation rules.
     *
     * @param  \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('api_key', 'create')
            ->notEmpty('api_key');

        $validator
            ->requirePresence('shop_id', 'create')
            ->notEmpty('shop_id');

        $validator
            ->requirePresence('token', 'create')
            ->notEmpty('token')
            ->add('token', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');

        $validator
            ->dateTime('expired_at')
            ->allowEmpty('expired_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param  \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['token']));

        return $rules;
    }
}
