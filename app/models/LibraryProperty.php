<?php

/**
 * This is the model class for table "library_property".
 *
 * The followings are the available columns in table 'library_property':
 * @property integer $ID
 * @property integer $propertyID
 * @property string $value
 * @property integer $libraryID
 *
 * The followings are the available model relations:
 * @property CommonProperty $property
 * @property Library $library
 */
class LibraryProperty extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LibraryProperty the static model class
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
		return 'library_property';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propertyID, value, libraryID', 'required'),
			array('propertyID, libraryID', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, propertyID, value, libraryID', 'safe', 'on'=>'search'),
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
			'property' => array(self::BELONGS_TO, 'CommonProperty', 'propertyID'),
			'library' => array(self::BELONGS_TO, 'Library', 'libraryID'),
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
			'value' => Yii::t('default', 'Value'),
			'libraryID' => Yii::t('default', 'Library'),
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
		$criteria->compare('value',$this->value,true);
		$criteria->compare('libraryID',$this->libraryID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}