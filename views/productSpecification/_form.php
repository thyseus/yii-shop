<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-specification-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo Shop::requiredFieldNote(); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'required'); ?>
		<?php echo $form->checkBox($model,'required'); ?>
		<?php echo $form->error($model,'required'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'input_type'); ?>
		<?php echo $form->dropDownList($model,'input_type', array(
					'none' => Shop::t('None'),
					'select' => Shop::t('Selection'),
					'textfield' => Shop::t('Text field'),
					'image' => Shop::t('Image upload'),
					)); ?>
		<?php echo $form->error($model,'input_type'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord 
			? Shop::t('Create') 
			: Shop::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
