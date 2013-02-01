<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Shop')=>array('shop/index'),
	Yii::t('ShopModule.shop', 'Categories')=>array('index'),
	$model->title,
);

?>

<h2> <?php echo $model->title; ?></h2>

<?php
	foreach($model->Products as $product) {
		$this->renderPartial('/products/_view', array('data' => $product));
}
?>


<div class="clear"> </div>


