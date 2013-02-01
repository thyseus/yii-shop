<?php
$this->breadcrumbs=array(
	Shop::t('Shipping methods')=>array('index'),
	Shop::t('Manage'),
);

?>

<h2> <?php echo Shop::t('Shipping methods'); ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shipping-method-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'weight_range',
		'title',
		'tax.percent',
		'price',
		array(
			'class'=>'CButtonColumn',
		),
	),
));

echo Chtml::link(Shop::t('Create new shipping method'), array(
			'//shop/shippingMethod/create')); 
?>
