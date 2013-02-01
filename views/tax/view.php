<?php
$this->breadcrumbs=array(
	Shop::t('Taxes')=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Create Tax', 'url'=>array('create')),
	array('label'=>'Update Tax', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tax', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tax', 'url'=>array('admin')),
);
?>

<h2><?php echo $model->title; ?></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'percent',
	),
)); ?>
