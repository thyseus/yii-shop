<?php
/**
 * PayPalModel
 **/
class PayPalForm extends CModel
{
	public $order_id;
	public $email;
	public $currency;

	public function attributeNames() {
		return array(
				'order_id' => Shop::t('Order id'),
				'currency' => Shop::t('Currency'),
				'email' => Shop::t('Email'),
				);
	}

	public function beforeValidate() {
		if(Shop::module()->currencySymbol == '€')
			$this->currency = 'EUR';
		if(Shop::module()->currencySymbol == '$')
			$this->currency = 'USD';

		return parent::beforeValidate(); 
	}

	public function rules()
	{
		return array(
				array('email', 'CEmailValidator'),
				array('order_id, currency', 'required')
					);
	}

	public function handlePayPal($order) {
		if(Shop::module()->payPalMethod !== false 
				&& $order->payment_method == Shop::module()->payPalMethod) {

				Yii::import('application.modules.shop.components.payment.Paypal');
				$paypal = new Paypal();
				// paypal email
				$paypal->addField('business', Shop::module()->payPalBusinessEmail);

				// Specify the currency
				$paypal->addField('currency_code', $this->currency);

				// Specify the url where paypal will send the user on success/failure
				$paypal->addField('return',
						Yii::app()->controller->createAbsoluteUrl('//shop/order/success'));
				$paypal->addField('cancel_return',
						Yii::app()->controller->createAbsoluteUrl('//shop/order/failure'));
				$paypal->addField('notify_url',
						Yii::app()->controller->createAbsoluteUrl('//shop/order/ipn'));

				// Specify the product information
				$paypal->addField('order_id', $order->order_id);
				$paypal->addField('item_name', Shop::t(
							'Order number #{order_id}', array(
								'{order_id}' => $order->order_id)));
				$paypal->addField('amount', $order->getTotalPrice());

				if(Shop::module()->payPalTestMode)
					$paypal->enableTestMode();

				// Let's start the train!
				return $paypal->submitPayment();

		}
		return true;
	}

}
