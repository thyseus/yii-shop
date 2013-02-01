<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->order_id), array('view', 'id'=>$data->order_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering_date')); ?>:</b>
	<?php echo CHtml::encode($data->ordering_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering_done')); ?>:</b>
	<?php echo CHtml::encode($data->ordering_done); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering_confirmed')); ?>:</b>
	<?php echo CHtml::encode($data->ordering_confirmed); ?>
	<br />


</div>
