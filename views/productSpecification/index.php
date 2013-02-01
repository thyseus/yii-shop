<?php
$this->breadcrumbs=array(
	'Product Specifications',
);

$this->menu=array(
	array('label'=>'Create ProductSpecification', 'url'=>array('create')),
	array('label'=>'Manage ProductSpecification', 'url'=>array('admin')),
);
?>

<h1>Product Specifications</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
