<?php

/**
 * This is the model class for table "editor_piece_element".
 *
 * The followings are the available columns in table 'editor_piece_element':
 * @property integer $id
 * @property integer $piece_id
 * @property integer $element_id
 * @property integer $position
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property EditorEvents[] $editorEvents
 * @property EditorPiece $piece
 * @property EditorElement $element
 * @property EditorPieceelementProperty[] $editorPieceelementProperties
 * @property PeformanceActor[] $peformanceActors
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
			array('piece_id, element_id', 'required'),
			array('piece_id, element_id, position, oldID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, piece_id, element_id, position, oldID', 'safe', 'on'=>'search'),
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
			'editorEvents' => array(self::HAS_MANY, 'EditorEvents', 'piece_element_id'),
			'piece' => array(self::BELONGS_TO, 'EditorPiece', 'piece_id'),
			'element' => array(self::BELONGS_TO, 'EditorElement', 'element_id'),
			'editorPieceelementProperties' => array(self::HAS_MANY, 'EditorPieceelementProperty', 'piece_element_id'),
			'peformanceActors' => array(self::HAS_MANY, 'PeformanceActor', 'piece_element_id'),
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
			'element_id' => Yii::t('default', 'Element'),
			'position' => Yii::t('default', 'Position'),
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
		$criteria->compare('piece_id',$this->piece_id);
		$criteria->compare('element_id',$this->element_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}