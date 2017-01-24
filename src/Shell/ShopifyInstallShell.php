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


namespace Multidimensional\Cakephpify\Shell;

use Cake\Console\Helper;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Migrations\Migrations;

class ShopifyInstallShell extends Shell
{

    /**
     * @return void
     */
    public function main()
    {
        $this->clear();

        $this->_io->styles('error', ['text' => 'red']);
        $this->helper('Multidimensional/Cakephpify.Header')->output();

        $firstRun = ((Configure::check('Multidimensional/Cakephpify')) ? false : true);

        //Activate Plugin
        if ((($firstRun) ? (strtolower($this->in('Install Shopify Plugin?', ['y', 'n'])) == 'y') : (strtolower($this->in('Update Configuration?', ['y', 'n'])) == 'y'))
        ) {
            $this->out();
            $this->out('Please enter your API credentials from your Shopify App page.', 2);
            $apiKey = $this->in('API Key:');
            $this->out();

            Configure::write('Multidimensional/Cakephpify.' . $apiKey . '.sharedSecret', $this->in('Shared Secret:'));

            $this->out();

            $scopeArray =
                ['read_content',
                 'write_content',
                 'read_themes',
                 'write_themes',
                 'read_products',
                 'write_products',
                 'read_customers',
                 'write_customers',
                 'read_orders',
                 'write_orders',
                 'read_script_tags',
                 'write_script_tags',
                 'read_fulfillments',
                 'write_fulfillments',
                 'read_shipping',
                 'write_shipping',
                 'read_analytics',
                 'read_users',
                 'write_users'];

            $this->out('Enter your application\'s scope here.', 2);
            $this->out('Valid scope options:', 2);
            $this->helper('Multidimensional/Cakephpify.Table')->output($scopeArray);
            $this->out('');
            $this->out('Separate your desired scope options with a comma.');

            do {
                $this->out('');
                $scope = $this->in('Scope:');

                $scope = explode(",", $scope);

                if (!is_array($scope)) {
                    $scope = [$scope];
                }
                $scope = array_map('trim', $scope);
                $scope = array_map('strtolower', $scope);
                array_walk(
                    $scope,
                    function (&$value) {
                        $value = str_replace(" ", "_", $value);
                    }
                );

                if ((count($scope)) && (strlen(trim(implode("", $scope))) > 0) && (count(array_diff($scope, $scopeArray)) > 0)) {
                    $this->out('');
                    $this->_io->out('<error>Invalid Scope. Try again, or leave blank to continue.</error>');
                }

                $count = count($scope);
                $scopeLength = strlen(trim(implode("", $scope)));
                $scopeDiffCount = count(array_diff($scope, $scopeArray));
            } while ($count && $scopeLength > 0 && $scopeDiffCount > 0);

            Configure::write('Multidimensional/Cakephpify.' . $apiKey . '.scope', implode(',', $scope));

            $this->out('');
            $isPrivateApp = strtolower($this->in('Is this a private app?', ['y', 'n']));

            if ($isPrivateApp == 'y') {
                $isPrivateApp = 'true';
            } else {
                $isPrivateApp = 'false';
            }


            Configure::write('Multidimensional/Cakephpify.' . $apiKey . '.privateApp', $isPrivateApp);

            if ($isPrivateApp == 'true') {
                Configure::write('Multidimensional/Cakephpify.' . $apiKey . '.privateAppPassword', $this->in('Private App Password:'));
            } else {
                Configure::write('Multidimensional/Cakephpify.' . $apiKey . '.privateAppPassword', null);
            }

            Configure::dump('shopify', 'default', ['Multidimensional/Cakephpify']);
        }

        $this->out('');

        if (($firstRun) || (strtolower($this->in('Update Database?', ['y', 'n'])) == 'y')) {
            $this->out('');

            $migrations = new Migrations(['plugin' => 'Multidimensional/Cakephpify']);

            $status = $migrations->status();

            if ((is_array($status)) && (count($status))) {
                $this->out('Updating Databases', 2);

                if ($migrations->migrate()) {
                    $this->out('Success!', 2);
                } else {
                    $this->_io->out('<error>Update Failed!</error>', 2);
                }
            } else {
                $this->out('Shopify Database Files Not Found', 2);
            }
        }
    }
}
