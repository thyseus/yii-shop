<?php

class ShopModule extends CWebModule
{
	public $version = '0.7-svn';

	// Is the Shop in debug Mode?
	public $debug = false;

  // Whether the installer should install some demo data
	public $installDemoData = true;

	// Enable this to use the shop module together with the yii user
	// management module. Optional registration when ordering a product
	// will be enabled, for example.
	public $useWithYum = false;

	// Names of the tables
	public $categoryTable = 'shop_category';
	public $productsTable = 'shop_products';
	public $orderTable = 'shop_order';
	public $orderPositionTable = 'shop_order_position';
	public $customerTable = 'shop_customer';
	public $addressTable = 'shop_address';
	public $imageTable = 'shop_image';
	public $shippingMethodTable = 'shop_shipping_method';
	public $paymentMethodTable = 'shop_payment_method';
	public $taxTable = 'shop_tax';
	public $productSpecificationTable = 'shop_product_specification';
	public $productVariationTable = 'shop_product_variation';
	public $currencySymbol = '$';
	public $productView = 'view';

	// Set this to a valid email address to send a message once a order
	// comes in.
	public $orderNotificationEmail = false;
	public $orderNotificationFromEmail = 'do@not-reply.org';
	public $orderNotificationReplyEmail = 'do@not-reply.org';

	public $enableLogging = true;

	public $titleOptions = array('mr' => 'Mr.', 'ms' => 'Mrs.');

	// See docs/tcpdf.txt on how to enable PDF Generation of Invoices
	public $useTcPdf = false;
	public $tcPdfPath = 'ext.tcpdf.tcpdf';
	public $slipViewPdf = '/order/pdf/slip';
	public $invoiceViewPdf = '/order/pdf/invoice';
	public $footerViewPdf = '/order/pdf/footer';

	public $logoPath = 'logo.jpg';

	// Set this to an array to only allow various countries, for example
	// public $validCountries = array('Germany', 'Swiss', 'China'),
	public $validCountries = null;

	public $slipView = '/order/slip';
	public $invoiceView = '/order/invoice';
	public $footerView = '/order/footer';

	public $dateFormat = 'd/m/Y';

	// Adjust to use your own delivery times. 
	public $deliveryTimes = array(
			0 => '07:00 - 12:00 AM',
			1 => '13:00 - 18:00 PM',
			);

	// Set this to the id of the weight specification to enable weight
	// calculation in the delivery slip and invoice. 1 is for the demo
	// data. Set to NULL to disable weight calculation.
	public $weightSpecificationId = 1;
	
	public $imageWidthThumb = 100;
	public $imageWidth = 200;

	public $notifyAdminEmail = null;

	// If a price is NULL in the database, which price should be used instead?
	public $defaultPrice = 0.00;

	public $termsView = '/order/terms';
	public $successAction = array('//shop/order/success');
	public $failureAction = array('//shop/order/failure');

	public $loginUrl = array(
			'/site/login', 'action' => '%2525F%2525Fshop%2525Forder%2525Fcreate');

	public $orderConfirmTemplate = "Dear {title} {firstname} {lastname}, \n your order #{order_id} has been taken";

	// Where the uploaded product images are stored, started from approot/:
	public $productImagesFolder = 'productimages'; 

	// Images uploaded by the customer (for example, for Poster Shops)
	public $uploadedImagesFolder = 'uploadedimages'; 

	public $adminLayout = 'application.modules.shop.views.layouts.shop';
	public $layout = 'application.modules.shop.views.layouts.shop';

	// Set this to enable Paypal payment. See docs/paypal.txt
	public $payPalMethod = false;
	public $payPalTestMode = true;
	public $payPalUrl = '//shop/order/paypal';
	public $payPalBusinessEmail = 'webmaster@example.com';

	// Rich text editor for the product description textarea.
	// for example, set this to the path of your ckeditor installation
	// to enable it
	public $rtepath = false; // Don't use an Rich text Editor
	public $rteadapter = false; // Don't use an Adapter


	// Set $allowPositionLiveChange to false if you have too many Variations in
	// an article. Changing of variations is not possible in the shopping cart
	// view anymore then.
	public $allowPositionLiveChange = true;

	public function init()
	{
		$this->setImport(array(
			'shop.models.*',
			'shop.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
