<?php
namespace Shopify\Config;

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin('Shopify', ['path' => '/shopify'], function ($routes) {
    $routes->connect('/:controller');
});
