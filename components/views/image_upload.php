<?php echo CHtml::beginForm(
		array('//shop/shoppingCart/create'), 'POST', array(
'enctype' => 'multipart/form-data'
)); ?>

<?php
if(count($products) == 1) {
	echo Shop::t('Product').': ';
	echo $products[0]->title;
}
else {
	echo '<span class="step-1">1. </span><strong>'.Shop::t('Select a Product').': </strong>';
	echo CHtml::dropDownList('product',
			0,
			CHtml::listData($products, 'product_id', 'title')); 
}
?>
<hr />

<div id="please_select_a_image" style="display: none;"> 
<?php echo Shop::t( 'Please select a image from your hard drive'); ?>
</div>

<strong> <?php	echo '<span class="step-2">2. </span> ' . CHtml::label( Shop::t(
			'Filename'), 'filename' ); ?> </strong>
<?php	echo CHtml::fileField( 'filename'); ?>
<br />
<span class="step-3" style="float: left;">3.&nbsp;</span><div id="variations"></div>
<div style="clear:both;"></div>

<div id="image_upload_loading" style="display: none;"> 
<?php echo CHtml::image(Yii::app()->assetManager->publish(
			Yii::getPathOfAlias('application.modules.shop.assets').'/loading.gif')); ?>
<br />
<?php echo Shop::t('Please wait while your image is being uploaded'); ?>
</div>

<?php
echo '<div style="clear: both;"></div>';
if($ask_for_amount) {
echo '<div class="shop-variation-amount">';
echo '<strong>'.CHtml::label(Shop::t('Amount'), 'ShoppingCart_amount').'</strong>';
echo ': ';
echo CHtml::textField('amount', 1, array('size' => 3));
echo '</div>';
} else echo CHtml::hiddenField('amount', 1);

echo CHtml::submitButton(
		Shop::t('Add to shopping Cart'), array(
			'id' => 'btn-add-to-cart',
			'class' => 'btn-add-cart'));
			
echo '<div style="clear: both;"></div>';
?>

<hr />

<?php echo CHtml::endForm(); ?>

<?php
Yii::app()->clientScript->registerScript('btn-add-to-cart', "
		$('#btn-add-to-cart').click(function() {
			if($('input[type=file]').val()) {
			$('#image_upload_loading').show();
			} else {
			$('#please_select_a_image').show();

			event.preventDefault();
			}
			});
		");

if(count($products) > 1) {
	Yii::app()->clientScript->registerScript('product_selection', "
			$('#variations').load('".Yii::app()->controller->createUrl(
		'//shop/products/getVariations')."',
				{'product': $('#product').val() });

			$('#product').change(function() {
				$('#variations').load('".Yii::app()->controller->createUrl(
				'//shop/products/getVariations')."', $(this));
				});
			", CClientScript::POS_READY);
}
?>
