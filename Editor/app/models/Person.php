<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property integer $id
 * @property string $name
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $fk_code
 * @property integer $student_enrollment
 * @property string $mother_name
 * @property string $father_name
 * @property string $birthday
 *
 * The followings are the available model relations:
 * @property Actor[] $actors
 */
class Person extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Person the static model class
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
		return 'person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, login', 'required'),
			array('student_enrollment', 'numerical', 'integerOnly'=>true),
			array('name, mother_name, father_name', 'length', 'max'=>60),
			array('email, password', 'length', 'max'=>255),
			array('birthday', 'length', 'max'=>10),
			array('fk_code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, login, email, password, fk_code, student_enrollment, mother_name, father_name, birthday', 'safe', 'on'=>'search'),
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
			'actors' => array(self::HAS_MANY, 'Actor', 'person_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'name' => Yii::t('default', 'Name'),
			'login' => Yii::t('default', 'Login'),
			'email' => Yii::t('default', 'Email'),
			'password' => Yii::t('default', 'Password'),
			'fk_code' => Yii::t('default', 'Fk Code'),
			'student_enrollment' => Yii::t('default', 'Student Enrollment'),
			'mother_name' => Yii::t('default', 'Mother Name'),
			'father_name' => Yii::t('default', 'Father Name'),
			'birthday' => Yii::t('default', 'Birthday'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fk_code',$this->fk_code,true);
		$criteria->compare('student_enrollment',$this->student_enrollment);
		$criteria->compare('mother_name',$this->mother_name,true);
		$criteria->compare('father_name',$this->father_name,true);
		$criteria->compare('birthday',$this->birthday,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}