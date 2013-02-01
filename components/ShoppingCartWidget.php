<?php

Yii::import('zii.widgets.CPortlet');

class ShoppingCartWidget extends CPortlet {
	public function	init() {
				if(!Shop::getCartContent())
			return false;
		return parent::init();
	}

	public function	run() {
		if(!Shop::getCartContent())
			return false;

		$this->render('shopping_cart', array(
					'products' => Shop::getCartContent()));
		return parent::run();
	}

}
?>
