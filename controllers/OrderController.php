<?php

class OrderController extends Controller
{
	public $_model;

	public function filters()
	{
		return array(
				'accessControl',
				);
	}	

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('create', 'confirm', 'success', 'failure', 'paypal',
						'ipn',),
					'users' => array('*'),
					),
				array('allow',
					'actions'=>array('index', 'view'),
					'users' => array('@'),
					),
				array('allow',
					'actions'=>array('admin','delete', 'slip', 'invoice', 'update'),
					'users' => array('admin'),
					),
				array('deny',  // deny all other users
					'users'=>array('*'),
					),
				);
	}

	public function actionSlip($id) {
		if($model = $this->loadModel($id))
			if(Shop::module()->useTcPdf)
				$this->renderPartial(Shop::module()->slipViewPdf, array(
							'model' => $model));
			else
				$this->render(Shop::module()->slipView, array('model' => $model));
	}

	public function actionInvoice($id) {
		if($model = $this->loadModel($id))
			$this->render(Shop::module()->invoiceView, array('model' => $model));
	}

	public function beforeAction($action) {
		$this->layout = Shop::module()->layout;
		return parent::beforeAction($action);
	}

	public function actionView($id)
	{
		$model = Order::model()->with('customer')->findbyPk($id);

		if($model) {
			if($model->customer->user_id == Yii::app()->user->id
					|| (Shop::module()->useWithYum && Yii::app()->user->isAdmin()) 
					|| Yii::app()->user->id == 1)
			{

				if(!$model->paymentMethod instanceof PaymentMethod)
					Shop::log(Shop::t('Invalid payment method in order #{order_id}', array(
									'{order_id}' => $model->order_id)), 'warning');

				if(!$model->shippingMethod instanceof shippingMethod)
					Shop::log(Shop::t('Invalid shipping method in order #{order_id}', array(
									'{order_id}' => $model->order_id)), 'warning');

				$this->render('view',array(
							'model'=>$model
							));
			} else
				throw new CHttpException(403, Shop::t(
							'You are not allowed to view this order'));

		} else throw new CHttpException(404, Shop::t(
					'The requested Order could not be found'));
	}

	public function mailConfirmationMessage($order, $message) {
		$email = $order->customer->email;
		$title = Shop::t('Order confirmation');


		if(mail($email, $title, $message))
			Shop::setFlash(Shop::t('A order confirmation has been sent'));
		else
			Shop::setFlash(Shop::t('Error while sending confirmation message'));

	}

	public function actionUpdate($id) {
		$order = $this->loadModel();
		if( (Shop::module()->useWithYum && Yii::app()->user->isAdmin()) 
			|| Yii::app()->user->id == 1) {

		if(isset($_POST['Order'])) {
			if(
					isset($_POST['SendConfirmationMessage'])
					&& $_POST['SendConfirmationMessage'] == 1
					&& isset($_POST['ConfirmationMessage']))
				$this->mailConfirmationMessage($order, $_POST['ConfirmationMessage']);	

			$order->attributes = $_POST['Order'];
			$order->save();
			$this->redirect(array('//shop/order/view', 'id' => $order->order_id));
		}
		$this->render('update', array('model' => $order));	
		} else
			throw new CHttpException(403);
	}

	/** Creation of a new Order 
	 * Before we create a new order, we need to gather Customer information.
	 * If the user is logged in, we check if we already have customer information.
	 * If so, we go directly to the Order confirmation page with the data passed
	 * over. Otherwise we need the user to enter his data, and depending on
	 * whether he is logged in into the system it is saved with his user 
	 * account or once just for this order.	
	 */
	public function actionCreate(
			$customer = null,
			$payment_method = null,
			$shipping_method = null) {

		// Shopping cart is empty, taking a order is not allowed yet
		if(Shop::getCartContent() == array())
			$this->redirect(array('//shop/shoppingCart/view'));

		if(isset($_POST['ShippingMethod'])) 
			Yii::app()->user->setState('shipping_method', $_POST['ShippingMethod']);

		if(isset($_POST['PaymentMethod'])) 
			Yii::app()->user->setState('payment_method', $_POST['PaymentMethod']);

		if(isset($_POST['Order'])) 
			Yii::app()->user->setState('order_options', $_POST['Order']);

		if(isset($_POST['DeliveryAddress']) && @$_POST['toggle_delivery'] == true) {
			if(Address::isEmpty($_POST['DeliveryAddress'])) {
				Shop::setFlash(Shop::t('Delivery address is not complete! Please fill in all fields to set the Delivery address'));
			} else {
				$deliveryAddress = new DeliveryAddress;
				$deliveryAddress->attributes = $_POST['DeliveryAddress'];
				if($deliveryAddress->save()) {
					$model = Shop::getCustomer();

					if(isset($_POST['toggle_delivery']))
						$model->delivery_address_id = $deliveryAddress->id;
					else
						$model->delivery_address_id = 0;
					$model->save(false, array('delivery_address_id'));
				}
			}
		}

		if(isset($_POST['BillingAddress']) && @$_POST['toggle_billing'] == true) {
			if(Address::isEmpty($_POST['BillingAddress'])) {
				Shop::setFlash(Shop::t('Billing address is not complete! Please fill in all fields to set the Billing address'));
			} else {
				$BillingAddress = new BillingAddress;
				$BillingAddress->attributes = $_POST['BillingAddress'];
				if($BillingAddress->save()) {
					$model = Shop::getCustomer();
					if(isset($_POST['toggle_billing']))
						$model->billing_address_id = $BillingAddress->id;
					else
						$model->billing_address_id = 0;
					$model->save(false, array('billing_address_id'));
				}
			}
		}

		if(!$customer)
			$customer = Yii::app()->user->getState('customer_id');
		if(!Yii::app()->user->isGuest && !$customer)
			$customer = Customer::model()->find('user_id = :user_id ', array(
						':user_id' => Yii::app()->user->id));
		if(!$payment_method)
			$payment_method = Yii::app()->user->getState('payment_method');
		if(!$shipping_method)
			$shipping_method = Yii::app()->user->getState('shipping_method');

		if(!$customer) {
			$this->render('/customer/create', array(
						'action' => array('//shop/customer/create')));
			Yii::app()->end();
		}

		if(!$shipping_method) {
			$this->render('/shippingMethod/choose', array(
						'customer' => Shop::getCustomer()));
			Yii::app()->end();
		}
		if(!$payment_method) {
			$this->render('/paymentMethod/choose', array(
						'customer' => Shop::getCustomer()));
			Yii::app()->end();
		}

		if($customer && $payment_method && $shipping_method) {
			$order = new Order();
			$order->applyOrderOptions();

			if(is_numeric($customer))
				$customer = Customer::model()->findByPk($customer);
			if(is_numeric($shipping_method))
				$shipping_method = ShippingMethod::model()->find('id = :id', array(
							':id' => $shipping_method));
			if(is_numeric($payment_method))
				$payment_method = PaymentMethod::model()->findByPk($payment_method);

			$this->render('/order/create', array(
						'customer' => $customer,
						'shippingMethod' => $shipping_method,
						'paymentMethod' => $payment_method,
						'order' => $order,
						));

		}
	}

	public function actionConfirm() {
		Yii::app()->user->setState('order_comment', @$_POST['Order']['Comment']);
		if(isset($_POST['accept_terms']) && $_POST['accept_terms'] == 1) {
			$order = new Order();
			$order->applyOrderOptions();

			$customer = Shop::getCustomer();
			$cart = Shop::getCartContent();

			$order->customer_id = $customer->customer_id;

			// fetch delivery data
			$address = new DeliveryAddress();
			if($customer->deliveryAddress)
				$address->attributes = $customer->deliveryAddress->attributes;
			else
				$address->attributes = $customer->address->attributes;
			$address->save();

			$order->delivery_address_id = $address->id;

			// fetch billing data
			$address = new BillingAddress();
			if($customer->billingAddress)
				$address->attributes = $customer->billingAddress->attributes;
			else
				$address->attributes = $customer->address->attributes;
			$address->save();
			$order->billing_address_id = $address->id;

			$order->ordering_date = time();
			$order->payment_method = Yii::app()->user->getState('payment_method');
			$order->shipping_method = Yii::app()->user->getState('shipping_method');
			$order->comment = Yii::app()->user->getState('order_comment');
			$order->status = 'new';

			if($order->save()) {
				foreach($cart as $position => $product) {
					$position = new OrderPosition;
					$position->order_id = $order->order_id;
					$position->product_id = $product['product_id'];
					$position->amount = $product['amount'];
					$position->specifications = json_encode($product['Variations']);
					$position->save();
				}
				
				Shop::mailNotification($order);
				Shop::flushCart(true);

				if(Shop::module()->payPalMethod !== false 
						&& $order->payment_method == Shop::module()->payPalMethod) 
					$this->redirect(array(Shop::module()->payPalUrl,
								'order_id' => $order->order_id));
				else
					$this->redirect(Shop::module()->successAction);
			} 
				$this->redirect(Shop::module()->failureAction);
		} else {
			Shop::setFlash(
					Shop::t(
						'Please accept our Terms and Conditions to continue'));
			$this->redirect(array('//shop/order/create'));
		}
	}

	public function actionPaypal($order_id = null) {
		$model = new PayPalForm();

		if($order_id !== null)
			$model->order_id = $order_id;

		$order = Order::model()->findByPk($model->order_id);

		if($order->customer->user_id != Yii::app()->user->id)
			throw new CHttpException(403);

		if($order->status != 'new') {
			Shop::setFlash('The order is already paid');
			$this->redirect('//shop/products/index');
		}


		if(isset($_POST['PayPalForm'])) {
			$model->attributes = $_POST['PayPalForm'];

			if($model->validate()) {
				echo $model->handlePayPal($order);
			}
		}

		$this->render('/order/paypal_form', array(
					'model' => $model));
	}

	public function actionIpn() {
		Yii::import('application.modules.shop.components.payment.Paypal');

		$paypal = new Paypal();
		Shop::log('Paypal payment attempt');

		// Log the IPN results
		$paypal->ipnLog = TRUE;

		if(Shop::module()->payPalTestMode)
			$paypal->enableTestMode();

		// Check validity and write down it
		if ($paypal->validateIpn())
		{
			if ($paypal->ipnData['payment_status'] == 'Completed')
			{
				Shop::log('Paypal payment arrived :'.var_dump($paypal));
			}
			else
			{
				Shop::log('Paypal payment raised an error :'.var_dump($paypal));
			}
		} 
	}

	public function actionSuccess()
	{
		$this->render('/order/success');
	}

	public function actionFailure()
	{
		$this->render('/order/failure');
	}

	public function actionIndex()
	{

		$model = new Order('search');

		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$model->user_id = Yii::app()->user->id;

		$this->render('index',array(
					'model'=>$model,
					));
	}

	public function actionAdmin()
	{
		$this->layout = Shop::module()->adminLayout;
		$model=new Order('search');

		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Order::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

}
