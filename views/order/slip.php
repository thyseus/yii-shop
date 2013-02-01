<?php
Shop::register('css/shop_print.css', 'print');
Shop::register('js/print.js');
Yii::app()->clientScript->registerScript('print',  " $('#slip').printElement(); " );

?>

<div id="slip">
<table width="100%" border="0">
  <tr> 
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php $model->deliveryAddress->renderAddress(); ?><br>
            <br>
            <strong><?php echo Shop::t('Payment Method'); ?></strong> 
						<?php echo $model->paymentMethod->title; ?><br>
            <strong><?php echo Shop::t('Order number'); ?></strong> 
						<?php echo $model->order_id; ?><br>
            <strong><?php echo Shop::t('date'); ?></strong> 
						<?php echo date(Shop::module()->dateFormat, $model->ordering_date); ?><br>
            </font></td>
          <td width="1"><?php echo CHtml::image(Shop::module()->logoPath, ''); ?></td>
        </tr>
      </table>
      <br>
      <table style="border-top:1px solid; border-bottom:1px solid;" width="100%" border="0">
        <tr bgcolor="#f1f1f1"> 
          <td width="50%"> 
            <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>
							<?php echo Shop::t('Delivery address'); ?>
            </strong><br>
          </font></p></td>
          <td> 
            <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>              </strong><strong>
							<?php echo Shop::t('Billing address'); ?>
            </strong><br>
          </font> </p></td>
        </tr>
        <tr>
          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
							<?php $model->deliveryAddress->renderAddress(); ?>
          </font></td>
          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
							<?php $model->billingAddress->renderAddress(); ?>
          </font></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
<table style="border-bottom:1px solid;" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo Shop::t('Products'); ?></strong></font></td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="f1f1f1">
        <tr> 
          <td colspan="2" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo Shop::t('Amount'); ?></font></strong></div></td>
          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo Shop::t('Product'); ?></font></strong></td>
		  <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo Shop::t('Product number'); ?></font></strong></td>
        </tr>
<?php foreach($model->products as $position) { ?>
        <tr> 
          <td width="20" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $position->amount; ?></font></div></td>
          <td width="20" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">x</font></div></td>
          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $position->product->title; ?></strong> <em><?php echo $position->listSpecifications(); ?></em></font></td>
		  <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $position->product_id; ?></font></td>
        </tr>
        <?php } ?> </table>
	</td>
  </tr>
</table>
<br />
<br />
<br />
<div id="print-footer">
<?php $this->renderPartial(Shop::module()->footerView); ?>
</div>
</div>
