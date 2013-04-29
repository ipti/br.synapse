<?php

/**
 * This is the model class for table "organization".
 *
 * The followings are the available columns in table 'organization':
 * @property integer $ID
 * @property string $acronym
 * @property string $name
 * @property integer $fatherID
 * @property integer $orgLevel
 *
 * The followings are the available model relations:
 * @property Personage[] $personages
 * @property Unity[] $unities
 */
class Organization extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Organization the static model class
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
		return 'organization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fatherID, orgLevel', 'numerical', 'integerOnly'=>true),
			array('acronym, name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, acronym, name, fatherID, orgLevel', 'safe', 'on'=>'search'),
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
			'personages' => array(self::HAS_MANY, 'Personage', 'organizationID'),
			'unities' => array(self::HAS_MANY, 'Unity', 'organizationID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'acronym' => Yii::t('default', 'Acronym'),
			'name' => Yii::t('default', 'Name'),
			'fatherID' => Yii::t('default', 'Father'),
			'orgLevel' => Yii::t('default', 'Org Level'),
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
		$criteria->compare('acronym',$this->acronym,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('fatherID',$this->fatherID);
		$criteria->compare('orgLevel',$this->orgLevel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}