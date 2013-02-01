<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'image-form',
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->fileField($model,'filename',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

		<?php echo $form->hiddenField($model,'product_id', array('value' => $_GET['product_id'])); ?>

	<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord 
			? Shop::t('Upload') 
			: Shop::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
