<?php

/**
 * This is the model class for table "editor_element_alias".
 *
 * The followings are the available columns in table 'editor_element_alias':
 * @property integer $ID
 * @property integer $originalElementID
 * @property integer $originalTypeID
 * @property integer $typeID
 * @property integer $elementID
 *
 * The followings are the available model relations:
 * @property EditorElement $originalElement
 * @property CommonType $originalType
 */
class EditorElementAlias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorElementAlias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'editor_element_alias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('originalElementID, originalTypeID, typeID, elementID', 'required'),
			array('originalElementID, originalTypeID, typeID, elementID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, originalElementID, originalTypeID, typeID, elementID', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'originalElement' => array(self::BELONGS_TO, 'EditorElement', 'originalElementID'),
			'originalType' => array(self::BELONGS_TO, 'CommonType', 'originalTypeID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'originalElementID' => Yii::t('default', 'Original Element'),
			'originalTypeID' => Yii::t('default', 'Original Type'),
			'typeID' => Yii::t('default', 'Type'),
			'elementID' => Yii::t('default', 'Element'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('originalElementID',$this->originalElementID);
		$criteria->compare('originalTypeID',$this->originalTypeID);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('elementID',$this->elementID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}