<h1> <?php echo Yii::t('ShopModule.shop', 'Yii Webshop Installation'); ?> </h1>

<?php
$module = Yii::app()->getModule('shop');
echo CHtml::beginForm(array('install')); ?>

<div class="span-12">

<h2> Information: </h2>

<hr />

<p> You are about to install the Yii Webshop Module in your Web 
Application. You require a working Database connection like sqlite, mysql, 
pgsql or other. Please make sure your Database is Accessible
in protected/config/main.php. </p>

<p> This Installer will create the needed database Tables in your Database and
some Demo Data. If you want so see, what will happen exactly, look at the 
install.sql file in the Module Root </p>

<?php if (Yii::app()->db): ?>
<div class="hint"> Your Database Connection seems to be working </div>
<?php else: ?>
<div class="error"> Your Database Connection doesn't seem to be working </div>
<?php endif; ?>

<p> After the Installation, you can configure the views of your shop unter
modules/YiiShop/views. Note that YiiShop does not contain any css files and
almost no predefined layout, so that you can easily integrate this shop in
your already existing Web Application. </p>

<p> The API Documentation, examples and an Database Schema for Mysql Workbench
can be found in the docs/ directory of the Module. </p>

<p> You most probably want to use the Webshop combined with a Role based
Access Manager like Srbac. You find example tutorials on how to do this in
the docs/ directory, too. </p>

<p> To set the language of your Webshop, set the 'language' config param of
your Yii Web Application </p>

</div>

<div class="span-11 last">

<h2> Configuration: </h2>

<hr />

<p> the Yii Webshop Installer will generate the following Table names: </p>

<table>
<tr> 
<td> Table for Product Categories </td>
<td> <?php echo CHtml::textField('categoryTable', $module->categoryTable); ?> </td> </tr>
<tr> 
<td> Table for Products </td>
<td> <?php echo CHtml::textField('productsTable', $module->productsTable); ?> </td> </tr>
<tr> 
<tr> 
<td> Table for Specifications </td>
<td> <?php echo CHtml::textField('productSpecificationsTable', $module->productSpecificationTable); ?> </td> </tr>
<tr> 
<tr> 
<td> Table for Product Variations </td>
<td> <?php echo CHtml::textField('productVariationTable', $module->productVariationTable); ?> </td> </tr>
<tr>
<td> Table for the Orderings </td>
<td> <?php echo CHtml::textField('orderTable', $module->orderTable); ?> </td> </tr>
<tr>
<td> Table for the Order Positions</td>
<td> <?php echo CHtml::textField('orderPositionTable', $module->orderPositionTable); ?> </td> </tr>
<tr> 
<td> Table for the Customers </td>
<td> <?php echo CHtml::textField('customerTable', $module->customerTable); ?> </td> </tr>
<tr> 
<tr> 
<td> Table for Addresses </td>
<td> <?php echo CHtml::textField('addressTable', $module->addressTable); ?> </td> </tr>
<tr> 
<td> Table for the Product Images</td>
<td> <?php echo CHtml::textField('imageTable', $module->imageTable); ?> </td> </tr>
<tr> 
<td> Table for the Shipping Methods</td>
<td> <?php echo CHtml::textField('shippingMethodTable', $module->shippingMethodTable); ?> </td> 
</tr>
<tr> 
<td> Table for the Payment Methods</td>
<td> <?php echo CHtml::textField('paymentMethodTable', $module->paymentMethodTable); ?> </td> 
</tr>
<tr> 
<td> Table for Taxes</td>
<td> <?php echo CHtml::textField('taxTable', $module->taxTable); ?> </td> 
</tr>





</table>

<p> Your Product images will be stored unter Approot
<?php echo $module->productImagesFolder; ?> </p>
</div>


<div style="clear:both;"> </div>

<?php echo CHtml::submitButton(Shop::t('Install Webshop')); ?>
<?php echo CHtml::endForm(); ?>

