<?php

/**
 * This is the model class for table "school_department".
 *
 * The followings are the available columns in table 'school_department':
 * @property integer $id
 * @property string $nome
 * @property integer $location_fk
 *
 * The followings are the available model relations:
 * @property School[] $schools
 * @property Location $locationFk
 */
class SchoolDepartment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SchoolDepartment the static model class
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
		return 'school_department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, location_fk', 'required'),
			array('location_fk', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nome, location_fk', 'safe', 'on'=>'search'),
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
			'schools' => array(self::HAS_MANY, 'School', 'school_department_fk'),
			'locationFk' => array(self::BELONGS_TO, 'Location', 'location_fk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'nome' => Yii::t('default', 'Nome'),
			'location_fk' => Yii::t('default', 'Location Fk'),
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('location_fk',$this->location_fk);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}