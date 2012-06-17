<?php

/**
 * This is the model class for table "common_type".
 *
 * The followings are the available columns in table 'common_type':
 * @property integer $ID
 * @property string $context
 * @property string $name
 * @property integer $typeParent
 * @property string $validator
 * @property string $label
 * @property string $htmlSource
 * @property string $htmlType
 *
 * The followings are the available model relations:
 * @property Cobject[] $cobjects
 * @property CobjectMetadata[] $cobjectMetadatas
 * @property CommonType $typeParent0
 * @property CommonType[] $commonTypes
 * @property EditorElement[] $editorElements
 * @property EditorElementAlias[] $editorElementAliases
 * @property EditorEvents[] $editorEvents
 * @property EditorPiece[] $editorPieces
 * @property EditorPieceset[] $editorPiecesets
 */
class CommonType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommonType the static model class
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
		return 'common_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('context, name', 'required'),
			array('typeParent', 'numerical', 'integerOnly'=>true),
			array('context', 'length', 'max'=>30),
			array('name, label, htmlType', 'length', 'max'=>45),
			array('validator, htmlSource', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, context, name, typeParent, validator, label, htmlSource, htmlType', 'safe', 'on'=>'search'),
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
			'cobjects' => array(self::HAS_MANY, 'Cobject', 'typeID'),
			'cobjectMetadatas' => array(self::HAS_MANY, 'CobjectMetadata', 'typeID'),
			'typeParent0' => array(self::BELONGS_TO, 'CommonType', 'typeParent'),
			'commonTypes' => array(self::HAS_MANY, 'CommonType', 'typeParent'),
			'editorElements' => array(self::HAS_MANY, 'EditorElement', 'typeID'),
			'editorElementAliases' => array(self::HAS_MANY, 'EditorElementAlias', 'originalTypeID'),
			'editorEvents' => array(self::HAS_MANY, 'EditorEvents', 'typeID'),
			'editorPieces' => array(self::HAS_MANY, 'EditorPiece', 'typeID'),
			'editorPiecesets' => array(self::HAS_MANY, 'EditorPieceset', 'typeID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'context' => Yii::t('default', 'Context'),
			'name' => Yii::t('default', 'Name'),
			'typeParent' => Yii::t('default', 'Type Parent'),
			'validator' => Yii::t('default', 'Validator'),
			'label' => Yii::t('default', 'Label'),
			'htmlSource' => Yii::t('default', 'Html Source'),
			'htmlType' => Yii::t('default', 'Html Type'),
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
		$criteria->compare('context',$this->context,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('typeParent',$this->typeParent);
		$criteria->compare('validator',$this->validator,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('htmlSource',$this->htmlSource,true);
		$criteria->compare('htmlType',$this->htmlType,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}