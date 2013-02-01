<?php
$this->breadcrumbs=array(
	Shop::t('Taxes')=>array('index'),
	Shop::t('Manage'),
);

$this->menu=array(
	array('label'=>Shop::t('Create Tax'), 'url'=>array('create')),
);

?>

<h2> <?php echo Shop::t('Manage Taxes'); ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tax-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'percent',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
