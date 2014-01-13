<?php

/**
 * This is the model class for table "act_goal_matrix".
 *
 * The followings are the available columns in table 'act_goal_matrix':
 * @property integer $id
 * @property integer $goal_id
 * @property integer $matrix_id
 *
 * The followings are the available model relations:
 * @property ActGoal $goal
 * @property ActMatrix $matrix
 */
class ActGoalMatrix extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActGoalMatrix the static model class
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
		return 'act_goal_matrix';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goal_id, matrix_id', 'required'),
			array('goal_id, matrix_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, goal_id, matrix_id', 'safe', 'on'=>'search'),
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
			'goal' => array(self::BELONGS_TO, 'ActGoal', 'goal_id'),
			'matrix' => array(self::BELONGS_TO, 'ActMatrix', 'matrix_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'goal_id' => Yii::t('default', 'Goal'),
			'matrix_id' => Yii::t('default', 'Matrix'),
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
		$criteria->compare('goal_id',$this->goal_id);
		$criteria->compare('matrix_id',$this->matrix_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}