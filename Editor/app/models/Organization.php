<?php

/**
 * This is the model class for table "organization".
 *
 * The followings are the available columns in table 'organization':
 * @property integer $id
 * @property string $acronym
 * @property string $name
 * @property integer $father_id
 * @property integer $orglevel
 * @property integer $degree_id
 * @property string $autochild
 * @property string $fk_code
 *
 * The followings are the available model relations:
 * @property ActDegree $degree
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
			array('acronym, name, orglevel', 'required'),
			array('father_id, orglevel, degree_id', 'numerical', 'integerOnly'=>true),
			array('acronym, name', 'length', 'max'=>45),
			array('autochild', 'length', 'max'=>5),
			array('fk_code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, acronym, name, father_id, orglevel, degree_id, autochild, fk_code', 'safe', 'on'=>'search'),
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
			'degree' => array(self::BELONGS_TO, 'ActDegree', 'degree_id'),
			'personages' => array(self::HAS_MANY, 'Personage', 'organization_id'),
			'unities' => array(self::HAS_MANY, 'Unity', 'organization_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'acronym' => Yii::t('default', 'Acronym'),
			'name' => Yii::t('default', 'Name'),
			'father_id' => Yii::t('default', 'Father'),
			'orglevel' => Yii::t('default', 'Orglevel'),
			'degree_id' => Yii::t('default', 'Degree'),
			'autochild' => Yii::t('default', 'Autochild'),
			'fk_code' => Yii::t('default', 'Fk Code'),
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
		$criteria->compare('acronym',$this->acronym,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('father_id',$this->father_id);
		$criteria->compare('orglevel',$this->orglevel);
		$criteria->compare('degree_id',$this->degree_id);
		$criteria->compare('autochild',$this->autochild,true);
		$criteria->compare('fk_code',$this->fk_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}