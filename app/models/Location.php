<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $ID
 * @property string $typeLocation
 * @property integer $fatherID
 * @property string $name
 * @property string $acronym
 *
 * The followings are the available model relations:
 * @property Unity[] $unities
 */
class Location extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Location the static model class
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
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('fatherID', 'numerical', 'integerOnly'=>true),
			array('typeLocation', 'length', 'max'=>7),
			array('name', 'length', 'max'=>60),
			array('acronym', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, typeLocation, fatherID, name, acronym', 'safe', 'on'=>'search'),
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
			'unities' => array(self::HAS_MANY, 'Unity', 'locationID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'typeLocation' => Yii::t('default', 'Type Location'),
			'fatherID' => Yii::t('default', 'Father'),
			'name' => Yii::t('default', 'Name'),
			'acronym' => Yii::t('default', 'Acronym'),
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
		$criteria->compare('typeLocation',$this->typeLocation,true);
		$criteria->compare('fatherID',$this->fatherID);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('acronym',$this->acronym,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}