<?php
namespace Shopify\Controller;

class InstallController extends AppController {
  
  public function index() {
  
  }
  
  public function go() {
	  
	  if (empty($this->data['shop_domain'])) {
			$this->render('index');
	  } else {
			$redirect_url = Router::url(array('controller'=> 'install', 'action' => 'index', 'plugin' => 'Shopify'), true);
			$auth_url = $this->ShopifyAuth->getAuthorizeUrl($this->data['shop_domain'], $redirect_url);
			$this->redirect($auth_url);
	  }
	  
  }
  
}

?>
