<?php
$this->breadcrumbs=array(
	Shop::t('Shipping Methods')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Shop::t('Update'),
);

$this->menu=array(
	array('label'=>Shop::t('Create Shipping method'), 'url'=>array('create')),
	array('label'=>Shop::t('View Shipping method'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Shop::t('Manage Shipping methods'), 'url'=>array('admin')),
);
?>

<h2><?php echo $model->title; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
