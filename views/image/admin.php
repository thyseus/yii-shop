<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Images') =>array('index'),
	Yii::t('ShopModule.shop', 'Manage'),
);

?>

<div id="shopcontent">

<h2> 
<?php 
echo Yii::t('ShopModule.shop', 'Images for'); 
echo '&nbsp;' . $product->title; 
?>
</h2>

<?php
if($images)
	foreach($images as $image) {
		echo "<label> {$image->title} </label><br />";
		$this->renderPartial('view', array('model' => $image));
	}


echo '<br />';

echo CHtml::link(Yii::t('ShopModule.shop', 'Cancel'), array('/shop/shop/admin')) . '<br />';
echo CHtml::link(Yii::t('ShopModule.shop', 'Upload new Image'), array('create', 'product_id' => $product->product_id));


?>
</div>
