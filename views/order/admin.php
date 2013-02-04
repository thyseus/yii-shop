
<?php
if($this->breadcrumbs)
	$this->breadcrumbs=array(
			Shop::t('Orders')=>array('admin'),
			Shop::t('Manage'),
			);
?>

<h2> <?php echo Shop::t('Orders'); ?> </h2>
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'order_id',
		'customer.address.firstname',
		'customer.address.lastname',
		array(
			'name' => 'ordering_date',
			'value' => 'date(Shop::module()->dateFormat, $data->ordering_date)',
			'filter' => false
			),
		array(
			'name' => 'delivery_date',
			'value' => 'date(Shop::module()->dateFormat, $data->delivery_date)',
			'filter' => false,
			'visible' => Shop::module()->deliveryTimes !== false
			),
		array(
			'name' => 'delivery_time',
			'value' => '$data->getDeliveryTime()',
			'filter' => Shop::module()->deliveryTimes,
			'visible' => Shop::module()->deliveryTimes !== false
			),
		array(
			'name' => 'status',
			'value' => 'Shop::t($data->status)',
			'filter' => Order::statusOptions(),
			), 
		array(
			'class'=>'CButtonColumn', 
			'template' => '{view}',
		),

	),
)); ?>
