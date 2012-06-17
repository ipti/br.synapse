<?php

/**
 * This is the model class for table "cobject".
 *
 * The followings are the available columns in table 'cobject':
 * @property integer $ID
 * @property integer $typeID
 * @property integer $templateID
 * @property integer $themeID
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property CobjectTemplate $template
 * @property CobjectTheme $theme
 * @property CommonType $type
 * @property CobjectCobjectblock[] $cobjectCobjectblocks
 * @property CobjectMetadata[] $cobjectMetadatas
 * @property EditorScreen[] $editorScreens
 * @property PerfomanceCobjectCache[] $perfomanceCobjectCaches
 */
class Cobject extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cobject the static model class
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
		return 'cobject';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeID, templateID, themeID', 'required'),
			array('typeID, templateID, themeID, oldID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, typeID, templateID, themeID, oldID', 'safe', 'on'=>'search'),
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
			'template' => array(self::BELONGS_TO, 'CobjectTemplate', 'templateID'),
			'theme' => array(self::BELONGS_TO, 'CobjectTheme', 'themeID'),
			'type' => array(self::BELONGS_TO, 'CommonType', 'typeID'),
			'cobjectCobjectblocks' => array(self::HAS_MANY, 'CobjectCobjectblock', 'cobjectID'),
			'cobjectMetadatas' => array(self::HAS_MANY, 'CobjectMetadata', 'cobjectID'),
			'editorScreens' => array(self::HAS_MANY, 'EditorScreen', 'cobjectID'),
			'perfomanceCobjectCaches' => array(self::HAS_MANY, 'PerfomanceCobjectCache', 'cobjectID'),
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
			'templateID' => Yii::t('default', 'Template'),
			'themeID' => Yii::t('default', 'Theme'),
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
		$criteria->compare('templateID',$this->templateID);
		$criteria->compare('themeID',$this->themeID);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}