<?php
Yii::import('zii.widgets.CPortlet');

class ProductCategoriesWidget extends CPortlet {

	public function init() {
		$this->title = Shop::t('Product Categories');
		return parent::init();
	}

	public function run() {
		$this->render('application.modules.shop.views.category.index');
		return parent::run();
	}
}
?>
