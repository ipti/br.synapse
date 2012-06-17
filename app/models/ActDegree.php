<?php

/**
 * This is the model class for table "act_degree".
 *
 * The followings are the available columns in table 'act_degree':
 * @property integer $ID
 * @property string $name
 * @property integer $stage
 * @property integer $year
 * @property integer $grade
 * @property integer $degreeParent
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property ActDegree $degreeParent0
 * @property ActDegree[] $actDegrees
 * @property ActGoal[] $actGoals
 * @property ActMatrix[] $actMatrixes
 * @property Userclass[] $userclasses
 */
class ActDegree extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActDegree the static model class
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
		return 'act_degree';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, stage, year, grade', 'required'),
			array('stage, year, grade, degreeParent, oldID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, stage, year, grade, degreeParent, oldID', 'safe', 'on'=>'search'),
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
			'degreeParent0' => array(self::BELONGS_TO, 'ActDegree', 'degreeParent'),
			'actDegrees' => array(self::HAS_MANY, 'ActDegree', 'degreeParent'),
			'actGoals' => array(self::HAS_MANY, 'ActGoal', 'degreeID'),
			'actMatrixes' => array(self::HAS_MANY, 'ActMatrix', 'degreeID'),
			'userclasses' => array(self::HAS_MANY, 'Userclass', 'degreeID'),
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
			'stage' => Yii::t('default', 'Stage'),
			'year' => Yii::t('default', 'Year'),
			'grade' => Yii::t('default', 'Grade'),
			'degreeParent' => Yii::t('default', 'Degree Parent'),
			'oldID' => Yii::t('default', 'Old'),
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
		$criteria->compare('stage',$this->stage);
		$criteria->compare('year',$this->year);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('degreeParent',$this->degreeParent);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}