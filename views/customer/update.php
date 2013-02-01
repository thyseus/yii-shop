<?php
$this->breadcrumbs=array(
Shop::t('Update Customer Information')
);

?>
<h2> <?php echo Shop::t('Update Customer Information'); ?> </h2>

<?php echo $this->renderPartial('_form', array(
			'customer'=>$customer,
			'address' => $address, 
			'deliveryAddress' => $deliveryAddress,
			'billingAddress' => $billingAddress,
			)); ?>
