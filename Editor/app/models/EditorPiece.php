<?php

/**
 * This is the model class for table "editor_piece".
 *
 * The followings are the available columns in table 'editor_piece':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $type_id
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property CommonType $type
 * @property EditorPieceElement[] $editorPieceElements
 * @property EditorPieceProperty[] $editorPieceProperties
 * @property EditorPiecesetPiece[] $editorPiecesetPieces
 * @property PeformanceActor[] $peformanceActors
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
			array('type_id, oldID', 'numerical', 'integerOnly'=>true),
			array('name, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, type_id, oldID', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'CommonType', 'type_id'),
			'editorPieceElements' => array(self::HAS_MANY, 'EditorPieceElement', 'piece_id'),
			'editorPieceProperties' => array(self::HAS_MANY, 'EditorPieceProperty', 'piece_id'),
			'editorPiecesetPieces' => array(self::HAS_MANY, 'EditorPiecesetPiece', 'piece_id'),
			'peformanceActors' => array(self::HAS_MANY, 'PeformanceActor', 'piece_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'name' => Yii::t('default', 'Name'),
			'description' => Yii::t('default', 'Description'),
			'type_id' => Yii::t('default', 'Type'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}