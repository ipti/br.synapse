<?php

/**
 * This is the model class for table "act_discipline".
 *
 * The followings are the available columns in table 'act_discipline':
 * @property integer $ID
 * @property string $name
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property ActContent[] $actContents
 * @property ActGoal[] $actGoals
 * @property ActMatrix[] $actMatrixes
 * @property ActScript[] $actScripts
 * @property Cobjectblock[] $cobjectblocks
 */
class ActDiscipline extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActDiscipline the static model class
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
		return 'act_discipline';
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
			array('oldID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, name, oldID', 'safe', 'on'=>'search'),
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
			'actContents' => array(self::HAS_MANY, 'ActContent', 'disciplineID'),
			'actGoals' => array(self::HAS_MANY, 'ActGoal', 'disciplineID'),
			'actMatrixes' => array(self::HAS_MANY, 'ActMatrix', 'disciplineID'),
			'actScripts' => array(self::HAS_MANY, 'ActScript', 'disciplineID'),
			'cobjectblocks' => array(self::HAS_MANY, 'Cobjectblock', 'disciplineID'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}