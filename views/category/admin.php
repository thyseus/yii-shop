<?php 

$model = new Category();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'class'=>'CButtonColumn', 
			'viewButtonUrl' => 'Yii::app()->createUrl("/shop/category/view",
			array("id" => $data->category_id))',
			'updateButtonUrl' => 'Yii::app()->createUrl("/shop/category/update",
			array("id" => $data->category_id))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("/shop/category/delete",
			array("id" => $data->category_id))',
		),
	),
)); 

echo CHtml::link(Yii::t('ShopModule.shop', 'Create a new Category'), array('category/create'));

?>
