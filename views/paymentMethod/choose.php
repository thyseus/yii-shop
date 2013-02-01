<?php
Shop::register('css/shop.css');
$this->renderPartial('/order/waypoint', array('point' => 3));

if(!isset($customer))
	$customer = new Customer;

if($customer->address === NULL)
	$this->redirect(array('//shop/customer/create'));

	if(!isset($billingAddress))
		if(isset($customer->billingAddress))
			$billingAddress = $customer->billingAddress;
		else
			$billingAddress = new BillingAddress;

if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Order'),
			Shop::t('Payment method'));
			
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'action' => array('//shop/order/create'),
			'enableAjaxValidation'=>false,
			)); 
?>

<h2><?php echo Shop::t('Payment method'); ?></h2>
<h3><?php echo Shop::t('Billing address'); ?></h3>
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
echo CHtml::checkBox('toggle_billing',
			$customer->billingAddress !== NULL, array(
				'style' => 'float: left')); 
echo CHtml::label(Shop::t('alternative billing address'),
		'toggle_billing', array(
			'style' => 'cursor:pointer'));
?>
<div class="form">
	<fieldset id="billing_information" style="display: none;" >
        <div class="payment_address">
        
        	<h3> <?php echo Shop::t('new payment address'); ?> </h3>
            <p><?php echo Shop::t('Shipping new address'); ?></p>
        
            <div class="row">
                <?php echo $form->labelEx($billingAddress,'title'); ?>
                <?php echo $form->textField($billingAddress,'title',array('size'=>45,'maxlength'=>45)); ?>
                <?php echo $form->error($billingAddress,'title'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($billingAddress,'firstname'); ?>
                <?php echo $form->textField($billingAddress,'firstname',array('size'=>45,'maxlength'=>45)); ?>
                <?php echo $form->error($billingAddress,'firstname'); ?>
            </div>
        
            <div class="row">
                <?php echo $form->labelEx($billingAddress,'lastname'); ?>
                <?php echo $form->textField($billingAddress,'lastname',array('size'=>45,'maxlength'=>45)); ?>
                <?php echo $form->error($billingAddress,'lastname'); ?>
            </div>
        
            <div class="row">
                <?php echo $form->labelEx($billingAddress,'street'); ?>
                <?php echo $form->textField($billingAddress,'street',array('size'=>45,'maxlength'=>45)); ?>
                <?php echo $form->error($billingAddress,'street'); ?>
            </div>
        
            <div class="row">
                <?php echo $form->labelEx($billingAddress,'city'); ?>
                <?php echo $form->textField($billingAddress,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
                <?php echo $form->error($billingAddress,'zipcode'); ?>
        
                <?php echo $form->textField($billingAddress,'city',array('size'=>32,'maxlength'=>45)); ?>
                <?php echo $form->error($billingAddress,'city'); ?>
            </div>
        
				
            <div class="row">
							<?php echo Shop::getCountryChooser($form, $billingAddress); ?>	
            </div>
		</div>
   </fieldset>
<br />
<hr />  
<h3> <?php echo Shop::t('Payment method'); ?> </h3>
<p> <?php echo Shop::t('Choose your Payment method'); ?> </p>

<?php
$i = 0;
	echo '<fieldset>';
foreach(PaymentMethod::model()->findAll() as $method) {
	echo '<div class="row">';
	echo CHtml::radioButton("PaymentMethod", $i == 0, array(
				'value' => $method->id));
	echo CHtml::tag('p', array(
				'class' => 'shop_selection',
				'onClick' => "
				$(\"input[name='PaymentMethod'][value='".$method->id."']\").attr('checked','checked');"),
			$method->title . '<br />'.$method->description);
	echo '</div>';
	echo '<div class="clear"></div>';
	$i++;
}
	echo '</fieldset>';
	?>


<div class="row buttons">
<?php echo CHtml::submitButton(Shop::t('Continue'),array('id'=>'next')); ?>
</div>

<?php
echo '</div>';
$this->endWidget(); 
?>

<?php
Yii::app()->clientScript->registerScript('toggle', "
	if($('#toggle_billing').attr('checked'))
		$('#billing_information').show();

	$('#toggle_billing').click(function() { 
		$('#billing_information').toggle(500);
	});
"); 
