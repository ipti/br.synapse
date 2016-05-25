<?php

/**
 * This is the model class for table "classroom".
 *
 * The followings are the available columns in table 'classroom':
 * @property integer $id
 * @property string $name
 * @property integer $inep_id
 * @property integer $school_fk
 * @property integer $stage_fk
 *
 * The followings are the available model relations:
 * @property School $schoolFk
 * @property EdcensoStageVsModality $stageFk
 */
class Classroom extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Classroom the static model class
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
		return 'classroom';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, school_fk, stage_fk', 'required'),
			array('inep_id, school_fk, stage_fk', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, inep_id, school_fk, stage_fk', 'safe', 'on'=>'search'),
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
			'schoolFk' => array(self::BELONGS_TO, 'School', 'school_fk'),
			'stageFk' => array(self::BELONGS_TO, 'EdcensoStageVsModality', 'stage_fk'),
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
			'inep_id' => Yii::t('default', 'Inep'),
			'school_fk' => Yii::t('default', 'School Fk'),
			'stage_fk' => Yii::t('default', 'Stage Fk'),
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
		$criteria->compare('inep_id',$this->inep_id);
		$criteria->compare('school_fk',$this->school_fk);
		$criteria->compare('stage_fk',$this->stage_fk);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}