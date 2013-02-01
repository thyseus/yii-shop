<?php
$this->breadcrumbs=array(
	'Product Specifications'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>Shop::t('Specifications'), 'url'=>array('admin')),
	array('label'=>Shop::t('New Specification'), 'url'=>array('create')),
);

?>

<h2><?php echo Shop::t('Manage Product Specifications'); ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-specification-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'input_type',
		array(
			'name' => 'required',
			'value' => '$data->required ? Shop::t("Yes") : Shop::t("No")'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
