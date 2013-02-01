<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>

<h1> Deutsch </h1>

<div class="span-8"> 
<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => Yii::t('YiiShop', 'Your Shopping Cart'))); ?>
<?php $this->renderPartial('/shoppingCart/index', array()); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => Yii::t('YiiShop', 'Product Categories'))); ?>
<?php $this->renderPartial('/category/index'); ?>
<?php $this->endWidget(); ?>
</div>

<div class="span-16 last"> 
<?php $this->renderPartial('/shop/welcome'); ?>
</div>

<div style="clear:both;"> </div>

