<?php

/**
 * This is the model class for table "act_script".
 *
 * The followings are the available columns in table 'act_script':
 * @property integer $id
 * @property integer $discipline_id
 * @property integer $performance_index
 * @property integer $father_content
 *
 * The followings are the available model relations:
 * @property ActDiscipline $discipline
 * @property ActContent $fatherContent
 * @property ActScriptContent[] $actScriptContents
 */
class ActScript extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActScript the static model class
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
		return 'act_script';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('discipline_id, performance_index, father_content', 'required'),
			array('discipline_id, performance_index, father_content', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, discipline_id, performance_index, father_content', 'safe', 'on'=>'search'),
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
			'discipline' => array(self::BELONGS_TO, 'ActDiscipline', 'discipline_id'),
			'fatherContent' => array(self::BELONGS_TO, 'ActContent', 'father_content'),
			'actScriptContents' => array(self::HAS_MANY, 'ActScriptContent', 'script_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'discipline_id' => Yii::t('default', 'Discipline'),
			'performance_index' => Yii::t('default', 'Performance Index'),
			'father_content' => Yii::t('default', 'Father Content'),
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
		$criteria->compare('discipline_id',$this->discipline_id);
		$criteria->compare('performance_index',$this->performance_index);
		$criteria->compare('father_content',$this->father_content);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}