<?php

class ShippingMethodController extends Controller
{
	public $defaultAction = 'admin';

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function beforeAction($action) {
		$this->layout = Shop::module()->layout;
		return parent::beforeAction($action);
	}


	public function accessRules()
	{
		return array(
		array('allow', 
				'actions'=>array('choose'),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('admin','delete', 'create', 'update', 'index', 'view'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionChoose() {
		$this->render('choose', array('customer' => Shop::getCustomer()));
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new ShippingMethod;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShippingMethod']))
		{
			$model->attributes=$_POST['ShippingMethod'];
			if(isset($_POST['ShippingMethod']['id']))
				$model->id = $_POST['ShippingMethod']['id'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$id = $_GET['id'];

		$model=$this->loadModel($id['id'], $id['weight_range']);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShippingMethod']))
		{
			$model->attributes=$_POST['ShippingMethod'];
			if(isset($_POST['ShippingMethod']['id']))
				$model->id = $_POST['ShippingMethod']['id'];

			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
			$this->loadModel($_GET['id']['id'], $_GET['id']['weight_range'])->delete();
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = Shop::module()->adminLayout;
		$model=new ShippingMethod('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShippingMethod']))
			$model->attributes=$_GET['ShippingMethod'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id, $weight_range = null)
	{
		if($weight_range)
			$model=ShippingMethod::model()->find(
					'id = :id and weight_range = :weight_range', array(
						':id' => $id,
						':weight_range' => $weight_range));
		else
			$model=ShippingMethod::model()->find(
					'id = :id', array(
						':id' => $id));

		if($model===null)
			throw new CHttpException(404,'The requested shipping Method does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shipping-method-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
