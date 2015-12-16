<?php

/**
 * This is the model class for table "userclass".
 *
 * The followings are the available columns in table 'userclass':
 * @property integer $ID
 * @property string $name
 * @property integer $sysID
 * @property string $code
 * @property integer $degreeID
 *
 * The followings are the available model relations:
 * @property UserUserclass[] $userUserclasses
 * @property UserSystem $sys
 * @property ActDegree $degree
 * @property UserclassMatrix[] $userclassMatrixes
 */
class Userclass extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Userclass the static model class
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
		return 'userclass';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sysID, degreeID', 'required'),
			array('sysID, degreeID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, sysID, code, degreeID', 'safe', 'on'=>'search'),
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
			'userUserclasses' => array(self::HAS_MANY, 'UserUserclass', 'classID'),
			'sys' => array(self::BELONGS_TO, 'UserSystem', 'sysID'),
			'degree' => array(self::BELONGS_TO, 'ActDegree', 'degreeID'),
			'userclassMatrixes' => array(self::HAS_MANY, 'UserclassMatrix', 'classID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'name' => Yii::t('default', 'Name'),
			'sysID' => Yii::t('default', 'Sys'),
			'code' => Yii::t('default', 'Code'),
			'degreeID' => Yii::t('default', 'Degree'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sysID',$this->sysID);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('degreeID',$this->degreeID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}