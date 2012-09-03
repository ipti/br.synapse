<?php

/**
 * This is the model class for table "editor_piece".
 *
 * The followings are the available columns in table 'editor_piece':
 * @property integer $ID
 * @property string $name
 * @property string $description
 * @property integer $typeID
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property CommonType $type
 * @property EditorPieceElement[] $editorPieceElements
 * @property EditorPiecesetPiece[] $editorPiecesetPieces
 * @property PeformanceUser[] $peformanceUsers
 */
class EditorPiece extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorPiece the static model class
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
		return 'editor_piece';
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
			array('name', 'length', 'max'=>60),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, description, typeID, oldID', 'safe', 'on'=>'search'),
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
			'editorPieceElements' => array(self::HAS_MANY, 'EditorPieceElement', 'pieceID'),
			'editorPiecesetPieces' => array(self::HAS_MANY, 'EditorPiecesetPiece', 'pieceID'),
			'peformanceUsers' => array(self::HAS_MANY, 'PeformanceUser', 'pieceID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'name' => Yii::t('default', 'Name'),
			'description' => Yii::t('default', 'Description'),
			'typeID' => Yii::t('default', 'Type'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}