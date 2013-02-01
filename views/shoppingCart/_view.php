<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cart_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cart_id), array('view', 'id'=>$data->cart_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />


</div>
