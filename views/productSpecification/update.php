<?php
$this->breadcrumbs=array(
	Shop::t('Product Specifications')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Shop::t('Create Product specification'), 'url'=>array('create')),
	array('label'=>Shop::t('View Product specification'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Shop::t('Manage Product specifications'), 'url'=>array('admin')),
);
?>

<h2><?php echo $model->title; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
