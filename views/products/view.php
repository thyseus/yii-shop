<?php
$this->pageTitle = $model->title;

Yii::app()->clientScript->registerMetaTag(
		substr(strip_tags($model->description), 0, 255), 'description');

if($model->keywords)
	Yii::app()->clientScript->registerMetaTag(
			substr(strip_tags($model->keywords), 0, 255), 'keywords');


$this->breadcrumbs=array(
	Shop::t('Products')=>array('index'),
	$model->title,
);

?>

<div class="product-header">
    <h2 class="title"><?php echo $model->title; ?></h2>
    <?php printf('<h2 class="price">%s %s</h2>',
				$model->variationCount > 0 ? Shop::pricePrefix() : '',
				Shop::priceFormat($model->getPrice()));
?>
</div>

<div class="clear"></div>

<div class="product-images">
<?php 
if($model->images) {
	foreach($model->images as $image) {
		$this->renderPartial('/image/view', array( 'model' => $image));
		echo '<br />'; 
	}
} else 
$this->renderPartial('/image/view', array( 'model' => new Image()));
?>	
</div>

<div class="product-options"> 
	<?php $this->renderPartial('/products/addToCart', array(
			'model' => $model)); ?>
</div>


<div class="product-description">
	<p> <?php echo $model->description; ?> </p>
</div>


<?php 
$specs = $model->getSpecifications();
if($specs) {
	echo '<table>';
	
	printf ('<tr><td colspan="2"><strong>%s</strong></td></tr>',
			Shop::t('Product Specifications'));
			
	foreach($specs as $key => $spec) {
		if($spec != '')
			printf('<tr> <td> %s: </td> <td> %s </td> </td>',
					$key,
					$spec);
	}
	
	echo '</table>';
} 
?>
