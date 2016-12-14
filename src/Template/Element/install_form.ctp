<?php 
	echo $this->Form->create(false, array('url'=>'/shopify/install'));
	echo $this->Form->input('shop_domain', array( 'placeholder'=>'your-store.myshopify.com', 'label' => 'Enter your Shop Domain:' ));
	echo $this->Form->button('Go', ['type' => 'submit']);
	echo $this->Form->end();
?>
