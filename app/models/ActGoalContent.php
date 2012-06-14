<?php

/**
 * This is the model class for table "act_goal_content".
 *
 * The followings are the available columns in table 'act_goal_content':
 * @property integer $ID
 * @property integer $goalID
 * @property integer $contentID
 *
 * The followings are the available model relations:
 * @property ActContent $content
 * @property ActGoal $goal
 */
class ActGoalContent extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActGoalContent the static model class
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
		return 'act_goal_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goalID, contentID', 'required'),
			array('goalID, contentID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, goalID, contentID', 'safe', 'on'=>'search'),
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
			'content' => array(self::BELONGS_TO, 'ActContent', 'contentID'),
			'goal' => array(self::BELONGS_TO, 'ActGoal', 'goalID'),
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
			'contentID' => Yii::t('default', 'Content'),
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
		$criteria->compare('contentID',$this->contentID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}