<?php

/**
 * This is the model class for table "user_system".
 *
 * The followings are the available columns in table 'user_system':
 * @property integer $ID
 * @property string $name
 * @property string $logo
 * @property string $url
 * @property string $webservice
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property Userclass[] $userclasses
 */
class UserSystem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserSystem the static model class
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
		return 'user_system';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, logo, url, webservice', 'required'),
			array('name', 'length', 'max'=>60),
			array('logo, url, webservice', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, logo, url, webservice', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'sysID'),
			'userclasses' => array(self::HAS_MANY, 'Userclass', 'sysID'),
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
			'logo' => Yii::t('default', 'Logo'),
			'url' => Yii::t('default', 'Url'),
			'webservice' => Yii::t('default', 'Webservice'),
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
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('webservice',$this->webservice,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}