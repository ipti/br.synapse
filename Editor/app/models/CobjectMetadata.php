<?php

/**
 * This is the model class for table "cobject_metadata".
 *
 * The followings are the available columns in table 'cobject_metadata':
 * @property integer $id
 * @property integer $cobject_id
 * @property integer $type_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property CommonType $type
 * @property Cobject $cobject
 */
class CobjectMetadata extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CobjectMetadata the static model class
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
		return 'cobject_metadata';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cobject_id, type_id, value', 'required'),
			array('cobject_id, type_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cobject_id, type_id, value', 'safe', 'on'=>'search'),
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
			'cobject' => array(self::BELONGS_TO, 'Cobject', 'cobject_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'cobject_id' => Yii::t('default', 'Cobject'),
			'type_id' => Yii::t('default', 'Type'),
			'value' => Yii::t('default', 'Value'),
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
		$criteria->compare('cobject_id',$this->cobject_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}