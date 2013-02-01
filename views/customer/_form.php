<div class="form">

<?php
if(isset($action) && $action !== null) 
	$form=$this->beginWidget('CActiveForm', array(
				'id'=>'customer-form',
				'action' => $action,
				'enableAjaxValidation'=>false,
				)); 
else
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'enableAjaxValidation'=>false,
			)); ?>

<?php echo $form->errorSummary(array($customer, $address)); ?>

		<?php echo $form->hiddenField($customer, 'user_id', array('value'=> Yii::app()->user->id)); ?>

	<div class="row">
		<?php echo $form->labelEx($address,'title'); ?>
		<?php echo $form->dropDownList($address,'title',Shop::module()->titleOptions); ?>
		<?php echo $form->error($address,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'firstname'); ?>
		<?php echo $form->textField($address,'firstname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'lastname'); ?>
		<?php echo $form->textField($address,'lastname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($customer,'email'); ?>
		<?php echo $form->textField($customer,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($customer,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($customer,'phone'); ?>
		<?php echo $form->textField($customer,'phone',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($customer,'phone'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($address,'street'); ?>
		<?php echo $form->textField($address,'street',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'zip_city'); ?> 
		<?php echo $form->textField($address,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'zipcode'); ?>

		<?php echo $form->textField($address,'city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'city'); ?>
	</div>

	<div class="row">
		<?php echo Shop::getCountryChooser($form, $address); ?>	
	</div>

	<?php if(Shop::module()->useWithYum && $customer->isNewRecord) { ?>

	<?php echo CHtml::label(Shop::t('Register an account'), 'register'); ?>
	<?php echo CHtml::checkbox('register', true); ?>

	<div class="registration">
	<?php echo Shop::t('Enter a password to create an user account'); ?>
	<div class="row">
		<?php echo $form->labelEx($customer,'password'); ?>
		<?php echo $form->passwordField($customer,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($customer,'password'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($customer,'passwordRepeat'); ?>
		<?php echo $form->passwordField($customer,'passwordRepeat',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($customer,'passwordRepeat'); ?>
	</div>
	</div>

	<?php Yii::app()->clientScript->registerScript('registration', "
			$('#register').click(function() { 
				$('.registration').toggle(500);
				});
			") ?>


	<?php } ?>

	<div style="clear: both;"> </div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($customer->isNewRecord 
			? Shop::t('Register') 
			: Shop::t('Save')
			,array('id'=>'next')
			); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
