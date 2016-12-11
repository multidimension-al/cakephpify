<?php
namespace Shopify\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table {

	public function initialize(array $config) {
    	$this->table('ShopifyAccessTokens');
    }	
	
}