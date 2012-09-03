<?php

/**
 * This is the model class for table "editor_element".
 *
 * The followings are the available columns in table 'editor_element':
 * @property integer $ID
 * @property integer $typeID
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property CommonType $type
 * @property EditorElementAlias[] $editorElementAliases
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
			array('typeID, oldID', 'required'),
			array('typeID, oldID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, typeID, oldID', 'safe', 'on'=>'search'),
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
			'editorElementAliases' => array(self::HAS_MANY, 'EditorElementAlias', 'originalElementID'),
			'editorElementProperties' => array(self::HAS_MANY, 'EditorElementProperty', 'elementID'),
			'editorPieceElements' => array(self::HAS_MANY, 'EditorPieceElement', 'elementID'),
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
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}