<?php

/**
 * This is the model class for table "editor_element_property".
 *
 * The followings are the available columns in table 'editor_element_property':
 * @property integer $ID
 * @property integer $propertyID
 * @property integer $elementID
 * @property string $value
 *
 * The followings are the available model relations:
 * @property EditorElement $element
 * @property CommonProperty $property
 */
class EditorElementProperty extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorElementProperty the static model class
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
		return 'editor_element_property';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propertyID, elementID', 'required'),
			array('propertyID, elementID', 'numerical', 'integerOnly'=>true),
			array('value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, propertyID, elementID, value', 'safe', 'on'=>'search'),
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
			'element' => array(self::BELONGS_TO, 'EditorElement', 'elementID'),
			'property' => array(self::BELONGS_TO, 'CommonProperty', 'propertyID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'propertyID' => Yii::t('default', 'Property'),
			'elementID' => Yii::t('default', 'Element'),
			'value' => Yii::t('default', 'Value'),
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
		$criteria->compare('propertyID',$this->propertyID);
		$criteria->compare('elementID',$this->elementID);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}