<?php 

function renderVariation($variation, $i) { 
	if(!ProductSpecification::model()->findByPk(1))
		return false;
	if(!$variation) {
		$variation = new ProductVariation;
		$variation->specification_id = 1;
	}

	$str = '<tr> <td>';
	$str .= CHtml::dropDownList("Variations[{$i}][specification_id]",
			$variation->specification_id, CHtml::listData(
				ProductSpecification::model()->findall(), "id", "title"), array(
				'empty' => '-'));  

	$str .= '</td> <td>';
	$str .= CHtml::textField("Variations[{$i}][title]", $variation->title); 
	$str .= '</td> <td>';

	// Price adjustion
	$str .= CHtml::dropDownList("Variations[{$i}][sign_price]",
			$variation->price_adjustion >= 0 ? '+' : '-', array(
				'+' => '+',
				'-' => '-'));
	$str .= '</td> <td>';
	$str .= CHtml::textField("Variations[{$i}][price_adjustion]",
			abs($variation->price_adjustion),
			array('size' => 5));  

	// Weight adjustion
	$str .= '</td> <td>';
	$str .= CHtml::dropDownList("Variations[{$i}][sign_weight]",
			$variation->weight_adjustion >= 0 ? '+' : '-', array(
				'+' => '+',
				'-' => '-'));
	$str .= '</td> <td>';
	$str .= CHtml::textField(
			"Variations[{$i}][weight_adjustion]", abs($variation->weight_adjustion),
			array('size' => 5));  
	$str .= '</td> <td>';
	for($j = -10; $j <= 10; $j++)
		$positions[$j] = $j;
	$str .= CHtml::dropDownList("Variations[{$i}][position]",
			$variation->position,
			$positions);
	$str .= '</td></tr>';

return $str;
} ?>
<div class="form">

<?php
if(Shop::module()->rtepath !== false) {
	Yii::app()->clientScript->registerScriptFile(Shop::module()->rtepath, CClientScript::POS_HEAD); 
	Yii::app()->clientScript->registerScript("ckeditor", "$('#Products_description').ckeditor();");
}
if(Shop::module()->rteadapter !== false)
	Yii::app()->clientScript->registerScriptFile(Shop::module()->rteadapter, CClientScript::POS_HEAD); 


 $form=$this->beginWidget('CActiveForm', array(
			'id'=>'products-form',
			'enableAjaxValidation'=>true,
			'htmlOptions' => array(
				'enctype' => $model->hasUpload() 
				? 'multipart/form-data' 
				: 'x-www-form-urlencoded'
				)
			)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
<legend> <?php echo Shop::t('Article Information'); ?> </legend>

<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array(
			'size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'status'); ?>
<?php echo $form->dropDownList($model, 'status', array(
			0 => Shop::t('Inactive'),
			1 => Shop::t('Active'))); ?>
<?php echo $form->error($model,'status'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'category_id'); ?>
<?php $this->widget('application.modules.shop.components.Relation', array(
			'model' => $model,
			'relation' => 'category',
			'fields' => 'title',
			'showAddButton' => false,
		)); ?>
<?php echo $form->error($model,'category_id'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'tax_id'); ?>
<?php $this->widget('application.modules.shop.components.Relation', array(
			'model' => $model,
			'relation' => 'tax',
			'fields' => 'title',
			'showAddButton' => false,
		)); ?>
<?php echo $form->error($model,'category_id'); ?>
</div>



<div class="row">
<?php echo $form->labelEx($model,'description'); ?>
<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'description'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'keywords'); ?>
<?php echo $form->textField($model,'keywords',array(
			'size'=>45,'maxlength'=>255)); ?>
<?php echo $form->error($model,'keywords'); ?>
</div>

</fieldset>



<fieldset>
<legend> <?php echo Shop::t('Article Specifications'); ?> </legend>

<div class="row">
<?php echo $form->labelEx($model,'price'); ?>
<?php echo $form->textField($model,'price',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'price'); ?>
</div>

<?php foreach(ProductSpecification::model()->findAll() as $specification) { ?>
	<div class="row">
		<?php echo CHtml::label($specification->title, ''); ?>
		<?php echo CHtml::textField("Specifications[{$specification->title}]",
				$model->getSpecification($specification->title),array(
					'size'=>45,'maxlength'=>45)); ?>
		</div>
		<?php } ?>

		</fieldset>
<?php if(!$model->isNewRecord) { ?>
		<fieldset>
		<legend> <?php echo Shop::t('Article Variations'); ?> </legend>
		<div id="variations">

<table>
		<?php 
		printf('<tr><th>%s</th><th>%s</th><th colspan = 2>%s</th><th colspan = 2>%s</th><th>%s</th></tr>',
				Shop::t('Specification'), 
				Shop::t('Value'), 
				Shop::t('Price adjustion'),
				Shop::t('Weight adjustion'),
				Shop::t('Position'));


		$i = 0;
		foreach($model->variations as $variation) { 
			echo renderVariation($variation, $i); 
			$i++;
		}

		$max = $i+5;
		for(;$i < $max;$i++) 
			echo renderVariation(null, $i); 
 ?>
	</table>	
	<?php echo CHtml::button(Shop::t('Save specifications'), array(
				'submit' => array(
					'//shop/products/update',
					'return' => 'product',
					'id' => $model->product_id))); ?>


				</fieldset>

				<?php } else
				printf('<div class="hint">%s</div>', Shop::t(
							'You can set product variations after you created the product')); 
						?>


				<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ?
						Yii::t('ShopModule.shop', 'Create') 
						: Yii::t('ShopModule.shop', 'Save')); ?>
				</div>

				<?php $this->endWidget(); ?>

				</div><!-- form -->
