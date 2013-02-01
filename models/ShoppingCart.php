<?php

class ShoppingCart extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->controller->module->shoppingCartTable;
	}

	public static function getCartsOfOwner($cartowner = 'notset') {
		if($cartowner == 'notset')
			$cartowner = Yii::app()->User->getState('cartowner');

		return ShoppingCart::model()->findAll('cartowner = :cartowner', array(':cartowner' => $cartowner));
	}

	public function rules()
	{
		return array(
			array('product_id, cartowner', 'required'),
			array('product_id, customer_id', 'numerical', 'integerOnly'=>true),
			array('amount, cartowner', 'numerical'),
			array('cart_id, amount, product_id, customer_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'Product' => array(self::BELONGS_TO, 'Products', 'product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'cart_id' => Yii::t('shop', 'Cart'),
			'amount' => Yii::t('shop', 'Amount'),
			'product_id' => Yii::t('shop', 'Product'),
			'customer_id' => Yii::t('shop', 'Customer'),
		);
	}

	public function search()
  {
		$criteria=new CDbCriteria;

		if($this->cart_id == 0) 
		$criteria->compare('cart_id',$this->cart_id);

		$criteria->compare('amount',$this->amount);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('cartowner',$this->cartowner);

		return new CActiveDataProvider('ShoppingCart', array(
			'criteria'=>$criteria,
		));
	}
}
