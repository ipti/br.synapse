<?php

/**
 * This is the model class for table "editor_pieceset".
 *
 * The followings are the available columns in table 'editor_pieceset':
 * @property integer $ID
 * @property integer $typeID
 * @property string $desc
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property CommonType $type
 * @property EditorPiecesetPiece[] $editorPiecesetPieces
 * @property EditorScreenPieceset[] $editorScreenPiecesets
 * @property EditorScreenPieceset[] $editorScreenPiecesets1
 * @property PerformancePiecesetCache[] $performancePiecesetCaches
 */
class EditorPieceset extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorPieceset the static model class
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
		return 'editor_pieceset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeID, oldID', 'required'),
			array('typeID, oldID', 'numerical', 'integerOnly'=>true),
			array('desc', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, typeID, desc, oldID', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'CommonType', 'typeID'),
			'editorPiecesetPieces' => array(self::HAS_MANY, 'EditorPiecesetPiece', 'piecesetID'),
			'editorScreenPiecesets' => array(self::HAS_MANY, 'EditorScreenPieceset', 'piecesetID'),
			'editorScreenPiecesets1' => array(self::HAS_MANY, 'EditorScreenPieceset', 'piecesetParent'),
			'performancePiecesetCaches' => array(self::HAS_MANY, 'PerformancePiecesetCache', 'piecesetID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'typeID' => Yii::t('default', 'Type'),
			'desc' => Yii::t('default', 'Desc'),
			'oldID' => Yii::t('default', 'Old'),
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
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}