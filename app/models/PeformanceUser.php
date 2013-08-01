<?php

/**
 * This is the model class for table "peformance_user".
 *
 * The followings are the available columns in table 'peformance_user':
 * @property integer $ID
 * @property integer $pieceID
 * @property integer $pieceElementID
 * @property integer $userID
 * @property string $date
 * @property string $value
 * @property integer $iscorrect
 *
 * The followings are the available model relations:
 * @property User $user
 * @property EditorPieceElement $pieceElement
 * @property EditorPiece $piece
 */
class PeformanceUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeformanceUser the static model class
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
		return 'peformance_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pieceID, pieceElementID, userID', 'required'),
			array('pieceID, pieceElementID, userID, iscorrect', 'numerical', 'integerOnly'=>true),
			array('date, value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, pieceID, pieceElementID, userID, date, value, iscorrect', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userID'),
			'pieceElement' => array(self::BELONGS_TO, 'EditorPieceElement', 'pieceElementID'),
			'piece' => array(self::BELONGS_TO, 'EditorPiece', 'pieceID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'pieceID' => Yii::t('default', 'Piece'),
			'pieceElementID' => Yii::t('default', 'Piece Element'),
			'userID' => Yii::t('default', 'User'),
			'date' => Yii::t('default', 'Date'),
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('pieceID',$this->pieceID);
		$criteria->compare('pieceElementID',$this->pieceElementID);
		$criteria->compare('userID',$this->userID);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('iscorrect',$this->iscorrect);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}