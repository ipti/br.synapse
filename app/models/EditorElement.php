<?php

/**
 * This is the model class for table "editor_element".
 *
 * The followings are the available columns in table 'editor_element':
 * @property integer $id
 * @property integer $type_id
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property CommonType $type
 * @property EditorElementAlias[] $editorElementAliases
 * @property EditorElementAlias[] $editorElementAliases1
 * @property EditorElementProperty[] $editorElementProperties
 * @property EditorPieceElement[] $editorPieceElements
 */
class EditorElement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorElement the static model class
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
		return 'editor_element';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id', 'required'),
			array('type_id, oldID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, oldID', 'safe', 'on'=>'search'),
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
			'editorElementAliases' => array(self::HAS_MANY, 'EditorElementAlias', 'secondary_id'),
			'editorElementAliases1' => array(self::HAS_MANY, 'EditorElementAlias', 'primary_id'),
			'editorElementProperties' => array(self::HAS_MANY, 'EditorElementProperty', 'element_id'),
			'editorPieceElements' => array(self::HAS_MANY, 'EditorPieceElement', 'element_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}