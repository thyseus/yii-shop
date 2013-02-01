<?php
$this->breadcrumbs=array(
	'Images'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('ShopModule.shop', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('ShopModule.shop', 'List') . 'Image', 'url'=>array('index')),
	array('label'=>Yii::t('ShopModule.shop', 'Create') . 'Image', 'url'=>array('create')),
	array('label'=>Yii::t('ShopModule.shop', 'View') . 'Image', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('ShopModule.shop', 'Manage') . 'Image', 'url'=>array('admin')),
);
?>

<h2>Bearbeite Image <?php echo $model->id; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
