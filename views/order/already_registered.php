<?php
	if(!isset($this->breadcrumbs))
		$this->breadcrumbs = array(
Shop::t('Shop'),
Shop::t('already registered'));
?>

<?php
echo CHtml::link(Shop::t('I am a new customer'), array(
			'//shop/order/create', 'customer' => 'new'));
echo '<br />';
echo CHtml::link(Shop::t('I am a customer already'), Shop::module()->loginUrl);

