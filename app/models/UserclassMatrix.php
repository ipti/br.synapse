<?php

/**
 * This is the model class for table "userclass_matrix".
 *
 * The followings are the available columns in table 'userclass_matrix':
 * @property integer $ID
 * @property integer $matrixID
 * @property integer $classID
 *
 * The followings are the available model relations:
 * @property Userclass $class
 * @property ActMatrix $matrix
 */
class UserclassMatrix extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserclassMatrix the static model class
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
		return 'userclass_matrix';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('matrixID, classID', 'required'),
			array('matrixID, classID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, matrixID, classID', 'safe', 'on'=>'search'),
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
			'class' => array(self::BELONGS_TO, 'Userclass', 'classID'),
			'matrix' => array(self::BELONGS_TO, 'ActMatrix', 'matrixID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'matrixID' => Yii::t('default', 'Matrix'),
			'classID' => Yii::t('default', 'Class'),
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
		$criteria->compare('matrixID',$this->matrixID);
		$criteria->compare('classID',$this->classID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}