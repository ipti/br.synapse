<?php

/**
 * This is the model class for table "editor_pieceset_piece".
 *
 * The followings are the available columns in table 'editor_pieceset_piece':
 * @property integer $ID
 * @property integer $piecesetID
 * @property integer $pieceID
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property EditorPiece $piece
 * @property EditorPieceset $pieceset
 */
class EditorPiecesetPiece extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorPiecesetPiece the static model class
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
		return 'editor_pieceset_piece';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('piecesetID, pieceID, order', 'required'),
			array('piecesetID, pieceID, order', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, piecesetID, pieceID, order', 'safe', 'on'=>'search'),
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
			'piece' => array(self::BELONGS_TO, 'EditorPiece', 'pieceID'),
			'pieceset' => array(self::BELONGS_TO, 'EditorPieceset', 'piecesetID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'piecesetID' => Yii::t('default', 'Pieceset'),
			'pieceID' => Yii::t('default', 'Piece'),
			'order' => Yii::t('default', 'Order'),
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
		$criteria->compare('piecesetID',$this->piecesetID);
		$criteria->compare('pieceID',$this->pieceID);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}