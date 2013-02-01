<?php

class Image extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->controller->module->imageTable;
	}

	public function rules()
	{
		return array(
			array('title, filename, product_id', 'required'),
			array('id, product_id', 'numerical', 'integerOnly'=>true),
			array('title, filename', 'length', 'max'=>45),
			//array('filename' => 'file', 'types' => 'png,gif,jpg,jpeg'),
			array('id, title, filename, product_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Product' => array(self::BELONGS_TO, 'Products', 'product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => Yii::t('shop', 'Title'),
			'filename' => Yii::t('shop', 'Filename'),
			'product_id' => Yii::t('shop', 'Product'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('title',$this->title,true);

		$criteria->compare('filename',$this->filename,true);

		$criteria->compare('product_id',$this->product_id);

		return new CActiveDataProvider('Image', array(
			'criteria'=>$criteria,
		));
	}
}
