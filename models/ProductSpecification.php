<?php

/**
 * This is the model class for table "shop_product_specification".
 *
 * The followings are the available columns in table 'shop_product_specification':
 * @property integer $id
 * @property string $title
 */
class ProductSpecification extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function __toString() {
		return $this->title;
	}

	public function tableName()
	{
		return 'shop_product_specification';
	}

	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
			array('required', 'numerical'),
			array('input_type, required', 'required'),
			array('input_type', 'in', 'range' => array(
					'none', 'select', 'textfield', 'image')),
			array('id, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'variations' => array(self::HAS_MANY, 'ProductVariation', 'specification_id') 
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Shop::t('Title'),
			'input_type' => Shop::t('Input type'),
			'required' => Shop::t('Required'),
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
