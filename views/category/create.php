<?php
$this->breadcrumbs=array(
		Yii::t('ShopModule.shop', 'Categories')=>array('index'),
		Yii::t('ShopModule.shop', 'Create'),
		);

?>
<div id="shopcontent">

<h1> <?php echo Yii::t('ShopModule.shop', 'Create Category'); ?> </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
