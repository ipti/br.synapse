<?php

/**
 * This is the model class for table "act_modality".
 *
 * The followings are the available columns in table 'act_modality':
 * @property integer $ID
 * @property string $name
 * @property integer $modalityParent
 *
 * The followings are the available model relations:
 * @property ActGoalModality[] $actGoalModalities
 * @property ActModality $modalityParent0
 * @property ActModality[] $actModalities
 */
class ActModality extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActModality the static model class
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
		return 'act_modality';
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
			array('modalityParent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>90),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, modalityParent', 'safe', 'on'=>'search'),
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
			'actGoalModalities' => array(self::HAS_MANY, 'ActGoalModality', 'modalityID'),
			'modalityParent0' => array(self::BELONGS_TO, 'ActModality', 'modalityParent'),
			'actModalities' => array(self::HAS_MANY, 'ActModality', 'modalityParent'),
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
			'modalityParent' => Yii::t('default', 'Modality Parent'),
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
		$criteria->compare('modalityParent',$this->modalityParent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}