<?php
use Cake\Core\Plugin;
use Cake\Core\Configure;

/*
 *
 *  DO NOT EDIT THIS CONFIGURATION! YOUR CHANGES WON'T SAVE THROUGH
 *  UPDATES! ONLY EDIT THE CONFIG/SHOPIFY.PHP FILE IN THE MAIN CONFIG
 *
 */
 
$config = array (
    'api_key' => '',
    'shared_secret' => '',
    'scope' => '',
    'is_private_app' => '');

if (file_exists(CONFIG . 'shopify.php')) {
  Configure::load('shopify');
} else {
  Configure::write('Multidimensional/Shopify', $config);
}
Plugin::load('Migrations');

?>