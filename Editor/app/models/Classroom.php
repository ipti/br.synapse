<?php

/**
 * This is the model class for table "classroom".
 *
 * The followings are the available columns in table 'classroom':
 * @property integer $id
 * @property string $name
 * @property string $inep_id
 * @property integer $school_fk
 * @property integer $stage_fk
 * @property integer $year
 * @property integer $fk_id
 * @property string $source
 *
 * The followings are the available model relations:
 * @property Actor[] $actors
 * @property School $schoolFk
 * @property EdcensoStageVsModality $stageFk
 */
class Classroom extends CActiveRecord
{
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
			array('school_fk, stage_fk, year, fk_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('inep_id', 'length', 'max'=>14),
			array('source', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, inep_id, school_fk, stage_fk, year, fk_id, source', 'safe', 'on'=>'search'),
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
			'actors' => array(self::HAS_MANY, 'Actor', 'classroom_fk'),
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
			'id' => 'ID',
			'name' => 'Name',
			'inep_id' => 'Inep',
			'school_fk' => 'School Fk',
			'stage_fk' => 'Stage Fk',
			'year' => 'Year',
			'fk_id' => 'Fk',
			'source' => 'Source',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('inep_id',$this->inep_id,true);
		$criteria->compare('school_fk',$this->school_fk);
		$criteria->compare('stage_fk',$this->stage_fk);
		$criteria->compare('year',$this->year);
		$criteria->compare('fk_id',$this->fk_id);
		$criteria->compare('source',$this->source,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Classroom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
