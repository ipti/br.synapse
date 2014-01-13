<?php

/**
 * This is the model class for table "library_property".
 *
 * The followings are the available columns in table 'library_property':
 * @property integer $id
 * @property integer $property_id
 * @property integer $library_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Library $library
 * @property CommonProperty $property
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
			array('property_id, library_id, value', 'required'),
			array('property_id, library_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, property_id, library_id, value', 'safe', 'on'=>'search'),
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
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
			'property' => array(self::BELONGS_TO, 'CommonProperty', 'property_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'property_id' => Yii::t('default', 'Property'),
			'library_id' => Yii::t('default', 'Library'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('property_id',$this->property_id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}