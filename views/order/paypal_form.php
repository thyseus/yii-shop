<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>
 
    <?php echo $form->errorSummary($model); ?>

		<h2> <?php echo Shop::t(
				'Please enter your Paypal account data to confirm the payment of your Order'); ?> </h2>

		<p> <?php echo Shop::t('The order number that will be paid is: {order_id}', array(
					'{order_id}' => $model->order_id)); ?> </p>

		<?php echo CHtml::hiddenField('order_id', $model->order_id); ?>
	
    <div class="row">
        <?php echo $form->label($model,'email'); ?>
        <?php echo $form->textField($model,'email') ?>
        <?php echo $form->error($model,'email') ?>
    </div>
 
    <div class="row submit">
        <?php echo CHtml::submitButton(Shop::t('Pay by Paypal')); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->
