<?php
namespace Multidimensional\Shopify\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopifyAccessTokens Model
 *
 * @method \Shopify\Model\Entity\ShopifyAccessToken get($primaryKey, $options = [])
 * @method \Shopify\Model\Entity\ShopifyAccessToken newEntity($data = null, array $options = [])
 * @method \Shopify\Model\Entity\ShopifyAccessToken[] newEntities(array $data, array $options = [])
 * @method \Shopify\Model\Entity\ShopifyAccessToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shopify\Model\Entity\ShopifyAccessToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shopify\Model\Entity\ShopifyAccessToken[] patchEntities($entities, array $data, array $options = [])
 * @method \Shopify\Model\Entity\ShopifyAccessToken findOrCreate($search, callable $callback = null)
 */
class ShopifyAccessTokensTable extends Table
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

        $this->table('shopify_access_tokens');
        $this->displayField('id');
        $this->primaryKey('id');
		
		$this->belongsTo('ShopifyShops', [
				'foreignKey' => 'domain',
				'bindingKey' => 'domain']);
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['token']));

        return $rules;
    }
}
