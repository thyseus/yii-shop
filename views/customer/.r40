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
		<?php echo $form->labelEx($address,'street'); ?>
		<?php echo $form->textField($address,'street',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'city'); ?>
		<?php echo $form->textField($address,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'zipcode'); ?>

		<?php echo $form->textField($address,'city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'country'); ?>
		<?php echo $form->textField($address,'country',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'country'); ?>
	</div>

	<div style="clear: both;"> </div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($customer->isNewRecord 
			? Yii::t('ShopModule.shop', 'Register') 
			: Yii::t('ShopModule.shop', 'Save')
			,array('id'=>'next')
			); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
