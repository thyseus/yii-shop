<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Images') =>array('index'),
	Yii::t('ShopModule.shop', 'Upload'),
);

?>

<div id="shopcontent">

	<h2> <?php Yii::t('ShopModule.shop', 'Upload Image'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
