<?php
$this->breadcrumbs=array(
	Yii::t('shop', 'Product')=>array('index'),
	Yii::t('shop', 'Create'),
);
?>

<div id="shopcontent">

	<h1><?echo Yii::t('ShopModule.shop', 'Create a new Product'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
