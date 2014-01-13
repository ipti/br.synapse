<?php

/**
 * This is the model class for table "cobject_theme".
 *
 * The followings are the available columns in table 'cobject_theme':
 * @property integer $id
 * @property string $name
 * @property integer $oldID
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property Cobject[] $cobjects
 * @property CobjectTheme $parent
 * @property CobjectTheme[] $cobjectThemes
 */
class CobjectTheme extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CobjectTheme the static model class
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
		return 'cobject_theme';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('oldID, parent_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, oldID, parent_id', 'safe', 'on'=>'search'),
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
			'cobjects' => array(self::HAS_MANY, 'Cobject', 'theme_id'),
			'parent' => array(self::BELONGS_TO, 'CobjectTheme', 'parent_id'),
			'cobjectThemes' => array(self::HAS_MANY, 'CobjectTheme', 'parent_id'),
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
			'oldID' => Yii::t('default', 'Old'),
			'parent_id' => Yii::t('default', 'Parent'),
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
		$criteria->compare('oldID',$this->oldID);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}