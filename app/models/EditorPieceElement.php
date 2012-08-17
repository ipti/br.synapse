<?php

/**
 * This is the model class for table "editor_piece_element".
 *
 * The followings are the available columns in table 'editor_piece_element':
 * @property integer $ID
 * @property integer $pieceID
 * @property integer $elementID
 *
 * The followings are the available model relations:
 * @property EditorEvents[] $editorEvents
 * @property EditorElement $element
 * @property EditorPiece $piece
 * @property EditorPieceelementProperty[] $editorPieceelementProperties
 * @property PeformanceUser[] $peformanceUsers
 */
class EditorPieceElement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorPieceElement the static model class
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
		return 'editor_piece_element';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pieceID, elementID', 'required'),
			array('pieceID, elementID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, pieceID, elementID', 'safe', 'on'=>'search'),
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
			'editorEvents' => array(self::HAS_MANY, 'EditorEvents', 'pieceElementID'),
			'element' => array(self::BELONGS_TO, 'EditorElement', 'elementID'),
			'piece' => array(self::BELONGS_TO, 'EditorPiece', 'pieceID'),
			'editorPieceelementProperties' => array(self::HAS_MANY, 'EditorPieceelementProperty', 'pieceElementID'),
			'peformanceUsers' => array(self::HAS_MANY, 'PeformanceUser', 'pieceElementID'),
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
			'elementID' => Yii::t('default', 'Element'),
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
		$criteria->compare('elementID',$this->elementID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}