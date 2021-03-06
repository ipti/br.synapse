<?php

/**
 * This is the model class for table "unity".
 *
 * The followings are the available columns in table 'unity':
 * @property integer $id
 * @property string $name
 * @property integer $organization_id
 * @property integer $father_id
 * @property string $fk_code
 * @property integer $active_date
 * @property integer $desactive_date
 * @property integer $inep_id
 *
 * The followings are the available model relations:
 * @property Organization $organization
 * @property UnityTree[] $unityTrees
 * @property UnityTree[] $unityTrees1
 */
class Unity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Unity the static model class
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
		return 'unity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organization_id, father_id, active_date, desactive_date, inep_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('fk_code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, organization_id, father_id, fk_code, active_date, desactive_date, inep_id', 'safe', 'on'=>'search'),
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
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
			'unityTrees' => array(self::HAS_MANY, 'UnityTree', 'primary_unity_id'),
			'unityTrees1' => array(self::HAS_MANY, 'UnityTree', 'secondary_unity_id'),
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
			'organization_id' => Yii::t('default', 'Organization'),
			'father_id' => Yii::t('default', 'Father'),
			'fk_code' => Yii::t('default', 'Fk Code'),
			'active_date' => Yii::t('default', 'Active Date'),
			'desactive_date' => Yii::t('default', 'Desactive Date'),
			'inep_id' => 'Inep',
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
		$criteria->compare('organization_id',$this->organization_id);
		$criteria->compare('father_id',$this->father_id);
		$criteria->compare('fk_code',$this->fk_code,true);
		$criteria->compare('active_date',$this->active_date);
		$criteria->compare('desactive_date',$this->desactive_date);
		$criteria->compare('inep_id',$this->inep_id);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}