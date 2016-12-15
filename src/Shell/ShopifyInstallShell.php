<?php

namespace Multidimensional\Shopify\Shell;

use Cake\Core\Configure;
use Cake\Console\Shell;
use Cake\Console\Helper;
use Migrations\Migrations;

class ShopifyInstallShell extends Shell {
	
  	public function main() {

		//Lets Make This FANCY
		$this->clear();
		
		$this->_io->styles('error', ['text' => 'red']);
		$this->helper('Multidimensional/Shopify.Header')->output();
	
		$first_run = ((Configure::check('Shopify')) ? false : true);
			
		//Activate Plugin 	 	 
		if ((($first_run) ? (strtolower($this->in('Install Shopify Plugin?', ['y','n'])) == 'y') : (strtolower($this->in('Update Configuration?', ['y','n'])) == 'y'))) {
			
			$this->out();
			$this->out('Please enter your API credentials from your Shopify App page.', 2);
			Configure::write('Multidimensional/Shopify.api_key',$this->in('API Key:'));
			$this->out();
			Configure::write('Multidimensional/Shopify.shared_secret', $this->in('Shared Secret:'));
			$this->out();
			
			$scope_array = ['read_content', 'write_content', 'read_themes', 'write_themes', 'read_products', 'write_products', 'read_customers', 'write_customers', 'read_orders', 'write_orders', 'read_script_tags', 'write_script_tags', 'read_fulfillments', 'write_fulfillments', 'read_shipping', 'write_shipping', 'read_analytics', 'read_users', 'write_users'];
			
			$this->out('Enter your application\'s scope here.', 2);
			$this->out('Valid scope options:', 2);
			$this->helper('Multidimensional/Shopify.Table')->output($scope_array);
			$this->out('');
			$this->out('Separate your desired scope options with a comma.');
			
			do {
				
				$this->out('');
				$scope = $this->in('Scope:');
	
				$scope = explode(",", $scope);
	
				if (!is_array($scope)) {
					$scope = array($scope);	
				}
				$scope = array_map('trim', $scope);
				$scope = array_map('strtolower', $scope);
				array_walk($scope, function(&$value) {
					$value = str_replace(" ", "_", $value);
				});
				
				if ((count($scope)) && (strlen(trim(implode("", $scope))) > 0) && (count(array_diff($scope, $scope_array)) > 0)) {
					$this->out('');
					$this->_io->out('<error>Invalid Scope. Try again, or leave blank to continue.</error>');	
				}
			
			} while((count($scope)) && (strlen(trim(implode("", $scope))) > 0) && (count(array_diff($scope, $scope_array)) > 0));
			
			Configure::write('Multidimensional/Shopify.scope',implode(',', $scope));
			
			$this->out('');
			$is_private_app = strtolower($this->in('Is this a private app?', ['y','n']));
			
			if ($is_private_app == 'y') {
				$is_private_app = 'true';	
			} else {
				$is_private_app = 'false';
			}
			
			Configure::write('Multidimensional/Shopify.is_private_app',$is_private_app);
			
			if($is_private_app == 'true'){
				Configure::write('Multidimensional/Shopify.private_app_password',$this->in('Private App Password:'));
			}else{
				Configure::write('Multidimensional/Shopify.private_app_password', NULL);
			}
			
			Configure::dump('shopify', 'default', ['Shopify']);
			
		}
			
		$this->out('');
		
		if (($first_run) || (strtolower($this->in('Update Database?', ['y','n'])) == 'y')) {			
	
			$this->out('');
	
			$migrations = new Migrations(['plugin' => 'Shopify']);
	
			$status = $migrations->status();
	
			if ((is_array($status)) && (count($status))) {
				
				$this->out('Updating Databases',2);
			  
				if ($migrations->migrate()) {
					$this->out('Success!',2);
				} else {
					$this->_io->out('<error>Update Failed!</error>', 2);
				}
				
			} else {
				$this->out('Shopify Database Files Not Found',2);
			}
		
		}
		
	}
			
}