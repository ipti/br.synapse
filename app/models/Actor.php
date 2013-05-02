<?php

/**
 * This is the model class for table "actor".
 *
 * The followings are the available columns in table 'actor':
 * @property integer $ID
 * @property integer $unityID
 * @property integer $personID
 * @property integer $personageID
 * @property integer $activatedDate
 * @property integer $desactivatedDate
 *
 * The followings are the available model relations:
 * @property Unity $unity
 * @property Personage $personage
 * @property Person $person
 * @property PeformanceActor[] $peformanceActors
 * @property PerfomanceCobjectCache[] $perfomanceCobjectCaches
 * @property PerformancePiecesetCache[] $performancePiecesetCaches
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
			array('unityID, personID, personageID', 'required'),
			array('unityID, personID, personageID, activatedDate, desactivatedDate', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, unityID, personID, personageID, activatedDate, desactivatedDate', 'safe', 'on'=>'search'),
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
			'unity' => array(self::BELONGS_TO, 'Unity', 'unityID'),
			'personage' => array(self::BELONGS_TO, 'Personage', 'personageID'),
			'person' => array(self::BELONGS_TO, 'Person', 'personID'),
			'peformanceActors' => array(self::HAS_MANY, 'PeformanceActor', 'actorID'),
			'perfomanceCobjectCaches' => array(self::HAS_MANY, 'PerfomanceCobjectCache', 'actorID'),
			'performancePiecesetCaches' => array(self::HAS_MANY, 'PerformancePiecesetCache', 'actorID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'unityID' => Yii::t('default', 'Unity'),
			'personID' => Yii::t('default', 'Person'),
			'personageID' => Yii::t('default', 'Personage'),
			'activatedDate' => Yii::t('default', 'Activated Date'),
			'desactivatedDate' => Yii::t('default', 'Desactivated Date'),
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
		$criteria->compare('unityID',$this->unityID);
		$criteria->compare('personID',$this->personID);
		$criteria->compare('personageID',$this->personageID);
		$criteria->compare('activatedDate',$this->activatedDate);
		$criteria->compare('desactivatedDate',$this->desactivatedDate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}