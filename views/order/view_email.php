<?php Shop::register('css/shop.css'); ?>

<h2> <?php echo Shop::t('Order') ?> #<?php echo $model->order_id; ?></h2>

<h3> <?php echo Shop::t('Ordering Info'); ?> </h3>

<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'order_id',
				'customer_id',
				'comment',
				array(
					'label' => Shop::t('Ordering Date'),
					'value' => date('d. m. Y G:i',$model->ordering_date)
					),
				array(
					'label' => Shop::t('Status'),
					'value' => Shop::t($model->status), 
					)
				)
			)
		); 

?>

<h3> <?php echo Shop::t('Customer Info'); ?> </h3>

<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model->customer,
			'attributes'=>array(
				'email',
				),
			)); ?>

<div class="summary_delivery_address">
<h3> <?php echo Shop::t('Delivery address'); ?> </h3>
<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model->deliveryAddress,
			'attributes'=>array(
				'title',
				'firstname',
				'lastname',
				'street',
				'zipcode',
				'city',
				'country'
				),
			)); ?>
</div>

<div class="summary_billing_address">
<h3> <?php echo Shop::t('Billing address'); ?> </h3>
<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model->billingAddress,
			'attributes'=>array(
				'firstname',
				'title',
				'lastname',
				'street',
				'zipcode',
				'city',
				'country'
				),
			)); ?>
</div>

<?php 
$this->renderPartial('/paymentMethod/view', array(
			'model' => $model->paymentMethod)); 
$this->renderPartial('/shippingMethod/view', array(
			'model' => $model->shippingMethod)); 
?>


<h3> <?php echo Shop::t('Ordered Products'); ?> </h3>

<?php
if($model->positions)
foreach($model->positions as $position) {
	$this->renderPartial('position', array(
				'position' => $position));
}
	echo '<hr />';

?>

<div style="clear:both;"> </div>
