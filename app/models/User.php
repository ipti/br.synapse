<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $ID
 * @property string $name
 * @property string $login
 * @property integer $sysID
 * @property string $email
 * @property string $password
 *
 * The followings are the available model relations:
 * @property PeformanceUser[] $peformanceUsers
 * @property PerfomanceCobjectCache[] $perfomanceCobjectCaches
 * @property PerformancePiecesetCache[] $performancePiecesetCaches
 * @property UserSystem $sys
 * @property UserUserclass[] $userUserclasses
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, login, sysID', 'required'),
			array('sysID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('email, password', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, login, sysID, email, password', 'safe', 'on'=>'search'),
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
			'peformanceUsers' => array(self::HAS_MANY, 'PeformanceUser', 'userID'),
			'perfomanceCobjectCaches' => array(self::HAS_MANY, 'PerfomanceCobjectCache', 'userID'),
			'performancePiecesetCaches' => array(self::HAS_MANY, 'PerformancePiecesetCache', 'userID'),
			'sys' => array(self::BELONGS_TO, 'UserSystem', 'sysID'),
			'userUserclasses' => array(self::HAS_MANY, 'UserUserclass', 'userID'),
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
			'login' => Yii::t('default', 'Login'),
			'sysID' => Yii::t('default', 'Sys'),
			'email' => Yii::t('default', 'Email'),
			'password' => Yii::t('default', 'Password'),
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('sysID',$this->sysID);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}