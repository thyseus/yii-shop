<?php

class Category extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getChilds($id) {
		$data = array();

		foreach(Category::model()->findAll('parent_id = ' . $id) as $model) {
			$row['text'] = CHtml::link($model->title, array('category/view', 'id' => $model->category_id));
			$row['children'] = Category::getChilds($model->category_id);
			$data[] = $row;
		}
		return $data;
	}


	public function tableName()
	{
		return Yii::app()->getModule('shop')->categoryTable;
	}

	public function rules()
	{
		return array(
			array('category_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('title, description, language', 'length', 'max'=>45),
			array('title', 'required'),
			array('category_id, parent_id, title, description, language', 'safe', 'on'=>'search'),
		);
	}

	public static function getListed() {
		$subitems = array();
		if($this->childs) foreach($this->childs as $child) {
			$subitems[] = $child->getListed();
		}
		$returnarray = array('label' => $this->title, 'url' => array('Category/view', 'id' => $this->category_id));
		if($subitems != array()) $returnarray = array_merge($returnarray, array('items' => $subitems));
		return $returnarray;
	}

	public function relations()
	{
		return array(
			'Products' => array(self::HAS_MANY, 'Products', 'category_id'),
			'parent' => array(self::BELONGS_TO, 'Category', 'parent_id'),
			'childs' => array(self::HAS_MANY, 'Category', 'parent_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'category_id' => '#',
			'parent_id' => Yii::t('ShopModule.shop', 'Parent'),
			'title' => Yii::t('ShopModule.shop', 'Category'),
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('category_id',$this->category_id);

		$criteria->compare('parent_id',$this->parent_id);

		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider('Category', array(
			'criteria'=>$criteria,
		));
	}
}
