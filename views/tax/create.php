<?php
$this->breadcrumbs=array(
	Shop::t('Taxes')=>array('index'),
	Shop::t('Create'),
);

$this->menu=array(
	array('label'=>Shop::t('Manage Tax'), 'url'=>array('admin')),
);
?>

<h2> <?php echo Shop::t('Create Tax'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
