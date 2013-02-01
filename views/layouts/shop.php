<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->


	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
		<div id="mainmenu">
		<?php
	$items = array();
	$items[] = array('label'=>'Home', 'url'=>array('/site/index'));
	$items[] = array('label'=>'All', 'url'=>array('/shop/products/index'));
	foreach(Category::model()->findAll() as $category)
	$items[] = array(
			'label' => $category->title,
			'url' => array(
				'//shop/category/view', 'id' => $category->category_id));
	$items[] = array('label'=>'Admin', 'url'=>array('/shop/shop/admin'));

 $this->widget('zii.widgets.CMenu',array(
			'items'=>$items,
		)); ?>
	</div><!-- mainmenu -->

	<div id="content">
	<div style="float: right; max-height: 200px; width: 200px; margin: 5px;">
	<?php
	$this->widget('ShoppingCartWidget'); 
	$this->widget('ProductCategoriesWidget'); 
	if(!Yii::app()->user->isGuest) 
		$this->widget('AdminWidget');

	?>	
	</div>

	<div style="width: 700px;">
	<?php echo $content; ?>
	</div>
	</div>

	<div style="clear: both;"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
