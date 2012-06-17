<?php

/**
 * This is the model class for table "cobject_template".
 *
 * The followings are the available columns in table 'cobject_template':
 * @property integer $ID
 * @property string $name
 * @property string $code
 * @property integer $oldID
 * @property integer $oldIDFormat
 * @property integer $oldIDInterative
 *
 * The followings are the available model relations:
 * @property Cobject[] $cobjects
 * @property EditorScreenPieceset[] $editorScreenPiecesets
 */
class CobjectTemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CobjectTemplate the static model class
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
		return 'cobject_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code', 'required'),
			array('oldID, oldIDFormat, oldIDInterative', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('code', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, code, oldID, oldIDFormat, oldIDInterative', 'safe', 'on'=>'search'),
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
			'cobjects' => array(self::HAS_MANY, 'Cobject', 'templateID'),
			'editorScreenPiecesets' => array(self::HAS_MANY, 'EditorScreenPieceset', 'templateID'),
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
			'code' => Yii::t('default', 'Code'),
			'oldID' => Yii::t('default', 'Old'),
			'oldIDFormat' => Yii::t('default', 'Old Idformat'),
			'oldIDInterative' => Yii::t('default', 'Old Idinterative'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('oldID',$this->oldID);
		$criteria->compare('oldIDFormat',$this->oldIDFormat);
		$criteria->compare('oldIDInterative',$this->oldIDInterative);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}