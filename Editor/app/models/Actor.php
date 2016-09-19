<?php

/**
 * This is the model class for table "actor".
 *
 * The followings are the available columns in table 'actor':
 * @property integer $id
 * @property integer $person_id
 * @property integer $personage_id
 * @property string $fk_code
 * @property integer $active_date
 * @property integer $desactive_date
 * @property integer $classroom_fk
 * @property string $inep_id
 * @property integer $student_enrollment
 * @property integer $fk_id
 * @property string $source
 *
 * The followings are the available model relations:
 * @property Classroom $classroomFk
 * @property Person $person
 * @property Personage $personage
 * @property ActorInteraction[] $actorInteractions
 * @property PeformanceActor[] $peformanceActors
 */
class Actor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, personage_id', 'required'),
			array('person_id, personage_id, active_date, desactive_date, classroom_fk, student_enrollment, fk_id', 'numerical', 'integerOnly'=>true),
			array('inep_id', 'length', 'max'=>14),
			array('source', 'length', 'max'=>10),
			array('fk_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, personage_id, fk_code, active_date, desactive_date, classroom_fk, inep_id, student_enrollment, fk_id, source', 'safe', 'on'=>'search'),
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
			'classroomFk' => array(self::BELONGS_TO, 'Classroom', 'classroom_fk'),
			'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
			'personage' => array(self::BELONGS_TO, 'Personage', 'personage_id'),
			'actorInteractions' => array(self::HAS_MANY, 'ActorInteraction', 'actor_id'),
			'peformanceActors' => array(self::HAS_MANY, 'PeformanceActor', 'actor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'person_id' => 'Person',
			'personage_id' => 'Personage',
			'fk_code' => 'Fk Code',
			'active_date' => 'Active Date',
			'desactive_date' => 'Desactive Date',
			'classroom_fk' => 'Classroom Fk',
			'inep_id' => 'Inep',
			'student_enrollment' => 'Student Enrollment',
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
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('personage_id',$this->personage_id);
		$criteria->compare('fk_code',$this->fk_code,true);
		$criteria->compare('active_date',$this->active_date);
		$criteria->compare('desactive_date',$this->desactive_date);
		$criteria->compare('classroom_fk',$this->classroom_fk);
		$criteria->compare('inep_id',$this->inep_id,true);
		$criteria->compare('student_enrollment',$this->student_enrollment);
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
	 * @return Actor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
