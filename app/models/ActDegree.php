<?php

/**
 * This is the model class for table "act_degree".
 *
 * The followings are the available columns in table 'act_degree':
 * @property integer $id
 * @property string $name
 * @property integer $stage
 * @property integer $year
 * @property integer $grade
 * @property integer $degree_parent
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property ActDegree $degreeParent
 * @property ActDegree[] $actDegrees
 * @property ActGoal[] $actGoals
 * @property ActMatrix[] $actMatrixes
 * @property Organization[] $organizations
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
			array('stage, year, grade, degree_parent, oldID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, stage, year, grade, degree_parent, oldID', 'safe', 'on'=>'search'),
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
			'degreeParent' => array(self::BELONGS_TO, 'ActDegree', 'degree_parent'),
			'actDegrees' => array(self::HAS_MANY, 'ActDegree', 'degree_parent'),
			'actGoals' => array(self::HAS_MANY, 'ActGoal', 'degree_id'),
			'actMatrixes' => array(self::HAS_MANY, 'ActMatrix', 'degree_id'),
			'organizations' => array(self::HAS_MANY, 'Organization', 'degree_id'),
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
			'stage' => Yii::t('default', 'Stage'),
			'year' => Yii::t('default', 'Year'),
			'grade' => Yii::t('default', 'Grade'),
			'degree_parent' => Yii::t('default', 'Degree Parent'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('stage',$this->stage);
		$criteria->compare('year',$this->year);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('degree_parent',$this->degree_parent);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}