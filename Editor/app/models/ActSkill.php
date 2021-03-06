<?php

/**
 * This is the model class for table "act_skill".
 *
 * The followings are the available columns in table 'act_skill':
 * @property integer $id
 * @property string $name
 * @property integer $skill_parent
 *
 * The followings are the available model relations:
 * @property ActGoalSkill[] $actGoalSkills
 * @property ActSkill $skillParent
 * @property ActSkill[] $actSkills
 */
class ActSkill extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActSkill the static model class
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
		return 'act_skill';
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
			array('skill_parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, skill_parent, oldID', 'safe', 'on'=>'search'),
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
			'actGoalSkills' => array(self::HAS_MANY, 'ActGoalSkill', 'skill_id'),
			'skillParent' => array(self::BELONGS_TO, 'ActSkill', 'skill_parent'),
			'actSkills' => array(self::HAS_MANY, 'ActSkill', 'skill_parent'),
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
			'skill_parent' => Yii::t('default', 'Skill Parent'),
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
		$criteria->compare('skill_parent',$this->skill_parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}