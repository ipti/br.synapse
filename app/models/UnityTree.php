<?php

/**
 * This is the model class for table "unity_tree".
 *
 * The followings are the available columns in table 'unity_tree':
 * @property integer $ID
 * @property integer $unity
 * @property integer $organizationID
 * @property integer $unityOrganizationID
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
			array('ID, unity, organizationID', 'required'),
			array('ID, unity, organizationID, unityOrganizationID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, unity, organizationID, unityOrganizationID', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'unity' => 'Unity',
			'organizationID' => 'Organization',
			'unityOrganizationID' => 'Unity Organization',
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
		$criteria->compare('unity',$this->unity);
		$criteria->compare('organizationID',$this->organizationID);
		$criteria->compare('unityOrganizationID',$this->unityOrganizationID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}