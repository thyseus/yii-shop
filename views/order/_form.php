<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id', array('disabled' => 'true')); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', Order::statusOptions()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<?php echo CHtml::checkBox('SendConfirmationMessage'); ?>
	<?php echo CHtml::label(Shop::t('Send a confirmation message to the customer'), 'SendConfirmationMessage'); ?>
	<div class="row confirmation" style="display: none;">
	<?php echo CHtml::label(Shop::t('Confirmation message'), 'ConfirmationMessage'); ?>
	<?php echo CHtml::textArea('ConfirmationMessage',
 Shop::confirmationMessage($model), array('cols' => 50, 'rows' => 10)); ?>
	</div>
	<div class="row buttons">
	<?php echo CHtml::submitButton(Shop::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
	Yii::app()->clientScript->registerScript('confirmation_message', "
	$('#SendConfirmationMessage').click(function() {
	$('.confirmation').toggle(500);
});
")
?>
