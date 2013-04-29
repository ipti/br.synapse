<?php

/**
 * This is the model class for table "cobject_cobjectblock".
 *
 * The followings are the available columns in table 'cobject_cobjectblock':
 * @property integer $ID
 * @property integer $cobjectID
 * @property integer $blockID
 *
 * The followings are the available model relations:
 * @property Cobjectblock $block
 * @property Cobject $cobject
 */
class CobjectCobjectblock extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CobjectCobjectblock the static model class
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
		return 'cobject_cobjectblock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cobjectID, blockID', 'required'),
			array('cobjectID, blockID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, cobjectID, blockID', 'safe', 'on'=>'search'),
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
			'block' => array(self::BELONGS_TO, 'Cobjectblock', 'blockID'),
			'cobject' => array(self::BELONGS_TO, 'Cobject', 'cobjectID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'cobjectID' => Yii::t('default', 'Cobject'),
			'blockID' => Yii::t('default', 'Block'),
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
		$criteria->compare('cobjectID',$this->cobjectID);
		$criteria->compare('blockID',$this->blockID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}