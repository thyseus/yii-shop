<?php
if(!$model) {
	echo Shop::t('Invalid payment method'); 

	return false;
}

if(!isset($this->breadcrumbs))
	$this->breadcrumbs=array(
			Shop::t('Payment Methods')=>array('index'),
			$model->title,
			);

if(!isset($this->menu))
$this->menu=array(
	array('label'=>'Create PaymentMethod', 'url'=>array('create')),
	array('label'=>'Update PaymentMethod', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PaymentMethod', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaymentMethod', 'url'=>array('admin')),
);
?>

<h2> <?php echo Shop::t('Payment method') ?> </h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		'description',
		'price',
	),
)); ?>
