<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Categories')=>array('index'),
	$model->title=>array('view','id'=>$model->category_id),
	Yii::t('ShopModule.shop', 'Update'),
);

?>

<h1><?php echo Yii::t('ShopModule.shop', 'Update Category'); ?> <?php echo $model->category_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
