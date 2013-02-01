<?php
$this->breadcrumbs=array(
	Shop::t('Products')=>array('index'),
	$model->title=>array('view','id'=>$model->product_id),
	Shop::t('Update'),
);

?>

<h2> <?php echo $model->title; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

