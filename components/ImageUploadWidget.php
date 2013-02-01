<?php
Yii::import('zii.widgets.CPortlet');

/**
 *		
 **/
class ImageUploadWidget extends CPortlet
{
	public $products = null;
	public $selected = null;
	public $ask_for_amount = true;
	public $view = 'image_upload';

	public function init()
	{
		if($this->products === null)
			throw new CException( Shop::t(
						'Please provide a product that can be bought with the ImageUploadWidget'));

		return parent::init();
	}

	public function run() {
		if($this->products === true) 
			$this->products = Products::model()->findAll('status = 1');

		if(!is_array($this->products))
			$this->products = array($products);

		if(!$this->selected)
			$this->selected = $this->products[0]->product_id;

		$products = array();
		foreach($this->products as $product) {
			if(is_numeric($product))
				$products[$product] = Products::model()->findByPk($product);
			else
				$products[$product->product_id] = $product;
		}

		$this->render($this->view, array(
					'selected' => $this->selected,
					'ask_for_amount' => $this->ask_for_amount,
					'products' => $products));
		return parent::run();
	}

}
