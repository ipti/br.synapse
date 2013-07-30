<?php

/**
 * This is the model class for table "peformance_actor".
 *
 * The followings are the available columns in table 'peformance_actor':
 * @property integer $id
 * @property integer $piece_id
 * @property integer $piece_element_id
 * @property integer $actor_id
 * @property integer $start_time
 * @property integer $final_time
 * @property string $value
 * @property string $iscorrect
 *
 * The followings are the available model relations:
 * @property EditorPiece $piece
 * @property EditorPieceElement $pieceElement
 * @property Actor $actor
 */
class PeformanceActor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeformanceActor the static model class
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
		return 'peformance_actor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('piece_id, piece_element_id, actor_id, start_time, final_time', 'required'),
			array('piece_id, piece_element_id, actor_id, start_time, final_time', 'numerical', 'integerOnly'=>true),
			array('iscorrect', 'length', 'max'=>5),
			array('value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, piece_id, piece_element_id, actor_id, start_time, final_time, value, iscorrect', 'safe', 'on'=>'search'),
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
			'piece' => array(self::BELONGS_TO, 'EditorPiece', 'piece_id'),
			'pieceElement' => array(self::BELONGS_TO, 'EditorPieceElement', 'piece_element_id'),
			'actor' => array(self::BELONGS_TO, 'Actor', 'actor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'piece_id' => Yii::t('default', 'Piece'),
			'piece_element_id' => Yii::t('default', 'Piece Element'),
			'actor_id' => Yii::t('default', 'Actor'),
			'start_time' => Yii::t('default', 'Start Time'),
			'final_time' => Yii::t('default', 'Final Time'),
			'value' => Yii::t('default', 'Value'),
			'iscorrect' => Yii::t('default', 'Iscorrect'),
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
		$criteria->compare('piece_id',$this->piece_id);
		$criteria->compare('piece_element_id',$this->piece_element_id);
		$criteria->compare('actor_id',$this->actor_id);
		$criteria->compare('start_time',$this->start_time);
		$criteria->compare('final_time',$this->final_time);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('iscorrect',$this->iscorrect,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}