<?php

/**
 * This is the model class for table "unity_tree".
 *
 * The followings are the available columns in table 'unity_tree':
 * @property integer $id
 * @property integer $primary_organization_id
 * @property integer $primary_unity_id
 * @property integer $secondary_organization_id
 * @property integer $secondary_unity_id
 *
 * The followings are the available model relations:
 * @property Organization $primaryOrganization
 * @property Unity $primaryUnity
 * @property Organization $secondaryOrganization
 * @property Unity $secondaryUnity
 */
class UnityTree extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UnityTree the static model class
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
		return 'unity_tree';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('primary_organization_id, primary_unity_id, secondary_organization_id, secondary_unity_id', 'required'),
			array('primary_organization_id, primary_unity_id, secondary_organization_id, secondary_unity_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, primary_organization_id, primary_unity_id, secondary_organization_id, secondary_unity_id', 'safe', 'on'=>'search'),
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
			'primaryOrganization' => array(self::BELONGS_TO, 'Organization', 'primary_organization_id'),
			'primaryUnity' => array(self::BELONGS_TO, 'Unity', 'primary_unity_id'),
			'secondaryOrganization' => array(self::BELONGS_TO, 'Organization', 'secondary_organization_id'),
			'secondaryUnity' => array(self::BELONGS_TO, 'Unity', 'secondary_unity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'primary_organization_id' => Yii::t('default', 'Primary Organization'),
			'primary_unity_id' => Yii::t('default', 'Primary Unity'),
			'secondary_organization_id' => Yii::t('default', 'Secondary Organization'),
			'secondary_unity_id' => Yii::t('default', 'Secondary Unity'),
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
		$criteria->compare('primary_organization_id',$this->primary_organization_id);
		$criteria->compare('primary_unity_id',$this->primary_unity_id);
		$criteria->compare('secondary_organization_id',$this->secondary_organization_id);
		$criteria->compare('secondary_unity_id',$this->secondary_unity_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}