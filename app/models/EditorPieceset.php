<?php

/**
 * This is the model class for table "editor_pieceset".
 *
 * The followings are the available columns in table 'editor_pieceset':
 * @property integer $id
 * @property integer $template_id
 * @property string $description
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property CobjectTemplate $template
 * @property EditorPiecesetPiece[] $editorPiecesetPieces
 * @property EditorScreenPieceset[] $editorScreenPiecesets
 * @property EditorPiecesetElement[] $editorPiecesetElements
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
			array('template_id, oldID', 'numerical', 'integerOnly'=>true),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, template_id, description, oldID', 'safe', 'on'=>'search'),
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
			'template' => array(self::BELONGS_TO, 'CobjectTemplate', 'template_id'),
			'editorPiecesetPieces' => array(self::HAS_MANY, 'EditorPiecesetPiece', 'pieceset_id'),
			'editorScreenPiecesets' => array(self::HAS_MANY, 'EditorScreenPieceset', 'pieceset_id'),
                        'editorPiecesetElements' => array(self::HAS_MANY, 'EditorPiecesetElement', 'pieceset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'template_id' => Yii::t('default', 'Template'),
			'description' => Yii::t('default', 'Description'),
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
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}