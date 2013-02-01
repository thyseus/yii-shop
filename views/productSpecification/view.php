<?php
$this->breadcrumbs=array(
	Shop::t('Product Specifications')=>array('admin'),
	$model->title,
);

$this->menu=array(
		array('label'=>Shop::t('Create Product specification'),
			'url'=>array('create')),
		array('label'=>Shop::t('Update Product specification')
			,'url'=>array('update', 'id'=>$model->id)),
		array('label'=>Shop::t('Delete Product specification'), 
			'url'=>'#',
			'linkOptions'=>array(
				'submit'=>array('delete','id'=>$model->id),
				'confirm'=>Shop::t('Are you sure you want to delete this product specification?'))),
		array('label'=>Shop::t('Manage Product specifications'),
			'url'=>array('admin')),
		);
?>

<h2> <?php echo Shop::t('Product specification'); ?>
 <?php echo $model->title; ?></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'input_type',
		'required',
	),
)); ?>

<h2> <?php echo Shop::t('Variations of this specification'); ?> </h2>

<?php
if($model->variations) {
	echo '<ul>';
	foreach($model->variations as $variation) {
		printf('<li>%s: %s</li>', CHtml::link($variation->product->title, array('//shop/products/view', 'id' => $variation->product_id)), $variation->title);
	}
	echo '</ul>';
} else
echo Shop::t('This specification is not used in any product variation yet');

 ?>
