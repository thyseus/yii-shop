<?php

class Order extends CActiveRecord
{
	public $user_id;

	public function limit($limit=5)
	{
		$this->getDbCriteria()->mergeWith(array(
					'limit'=>$limit,
					));
		return $this;
	}	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Shop::module()->orderTable;
	}

	public function rules()
	{
		return array(
				array('customer_id, ordering_date, delivery_address_id, billing_address_id, payment_method', 'required'),
				array('status', 'in', 'range' => array('new', 'in_progress', 'done', 'cancelled')),
				array('customer_id', 'numerical', 'integerOnly'=>true),
				array('order_id, customer_id, ordering_date, status, comment', 'safe'),
				);
	}

	public static function statusOptions() {
		return array(
				'new' => Shop::t('New'),
				'in_progress' => Shop::t('In progress'),
				'done' => Shop::t('Done'),
				'cancelled' => Shop::t('Cancelled'));

	}

	public function getStatus() {
		return Shop::t($this->status);
	}

	public function relations()
	{
		$relations = array(
				'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
				'positions' => array(self::HAS_MANY, 'OrderPosition', 'order_id'),
				'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
				'billingAddress' => array(self::BELONGS_TO, 'BillingAddress', 'billing_address_id'),
				'deliveryAddress' => array(self::BELONGS_TO, 'DeliveryAddress', 'delivery_address_id'),
				'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethod', 'payment_method'),
				'shippingMethod' => array(self::BELONGS_TO, 'ShippingMethod', 'shipping_method'),
				);

		if(Shop::module()->useWithYum)
			$relations['user'] = array(self::HAS_ONE, 'YumUser', 'user_id', 'through' => 'customer');

		return $relations;
	}

	public function attributeLabels()
	{
		return array(
				'order_id' => Shop::t('Order number'),
				'customer_id' => Shop::t('Customer number'),
				'ordering_date' => Shop::t('Ordering Date'),
				'status' => Shop::t('Status'),
				'comment' => Shop::t('Comment'),
				);
	}

	public function getTaxAmount() {
		$amount = 0;
		if($this->products)
			foreach($this->products as $position)
				$amount += ($position->getPrice() * ($position->product->tax->percent / 100 + 1) ) - $position->getPrice();

		return $amount;
	}

	public function getTotalPrice() {
		$price = 0;
		if($this->positions)
			foreach($this->positions as $position)
				$price += $position->getPrice();

		if($this->shippingMethod)
			$price += $this->shippingMethod->price;

		return $price;
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.order_id',$this->order_id);
		$criteria->compare('t.customer_id',$this->customer_id);
		$criteria->compare('t.ordering_date',$this->ordering_date,true);
		$criteria->compare('t.status',$this->status);

		// This code block is used mainly for searching for orders that a 
		// specific user has made (a 'through' join is done here)
		if($this->user_id !== null) {
			$criteria->join = '
				left join shop_customer on t.customer_id = shop_customer.customer_id 
				left join users on shop_customer.user_id = users.id';
			$criteria->compare('users.id', $this->user_id);
		}

		return new CActiveDataProvider('Order', array( 'criteria'=>$criteria,));
	}
}
