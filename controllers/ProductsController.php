<?php

class ProductsController extends Controller
{
	public $_model;
	public $pageTitle;

	public function filters()
	{
		return array(
				'accessControl',
				);
	}	

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('view', 'index', 'getVariations'),
					'users' => array('*'),
					),
				array('allow',
					'actions'=>array('admin','delete','create','update', 'view'),
					'users' => array('admin'),
					),
				array('deny',  // deny all other users
					'users'=>array('*'),
					),
				);
	}

	// This method returns a set of variations that is possible for a given
	// product. This is used in the Image Upload Widget as a ajax response,
	// for example.
	public function actionGetVariations() {
		if(Yii::app()->request->isAjaxRequest && isset($_POST['product'])) {
			$product = Products::model()->findByPk($_POST['product']); 
			echo CHtml::hiddenField('product_id', $product->product_id);

			if($variations = $product->getVariations()) {
				foreach($variations as $variation) {
					$field = "Variations[{$variation[0]->specification_id}][]";
					
					echo '<div class="shop-variation-element">';
					
					echo '<strong>'.CHtml::label($variation[0]->specification->title.'</strong>',
							$field, array(
								'class' => 'lbl-header'));

					if($variation[0]->specification->required)
						echo ' <span class="required">*</span>';

					echo '<br />';

					if($variation[0]->specification->input_type == 'textfield') {
						echo CHtml::textField($field);
					} else if ($variation[0]->specification->input_type == 'select'){

						// If the specification is required, preselect the first field.
						// Otherwise  let the customer choose which one to pick
						// 	$product->variationCount > 1 ? true : false means, that the
						// widget should display the _absolute_ price if only 1 variation
						// is available, otherwise the relative (+ X $)
						echo CHtml::radioButtonList($field,
								$variation[0]->specification->required 
								? $variation[0]->id 
								: null,
								ProductVariation::listData($variation, 
									$product->variationCount > 1 ? true : false
									), array(
										'template' => '{input} {label}',
										'separator' =>'<div class="clear"></div>',
										));
					} 
					echo '</div>';
				}
			}

		} else
			throw new CHttpException(404);

	}

	public function beforeAction($action) {
		$this->layout = Shop::module()->layout;
		return parent::beforeAction($action);
	}

	public function actionView()
	{
		$model = $this->loadModel();

		if($model && $model->status != 1)
			throw new CHttpException(404);

		$this->render(Shop::module()->productView,array(
					'model'=>$model,
					));
	}

	public function actionCreate()
	{
		$model = new Products;

		$this->layout = Shop::module()->adminLayout;

		// We assume we want to create a _active_ product
		if(!isset($model->status))
			$model->status = 1;

		$this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			$model->attributes = $_POST['Products'];
			if(isset($_POST['Specifications']))
				$model->setSpecifications($_POST['Specifications']);

			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
					'model'=>$model,
					));
	}

	public function actionUpdate($id, $return = null)
	{
		$this->layout = Shop::module()->adminLayout;
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			$model->attributes = $_POST['Products'];

			if(isset($_POST['Specifications']))
				$model->setSpecifications($_POST['Specifications']);
			if(isset($_POST['Variations']))
				$model->setVariations($_POST['Variations']);

			if($model->save())
				if($return == 'product')
					$this->redirect(array('products/update', 'id' => $model->product_id));
				else
					$this->redirect(array('products/admin'));
		}

		$this->render('update',array(
					'model'=>$model,
					));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Products', array(
					'criteria' => array(
						'condition' => 'status = 1')));

		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = Shop::module()->adminLayout;
		$model=new Products('search');
		if(isset($_GET['Products']))
			$model->attributes=$_GET['Products'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Products::model()->findbyPk($_GET['id']);
			if(isset($_GET['title']))
				$this->_model=Products::model()->find('title = :title', array(
							':title' => $_GET['title']));
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}


		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
