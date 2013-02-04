<?php
$this->renderPartial('/order/waypoint', array('point' => 4));

$this->breadcrumbs=array(
		Shop::t('Order')=>array('index'),
		Shop::t('New Order'),
		);
?>

<?php 
Shop::renderFlash();
echo CHtml::beginForm(array('//shop/order/confirm'));
echo '<h2>'.Shop::t('Confirmation').'</h2>';

if(Shop::getCartContent() == array())
	return false;

	// If the customer is not passed over to the view, we assume the user is 
	// logged in and we fetch the customer data from the customer table
if(!isset($customer))
	$customer = Shop::getCustomer();
	$this->renderPartial('application.modules.shop.views.customer.view', array(
				'model' => $customer,
				'hideAddress' => true,
				'hideEmail' => true));
echo '<br />';
echo '<hr />';
				
echo '<p>';

$shipping = ShippingMethod::model()->find('id = :id', array(
			':id' => Yii::app()->user->getState('shipping_method')));

	echo '<strong>'.Shop::t('Shipping Method').': </strong>'.' '.$shipping->title.' ('.$shipping->description.')';
	echo '<br />';
	echo CHtml::link(Shop::t('Edit shipping method'), array(
			'//shop/shippingMethod/choose', 'order' => true));
			echo '</p>';

echo '<p>';
	$payment = 	PaymentMethod::model()->findByPk(Yii::app()->user->getState('payment_method'));
	echo '<strong>'.Shop::t('Payment method').': </strong>'.' '.$payment->title.' ('.$payment->description.')';	
	echo '<br />';
	echo CHtml::link(Shop::t('Edit payment method'), array(
			'//shop/paymentMethod/choose', 'order' => true));
echo '</p>';


$deliveryTimes = Shop::module()->deliveryTimes;
if($deliveryTimes) {
echo '<p>';
echo '<strong>'.Shop::t('Delivery Date').': </strong>'. date(Shop::module()->dateFormat, $order->delivery_date );
	echo '<br />';
echo '<strong>'.Shop::t('Preferred time').': </strong>'. $deliveryTimes[$order->delivery_time];
	echo '<br />';
	echo CHtml::link(Shop::t('Edit delivery date'), array(
			'//shop/shippingMethod/choose', 'order' => true));
echo '</p>';
}

echo '<hr />';


$this->renderPartial('application.modules.shop.views.shoppingCart.view'); 

echo '<h3>'.Shop::t('Please add additional comments to the order here').'</h3>'; 
echo CHtml::textArea('Order[Comment]',
	@Yii::app()->user->getState('order_comment'), array(
		'class' => 'order_comment'));

echo '<br /><br />';

echo '<hr />';

$this->renderPartial(Shop::module()->termsView);

?>

<div class="row buttons">
<?php echo CHtml::submitButton(
		Shop::t('Confirm Order'),array (
			'id'=>'next'), array('//shop/order/confirm')); ?>
</div>
<?php echo CHtml::endForm(); ?>
