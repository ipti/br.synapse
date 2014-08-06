<?php

/**
 * This is the model class for table "cobject".
 *
 * The followings are the available columns in table 'cobject':
 * @property integer $id
 * @property integer $type_id
 * @property integer $template_id
 * @property integer $theme_id
 * @property integer $oldID
 * @property string $status
 * @property integer $father_id
 *
 * The followings are the available model relations:
 * @property CobjectTemplate $template
 * @property CobjectTheme $theme
 * @property CommonType $type
 * @property Cobject $father
 * @property Cobject[] $cobjects
 * @property CobjectCobjectblock[] $cobjectCobjectblocks
 * @property CobjectMetadata[] $cobjectMetadatas
 * @property EditorScreen[] $editorScreens
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
			array('type_id, template_id', 'required'),
			array('type_id, template_id, theme_id, oldID, father_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, template_id, theme_id, oldID, status, father_id', 'safe', 'on'=>'search'),
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
			'theme' => array(self::BELONGS_TO, 'CobjectTheme', 'theme_id'),
			'type' => array(self::BELONGS_TO, 'CommonType', 'type_id'),
			'father' => array(self::BELONGS_TO, 'Cobject', 'father_id'),
			'cobjects' => array(self::HAS_MANY, 'Cobject', 'father_id'),
			'cobjectCobjectblocks' => array(self::HAS_MANY, 'CobjectCobjectblock', 'cobject_id'),
			'cobjectMetadatas' => array(self::HAS_MANY, 'CobjectMetadata', 'cobject_id'),
			'editorScreens' => array(self::HAS_MANY, 'EditorScreen', 'cobject_id','order'=>'`order` ASC'),
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
			'template_id' => Yii::t('default', 'Template'),
			'theme_id' => Yii::t('default', 'Theme'),
			'oldID' => Yii::t('default', 'Old'),
			'status' => Yii::t('default', 'Status'),
			'father_id' => Yii::t('default', 'Father'),
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
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('theme_id',$this->theme_id);
		$criteria->compare('oldID',$this->oldID);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('father_id',$this->father_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}