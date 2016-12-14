<?php
namespace Shopify\Config;

use Cake\Routing\Router;

Router::plugin('Shopify', ['path' => '/shopify'], function ($routes) {
	$routes->connect('/install/:id', ['controller' => 'Install', 'action' => 'validate'], ['id' => '[0-9a-f]{32}', 'pass' => ['id']]);
    $routes->connect('/:controller');
});
