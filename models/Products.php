<?php

class Products extends CActiveRecord
{
	// If at least one product variation has the type 'image', the user needs
	// to upload a image file in order to buy the product. To achieve this,
	// we need to set the 'enctype' to 'multipart/form-data'. This function
	// checks, if the product has a 'image' variation.
	public function hasUpload() {
		foreach($this->variations as $variation)
			if($variation->specification->input_type == 'image')
				return true;

		return false;

	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Shop::module()->productsTable;
	}

	public function beforeValidate() {
		if(Yii::app()->language == 'de')
			$this->price = str_replace(',', '.', $this->price);
		
		return parent::beforeValidate();
	}

	public function rules()
	{
		return array(
			array('title, category_id, status, tax_id', 'required'),
			array('product_id, category_id, status', 'numerical', 'integerOnly'=>true),
			array('title, price, language', 'length', 'max'=>45),
			array('keywords', 'length', 'max'=>255),
			array('title', 'unique'),
			array('description, specifications', 'safe'),
			array('product_id, title, description, price, category_id, keywords', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'variations' => array(self::HAS_MANY, 'ProductVariation', 'product_id', 'order' => 'position'),
			'variationCount' => array(self::STAT, 'ProductVariation', 'product_id'),
			'orders' => array(self::MANY_MANY, 'Order', 'ShopProductOrder(order_id, product_id)'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'tax' => array(self::BELONGS_TO, 'Tax', 'tax_id'),
			'images' => array(self::HAS_MANY, 'Image', 'product_id'),
			'shopping_carts' => array(self::HAS_MANY, 'ShoppingCart', 'product_id'),
		);
	}

	public function getSpecification($spec) {
		$specs = json_decode($this->specifications, true);

		if(isset($specs[$spec]))
			return $specs[$spec];

		return false;
	}

	public function getImage($image = 0, $thumb = false) {
		if(isset($this->images[$image]))
			return Yii::app()->controller->renderPartial('/image/view', array(
				'model' => $this->images[$image],
				'thumb' => $thumb), true); 
	}

	public function getSpecifications() {
		$specs = json_decode($this->specifications, true);
		return $specs === null ? array() : $specs;
	}

	public function renderSpecifications() {
		echo $this->getSpecifications();
	}

	public function setSpecification($spec, $value) {
		$specs = json_decode($this->specifications, true);

		$specs[$spec] = $value;

		return $this->specifications = json_encode($specs);
	}

	public function setSpecifications($specs) {
		foreach($specs as $k => $v)
			$this->setSpecification($k, $v);
	}

	public function setVariations($variations) {
		$db = Yii::app()->db;
		$db->createCommand()->delete('shop_product_variation',
				'product_id = :product_id', array(
					':product_id' => $this->product_id));

		foreach($variations as $key => $value) {
			if($value['specification_id'] 
					&& isset($value['title']) 
					&& $value['title'] != '') {

				$value['price_adjustion'] = strtr(
						$value['price_adjustion'], array(',' => '.'));

				if(isset($value['sign_price']) && $value['sign_price'] == '-')
					$value['price_adjustion'] -= 2 * $value['price_adjustion'];

				$value['weight_adjustion'] = strtr(
						$value['weight_adjustion'], array(',' => '.'));

				if(isset($value['sign_weight']) && $value['sign_weight'] == '-')
					$value['weight_adjustion'] -= 2 * $value['weight_adjustion'];

				$db->createCommand()->insert('shop_product_variation', array(
							'product_id' => $this->product_id,
							'specification_id' => $value['specification_id'],
							'position' => @$value['position'] ? $value['position'] : 0,
							'title' => $value['title'],
							'price_adjustion' => @$value['price_adjustion'] ? $value['price_adjustion'] : 0,
							'weight_adjustion' => @$value['weight_adjustion'] ? $value['weight_adjustion'] : 0,
							));	
			}
		} 
	} 

		public function getVariations() {
		$variations = array();
		foreach($this->variations as $variation) {
			$variations[$variation->specification_id][] = $variation;
		}		

		return $variations;
	}


	public function attributeLabels()
	{
		$labels = array(
				'tax_id' => Shop::t('Tax'),
				'product_id' => Shop::t('Product'),
				'title' => Shop::t('Title'),
				'description' => Shop::t('Description'),
				'price' => Shop::t('Price'),
				'category_id' => Shop::t('Category'),
				);
		if(Shop::module()->useWithYum && Yii::app()->user->isAdmin())
			$labels['price'] = Shop::t('Price (net)');

		return $labels;
	}

	public function getWeightTaxRate($variations = null, $amount = 1) { 
		if($this->tax) {
			$taxrate = $this->tax->percent;	

			$price = $this->price;

			if($variations)
				foreach($variations as $key => $variation) 
					if($obj = ProductVariation::model()->findByPk($variation))
						$price += $obj->price_adjustion;

			$tax = $price * ($this->tax->percent / 100);

			$tax *= $amount;
			return $tax;
		}
	}

	public function getTaxRate($variations = null, $amount = 1) { 
		if($this->tax) {
			$taxrate = $this->tax->percent;	

			$price = $this->price;

			if($variations)
				foreach($variations as $key => $variation) 
					if($obj = ProductVariation::model()->findByPk($variation))
						$price += $obj->price_adjustion;

			$tax = $price * ($this->tax->percent / 100);

			$tax *= $amount;
			return $tax;
		}
	}

	public function getWeight($variations = null, $amount = 1) {
		$spec = ProductSpecification::model()->findByPk(
				Shop::module()->weightSpecificationId);

		$weight = 0;
		if($spec) {
			$specs = json_decode($this->specifications, true);
			if(isset($specs[$spec->title]))
				$weight += $specs[$spec->title];
		}


		if($variations)
			foreach($variations as $key => $variation) {
				if(is_array($variation))
					$variation = $variation[0];
				if(is_numeric($variation))
					$weight += @ProductVariation::model()->findByPk($variation)->getWeightAdjustion();
			}

		return (float) $weight *= $amount;
	}

	public function getPrice($variations = null, $amount = 1) {
		if($this->price === null)
			$price = (float) Shop::module()->defaultPrice;
		else
			$price = (float) $this->price;

		if($this->tax)
			$price *= ($this->tax->percent / 100) + 1;

		if($variations)
			foreach($variations as $key => $variation) {
				if(is_numeric($variation))
					$price += @ProductVariation::model()->findByPk($variation)->getPriceAdjustion();
			}

		return (float) $price *= $amount;
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider('Products', array(
			'criteria'=>$criteria,
		));
	}
}
