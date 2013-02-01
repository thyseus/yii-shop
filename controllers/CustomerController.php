<?php

class CustomerController extends Controller
{
	public $_model;

	public function beforeAction($action) {
		$this->layout = Shop::module()->layout;
		return parent::beforeAction($action);
	}

	public function actionView($id = null)
	{
		if($id === null) 
			$id = Yii::app()->user->id;

		$model = Customer::model()->find('user_id = :uid', array(
					':uid' => $id));

		if(!$model)
			throw new CHttpException(403);

		$this->render('view',array(
					'model'=>$model,
					));
	}

	public function actionCreate()
	{
		// if some data has been entered before or the user is already logged in,
		// take the already existing data and prefill the input form
		if($model = Shop::getCustomer()) 
			$address = $model->address;
		else
			$model = new Customer;

		if(isset($_POST['Customer']))
		{
			$model->attributes = $_POST['Customer'];
			if(isset($_POST['Address'])) {
				$address = new Address;
				$address->attributes = $_POST['Address'];
				if($address->save())
					$model->address_id = $address->id;
			}
			if(!Yii::app()->user->isGuest)
				$model->user_id = Yii::app()->user->id;

			$model->validate();

			if(Shop::module()->useWithYum 
					&& isset($_POST['register']) 
					&& $_POST['register'] = true) {
				if(isset($_POST['Customer']['password'])
						&& isset($_POST['Customer']['passwordRepeat'])) {
					if($_POST['Customer']['password'] != $_POST['Customer']['passwordRepeat']) {

						$model->addError('password', Shop::t('Passwords do not match'));
					} else if($_POST['Customer']['password'] == '') {
						$model->addError('password', Shop::t('Password is empty'));
					} else {
						$user = new YumUser;
						$profile = new YumProfile;
						$profile->attributes = $_POST['Customer'];
						$profile->attributes = $_POST['Address'];
						if($user->register(
									strtr($model->email, array('@' => '_', '.' => '_')),
									$_POST['Customer']['password'],
									$profile)) {
							$user->status = YumUser::STATUS_ACTIVE;
							$user->save(false, array('status'));
							$model->user_id = $user->id;
							Shop::setFlash(Shop::t('Successfully registered user'));
						} else {
							$model->addErrors($user->getErrors());
							$model->addErrors($profile->getErrors());
							Shop::setFlash(Shop::t('Error while registering user'));
						}
					} 
				}
			}

			if(!$model->hasErrors()) {
				if($model->save()) {
					Yii::app()->user->setState('customer_id', $model->customer_id);

					$this->redirect(
							array(
								'//shop/order/create', 'customer'=>$model->customer_id));
				}
			}
		}

		$this->render('create',array(
					'customer'=>$model,
					'address'=>isset($address) ? $address : new Address,
					));
	}

	public function actionUpdate($order = null)
	{
		if(Yii::app()->user->isGuest) {
			$id = Yii::app()->user->getState('customer_id');
			$model = Customer::model()->findByPk($id);
		}
		else
			$model = Customer::model()->find('user_id = :uid', array(
						':uid' => Yii::app()->user->id));

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if(isset($_POST['Address'])) {
				$address = $model->address;
				$address->attributes = $_POST['Address'];
				if($address->save())
					$model->address_id = $address->id;
			}
			if($model->save()) {
				if($order !== null)
					$this->redirect( array(
								'//shop/order/create', 'customer'=>$model->customer_id));
				else
					$this->redirect(array('view'));
			}
		} 
		$address = $model->address;
		$deliveryAddress = $model->deliveryAddress;
		$billingAddress = $model->billingAddress;	

		$this->render('update',array(
					'customer'=>$model,
					'address'=>isset($address) ? $address : new Address,
					'deliveryAddress'=>isset($deliveryAddress) ? $deliveryAddress : new DeliveryAddress,
					'billingAddress'=>isset($billingAddress) ? $billingAddress : new BillingAddress,

					));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Customer');
		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionAdmin()
	{
		$model=new Customer('search');
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

	public function loadModel($id = null)
	{
		if($id === null)
			$id = $_GET['id'];

		if($this->_model===null)
		{
			if(isset($id))
				$this->_model=Customer::model()->findbyPk($id);
			if($this->_model===null)
				throw new CHttpException(404,'The requested customer does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
