<div id="shopcontent">

<H1> Webshop Administration </H1>

<div class="span-8"> 
<?php $this->beginWidget('zii.widgets.CPortlet',
		array('title' => Shop::t('Administrate Categories'))); ?>
<?php $this->renderPartial('/category/admin'); ?>
<?php $this->endWidget(); ?>
</div>

<div class="span-15 last"> 
<?php $this->beginWidget('zii.widgets.CPortlet',
		array('title' => Shop::t('Administrate your Products'))); ?>
<?php $this->renderPartial('/products/admin'); ?>
<?php $this->endWidget(); ?>
</div>

<div class="clear">

<div class="span-8 last"> 
<?php $this->beginWidget('zii.widgets.CPortlet',
		array('title' => Shop::t('Pending Orders'))); ?>
<?php $this->renderPartial('/order/admin', array('model' => new Order)); ?>
<?php $this->endWidget(); ?>
</div>

<div class="clear">

</div>
<?php
$this->breadcrumbs=array(
		Shop::t('Shop')=>array('//shopshop/index'),
		Shop::t('Administration'),
		);

?>


