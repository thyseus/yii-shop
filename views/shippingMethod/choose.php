<?php
$this->renderPartial('/order/waypoint', array('point' => 2));

if(!isset($customer))
	$customer = new Customer;

if($customer->address === NULL)
	$this->redirect(array('//shop/customer/create'));

	if(!isset($deliveryAddress))
if(isset($customer->deliveryAddress))
	$deliveryAddress = $customer->deliveryAddress;
	else
	$deliveryAddress = new DeliveryAddress;

if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Order'),
			Shop::t('Shipping method'));

$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'action' => array('//shop/order/create'),
			'enableAjaxValidation'=>false,
			)); 
?>

<h2> <?php echo Shop::t('Shipping options'); ?> </h2>

<h3> <?php echo Shop::t('Shipping address'); ?></h3>

<div class="current_address">
<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$customer->address,
			'htmlOptions' => array('class' => 'detail-view'),
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
<br/>
<?php
echo CHtml::checkBox('toggle_delivery',
		$customer->deliveryAddress !== NULL, array(
			'style' => 'float: left')); 
echo CHtml::label(
		Shop::t('alternative delivery address'), 'toggle_delivery', array(
			'style' => 'cursor:pointer'));

?>

<div class="form">
<fieldset id="delivery_information" style="display: none;">
<div class="payment_address">

<h3> <?php echo Shop::t('new shipping address'); ?> </h3>
<p><?php echo Shop::t('Shipping new address'); ?></p>

<div class="row">
<?php echo $form->labelEx($deliveryAddress,'title'); ?>
<?php echo $form->textField($deliveryAddress,'title',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($deliveryAddress,'title'); ?>
</div>


<div class="row">
<?php echo $form->labelEx($deliveryAddress,'firstname'); ?>
<?php echo $form->textField($deliveryAddress,'firstname',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($deliveryAddress,'firstname'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($deliveryAddress,'lastname'); ?>
<?php echo $form->textField($deliveryAddress,'lastname',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($deliveryAddress,'lastname'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($deliveryAddress,'street'); ?>
<?php echo $form->textField($deliveryAddress,'street',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($deliveryAddress,'street'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($deliveryAddress,'city'); ?>
<?php echo $form->textField($deliveryAddress,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
<?php echo $form->error($deliveryAddress,'zipcode'); ?>

<?php echo $form->textField($deliveryAddress,'city',array('size'=>32,'maxlength'=>45)); ?>
<?php echo $form->error($deliveryAddress,'city'); ?>
</div>

<div class="row">
<?php echo Shop::getCountryChooser($form, $deliveryAddress); ?>	
</div>
</div>
</fieldset>
<br />
<hr />  
<h3> <?php echo Shop::t('Shipping Method'); ?> </h3>
<p> <?php echo Shop::t('Choose your Shipping method'); ?> </p>

<?php
$i = 0;

$methods = array();
foreach(ShippingMethod::model()->findAll() as $method) {
	$weight = Shop::getWeightTotal();
	if($method->weight_range === null || $method->weight_range == '') 
		$methods[$method->id] = $method;
	else {
		$range = explode('-', $method->weight_range);
		if(isset($range[0]) 
				&& isset($range[1]) 
				&& is_numeric($range[0]) 
				&& is_numeric($range[1])) {
			if($range[0] <= $weight && $range[1] >= $weight)
				$methods[$method->id] = $method;
		}
	}
}

foreach($methods as $method) {
	echo '<div class="row">';
	echo CHtml::radioButton("ShippingMethod", $i == 0, array(
				'value' => $method->id));
	echo '<div class="float-left shipping_method">';
	echo CHtml::label($method->title, 'ShippingMethod');
	echo CHtml::tag('p', array(), $method->description);
	echo CHtml::tag('p', array(),
			Shop::t('Price: ') . Shop::priceFormat($method->getPrice()));
	echo '</div>';
	echo '</div>';
	echo '<div class="clear"></div>';
	$i++;
}
?>

<?php if(Shop::module()->deliveryTimes) { ?>
<h3> <?php echo Shop::t('Delivery Date'); ?> </h3>
<p> <?php echo Shop::t('Choose your delivery date'); ?> </p>

<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Order[delivery_date]',
			'value' => date(Shop::module()->dateFormat, time() + 3*86400),
			'language' => Yii::app()->language,
			'options'=>array(
				'showAnim'=>'fold',
				'changeYear' => true,
				'changeMonth' => true,
				'closeText' => Shop::t('Apply'),
				'minDate' => +3,
				),
			));
?>

<p> <?php echo Shop::t('Choose your preferred time'); ?> </p>

<?php echo CHtml::dropDownList('Order[delivery_time]', 0,
		Shop::module()->deliveryTimes); ?>

<?php } ?>

<?php
Yii::app()->clientScript->registerScript('toggle', "
		if($('#toggle_delivery').attr('checked'))
		$('#delivery_information').show();
		$('#toggle_delivery').click(function() { 
			$('#delivery_information').toggle(500);
			});
		");
?>

<div class="row buttons">
<?php
echo CHtml::submitButton(Shop::t('Continue'),array('id'=>'next'));
?>
</div>
</div>
<?php $this->endWidget(); ?>
