<?php

/**
 * This is the model class for table "act_goal_modality".
 *
 * The followings are the available columns in table 'act_goal_modality':
 * @property integer $ID
 * @property integer $goalID
 * @property integer $modalityID
 *
 * The followings are the available model relations:
 * @property ActGoal $goal
 * @property ActModality $modality
 */
class ActGoalModality extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActGoalModality the static model class
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
		return 'act_goal_modality';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goalID, modalityID', 'required'),
			array('goalID, modalityID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, goalID, modalityID', 'safe', 'on'=>'search'),
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
			'modality' => array(self::BELONGS_TO, 'ActModality', 'modalityID'),
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
			'modalityID' => Yii::t('default', 'Modality'),
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
		$criteria->compare('modalityID',$this->modalityID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}