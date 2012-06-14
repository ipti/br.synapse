<?php

/**
 * This is the model class for table "act_goal_skill".
 *
 * The followings are the available columns in table 'act_goal_skill':
 * @property integer $ID
 * @property integer $goalID
 * @property integer $skillID
 *
 * The followings are the available model relations:
 * @property ActGoal $goal
 * @property ActSkill $skill
 */
class ActGoalSkill extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActGoalSkill the static model class
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
		return 'act_goal_skill';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goalID, skillID', 'required'),
			array('goalID, skillID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, goalID, skillID', 'safe', 'on'=>'search'),
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
			'goal' => array(self::BELONGS_TO, 'ActGoal', 'goalID'),
			'skill' => array(self::BELONGS_TO, 'ActSkill', 'skillID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'goalID' => Yii::t('default', 'Goal'),
			'skillID' => Yii::t('default', 'Skill'),
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
		$criteria->compare('goalID',$this->goalID);
		$criteria->compare('skillID',$this->skillID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}