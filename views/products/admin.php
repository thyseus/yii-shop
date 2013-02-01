<h2> <?php echo Shop::t('Products'); ?> </h2>
<?php 

$model = new Products();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'price',
		array(
			'class'=>'CButtonColumn', 
			'template' => '{view}{update}{delete}{images}',
			'viewButtonUrl' => 'Yii::app()->createUrl("/shop/products/view",
			array("id" => $data->product_id))',
			'updateButtonUrl' => 'Yii::app()->createUrl("/shop/products/update",
			array("id" => $data->product_id))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("/shop/products/delete",
			array("id" => $data->product_id))',
			'buttons' => array(
				'images' => array(
					'label' => Yii::t('ShopModule.shop', 'images'),
					'url' => 'Yii::app()->createUrl("/shop/image/admin",
					array("product_id" => $data->product_id))',
				),
			),
		),
	)
)
); 


echo CHtml::link(Shop::t('Create a new Product'), array('products/create'));
?>
