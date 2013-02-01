<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ordering_date'); ?>
		<?php echo $form->textField($model,'ordering_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ordering_done'); ?>
		<?php echo $form->textField($model,'ordering_done'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ordering_confirmed'); ?>
		<?php echo $form->textField($model,'ordering_confirmed'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('ShopModule.shop', 'Search)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
