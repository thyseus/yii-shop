<?php
$this->breadcrumbs=array(
	Shop::t('Orders')=>array('index'),
	$model->order_id=>array('view','id'=>$model->order_id),
	Shop::t('Update status'),
);

?>
<h2> <?php echo Shop::t('Update status of Order'); echo $model->order_id; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
