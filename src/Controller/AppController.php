<?php
namespace Multidimensional\Shopify\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{

    /**
     * Initialize AppController
     *
     * @return void
    */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        //$this->loadComponent('Multidimensional/Shopify.ShopifyAPI');
	}

}
