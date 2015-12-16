<?php

/**
 * This is the model class for table "actor".
 *
 * The followings are the available columns in table 'actor':
 * @property integer $id
 * @property integer $unity_id
 * @property integer $person_id
 * @property integer $personage_id
 * @property string $fk_code
 * @property integer $active_date
 * @property integer $desactive_date
 *
 * The followings are the available model relations:
 * @property Unity $unity
 * @property Personage $personage
 * @property Person $person
 * @property ActorInteraction[] $actorInteractions
 * @property PeformanceActor[] $peformanceActors
 */
class Actor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Actor the static model class
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
			array('unity_id, person_id, personage_id', 'required'),
			array('unity_id, person_id, personage_id, active_date, desactive_date', 'numerical', 'integerOnly'=>true),
			array('fk_code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, unity_id, person_id, personage_id, fk_code, active_date, desactive_date', 'safe', 'on'=>'search'),
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
			'unity' => array(self::BELONGS_TO, 'Unity', 'unity_id'),
			'personage' => array(self::BELONGS_TO, 'Personage', 'personage_id'),
			'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
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
			'id' => Yii::t('default', 'ID'),
			'unity_id' => Yii::t('default', 'Unity'),
			'person_id' => Yii::t('default', 'Person'),
			'personage_id' => Yii::t('default', 'Personage'),
			'fk_code' => Yii::t('default', 'Fk Code'),
			'active_date' => Yii::t('default', 'Active Date'),
			'desactive_date' => Yii::t('default', 'Desactive Date'),
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
		$criteria->compare('unity_id',$this->unity_id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('personage_id',$this->personage_id);
		$criteria->compare('fk_code',$this->fk_code,true);
		$criteria->compare('active_date',$this->active_date);
		$criteria->compare('desactive_date',$this->desactive_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}