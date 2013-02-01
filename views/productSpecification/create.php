<?php
$this->breadcrumbs=array(
	Shop::t('Product Specifications')=>array('index'),
	Shop::t('Create'),
);

$this->menu=array(
		array('label'=>Shop::t('Manage Product specifications'),
			'url'=>array('admin')),
		);
?>

<h2><?php echo Shop::t('Create Product specification'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
