<h1> <?php echo Yii::t('ShopModule.shop', 'Yii Webshop Installation'); ?> </h1>

<div class="span-12">
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

<p> the Yii Webshop Installer will generate the following Table names: </p>

<table>
<tr> 
<td> Table for Product Categories </td>
<td> <?php echo Yii::app()->controller->module->categoryTable; ?> </td> </tr>
<tr> 
<td> Table for Products </td>
<td> <?php echo Yii::app()->controller->module->productsTable; ?> </td> </tr>
<tr> 
<td> Table for the Orderings </td>
<td> <?php echo Yii::app()->controller->module->orderTable; ?> </td> </tr>
<tr> 
<td> Table for the Customers </td>
<td> <?php echo Yii::app()->controller->module->customerTable; ?> </td> </tr>
<tr> 
<td> Table for the Product Images</td>
<td> <?php echo Yii::app()->controller->module->imageTable; ?> </td> </tr>
</table>

<p> They can be configured under the module configuration. Please see the 
Documentation on how to do this. </p>

<p> Your Product images will be stored unter Approot<?php echo Yii::app()->controller->module->productImagesFolder; ?> </p>
</div>


<div style="clear:both;"> </div>


<?php echo CHtml::beginForm('install'); ?>
<?php echo CHtml::submitButton(Yii::t('ShopModule.shop', 'Install Webshop')); ?>
<?php echo CHtml::endForm(); ?>

