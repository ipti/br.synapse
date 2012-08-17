<?php

/**
 * This is the model class for table "editor_events".
 *
 * The followings are the available columns in table 'editor_events':
 * @property integer $ID
 * @property integer $pieceElementID
 * @property integer $typeID
 * @property string $action
 * @property string $event
 *
 * The followings are the available model relations:
 * @property EditorPieceElement $pieceElement
 * @property CommonType $type
 */
class EditorEvents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorEvents the static model class
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
		return 'editor_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID, pieceElementID, typeID, action, event', 'required'),
			array('ID, pieceElementID, typeID', 'numerical', 'integerOnly'=>true),
			array('event', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, pieceElementID, typeID, action, event', 'safe', 'on'=>'search'),
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
			'pieceElement' => array(self::BELONGS_TO, 'EditorPieceElement', 'pieceElementID'),
			'type' => array(self::BELONGS_TO, 'CommonType', 'typeID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'pieceElementID' => Yii::t('default', 'Piece Element'),
			'typeID' => Yii::t('default', 'Type'),
			'action' => Yii::t('default', 'Action'),
			'event' => Yii::t('default', 'Event'),
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
		$criteria->compare('pieceElementID',$this->pieceElementID);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('event',$this->event,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}