<?php
	 function getSpecifications($position) {
		$string = '<table class="specifications">';
		foreach($position->getSpecifications() as $key =>$specification) {
			if($model = ProductSpecification::model()->findByPk($key)) {
				if($model->input_type == 'textfield') {
					$title = $model->title;				
					$value = $specification[0];
				}
				else  {
					$title = $model->title;				
					$productvariation = ProductVariation::model()->findByPk($specification[0]);
					if($productvariation)
						$value = $productvariation->title;
					else
						$value = '';
				}
			} else if($key == 'image')  {
				$title = Shop::t('Filename');
				$value = $specification;
			}

			$string .= sprintf('<tr><td>%s</td><td>%s</td></tr>',
					@$title,
					@$value	
					);
		}
		$string .= '</table>';
		return $string;
	}

	$this->widget('zii.widgets.CDetailView', array(
				'data'=>$position,
				'attributes'=> array(
					'product.title',
					'amount',
					array(
						'label' => Shop::t('Specifications'),
						'type' => 'raw',
						'value' => getSpecifications($position))
					)
				)
			); 


