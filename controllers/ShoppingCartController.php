<?php

class ShoppingCartController extends Controller
{
	public function actionView()
	{
		$cart = Shop::getCartContent();

		$this->render('view',array(
						'products'=>$cart
						));
	}

	public function beforeAction($action) {
		$this->layout = Shop::module()->layout;
		return parent::beforeAction($action);
	}

	public function actionUpdateVariation() {
		if(Yii::app()->request->isAjaxRequest && isset($_POST)) {
			$cart = Shop::getCartContent();
			$pieces = explode('_', key($_POST));

			$position = $pieces[1];
			$variation = $pieces[2];
			$new_value = $_POST[key($_POST)];

			$cart[$position]['Variations'][$variation] = $new_value;

			if(Shop::setCartContent($cart)) {
				$product = Products::model()->findByPk($cart[$position]['product_id']);
				echo Shop::priceFormat(
						@$product->getPrice($cart[$position]['Variations'], $cart[$position]['amount'] ));
			} else throw new CHttpException(500);
		}
	}

	public function actionGetPriceSingle($position) {
		$cart = Shop::getCartContent();
		$product_id = $cart[$position]['product_id'];
		if($product = Products::model()->findByPk($product_id))
			if(Yii::app()->request->isAjaxRequest)
				echo Shop::priceFormat(
						$product->getPrice($cart[$position]['Variations'], 1));
			else
				return Shop::priceFormat(
						$product->getPrice($cart[$position]['Variations'], 1));
	}

	public function actionGetPriceTotal() {
		echo Shop::getPriceTotal();
	}

	public function actionGetShippingCosts() {
		echo Shop::getShippingMethod(true);
	}


	public function actionUpdateAmount() {
		$cart = Shop::getCartContent();

		foreach($_GET as $key => $value) {
			if(substr($key, 0, 7) == 'amount_') {
				if($value == '')
					return true;
				if (!is_numeric($value) || $value <= 0)
					throw new CException('Wrong amount');
				$position = explode('_', $key);
				$position = $position[1];
				
				if(isset($cart[$position]['amount']))
					$cart[$position]['amount'] = $value;
					$product = Products::model()->findByPk($cart[$position]['product_id']);
					echo Shop::priceFormat(
							@$product->getPrice($cart[$position]['Variations'], $value));
					return Shop::setCartContent($cart);
			}	
		}

}


	// Add a new product to the shopping cart
	public function actionCreate()
	{
		if(!is_numeric($_POST['amount']) || $_POST['amount'] <= 0) {
			Shop::setFlash(Shop::t('Illegal amount given'));
			$this->redirect(array( 
							'//shop/products/view', 'id' => $_POST['product_id']));
		}

		if(isset($_POST['Variations']))
			foreach($_POST['Variations'] as $key => $variation) {
			
				$specification = ProductSpecification::model()->findByPk($key);
				if($specification->required && $variation[0] == '') {
					Shop::setFlash(Shop::t('Please select a {specification}', array(
									'{specification}' => $specification->title)));
					$this->redirect(array(
								'//shop/products/view', 'id' => $_POST['product_id']));
				}

			}

		if(isset($_FILES)) {
			foreach($_FILES as $variation) {
				$target = Shop::module()->uploadedImagesFolder . '/' . $variation['name'];
				if($variation['tmp_name'] == '') {
					Shop::setFlash(Shop::t('Please select a image from your hard drive'));
					$this->redirect(array('//shop/shoppingCart/view'));
				}
					
				if(move_uploaded_file($variation['tmp_name'], $target))
					$_POST['Variations']['image'] = $target;
			}
		}

		$cart = Shop::getCartContent();

		// remove potential clutter
		if(isset($_POST['yt0']))
			unset($_POST['yt0']);
		if(isset($_POST['yt1']))
			unset($_POST['yt1']);

		$cart[] = $_POST;
	
		Shop::setCartcontent($cart);
		Shop::setFlash(Shop::t('The product has been added to the shopping cart'));
		$this->redirect(array('//shop/shoppingCart/view'));
	}

	public function actionDelete($id)
	{
		$id = (int) $id;
		$cart = json_decode(Yii::app()->user->getState('cart'), true);

		unset($cart[$id]);
		Yii::app()->user->setState('cart', json_encode($cart));

			$this->redirect(array('//shop/shoppingCart/view'));
	}

	public function actionIndex()
	{
		if(isset($_SESSION['cartowner'])) {
			$carts = ShoppingCart::model()->findAll('cartowner = :cartowner', array(':cartowner' => $_SESSION['cartowner']));

			$this->render('index',array( 'carts'=>$carts,));
		} 
	}

	public function actionAdmin()
	{
		$model=new ShoppingCart('search');
		if(isset($_GET['ShoppingCart']))
			$model->attributes=$_GET['ShoppingCart'];
			$model->cartowner = Yii::app()->User->getState('cartowner');

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=ShoppingCart::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shopping cart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
