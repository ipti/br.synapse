<?php

/**
 * This is the model class for table "act_goal".
 *
 * The followings are the available columns in table 'act_goal':
 * @property integer $ID
 * @property string $name
 * @property integer $degreeID
 * @property integer $disciplineID
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property ActDegree $degree
 * @property ActDiscipline $discipline
 * @property ActGoalContent[] $actGoalContents
 * @property ActGoalMatrix[] $actGoalMatrixes
 * @property ActGoalModality[] $actGoalModalities
 * @property ActGoalSkill[] $actGoalSkills
 */
class ActGoal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActGoal the static model class
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
		return 'act_goal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, degreeID, disciplineID', 'required'),
			array('degreeID, disciplineID, oldID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, degreeID, disciplineID, oldID', 'safe', 'on'=>'search'),
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
			'degree' => array(self::BELONGS_TO, 'ActDegree', 'degreeID'),
			'discipline' => array(self::BELONGS_TO, 'ActDiscipline', 'disciplineID'),
			'actGoalContents' => array(self::HAS_MANY, 'ActGoalContent', 'goalID'),
			'actGoalMatrixes' => array(self::HAS_MANY, 'ActGoalMatrix', 'goalID'),
			'actGoalModalities' => array(self::HAS_MANY, 'ActGoalModality', 'goalID'),
			'actGoalSkills' => array(self::HAS_MANY, 'ActGoalSkill', 'goalID'),
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
			'degreeID' => Yii::t('default', 'Degree'),
			'disciplineID' => Yii::t('default', 'Discipline'),
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
		$criteria->compare('degreeID',$this->degreeID);
		$criteria->compare('disciplineID',$this->disciplineID);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}