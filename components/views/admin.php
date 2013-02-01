<p> <?php echo Shop::t('Shop'); ?> </p>
<ul>
<li> <?php echo CHtml::link(Shop::t('Article categories'), array('//shop/category/admin')); ?> </li>
<li> <?php echo CHtml::link(Shop::t('Article specifications'), array('/shop/productSpecification/admin')); ?> </li>
<li> <?php echo CHtml::link(Shop::t('Articles'), array('/shop/products/admin')); ?> </li>
<li> <?php echo CHtml::link(Shop::t('Shipping methods'), array('/shop/shippingMethod/admin')); ?> </li>
<li> <?php echo CHtml::link(Shop::t('Payment methods'), array('/shop/paymentMethod/admin')); ?> </li>
<li> <?php echo CHtml::link(Shop::t('Tax'), array('/shop/tax/admin')); ?> </li>
<li> <?php echo CHtml::link(Shop::t('Orders'), array('/shop/order/admin')); ?> </li>

<?php if(isset(Yii::app()->controller->menu)) {
	foreach(Yii::app()->controller->menu as $value) {
		printf('<li>%s</li>', CHtml::link($value['label'], $value['url']));
	}
}
?>
</ul>

