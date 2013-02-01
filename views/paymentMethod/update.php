<?php
$this->breadcrumbs=array(
	Shop::t('Payment Methods')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Shop::t('Update'),
);

$this->menu=array(
	array('label'=>'Create PaymentMethod', 'url'=>array('create')),
	array('label'=>'View PaymentMethod', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PaymentMethod', 'url'=>array('admin')),
);
?>

<h2><?php echo $model->title; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
