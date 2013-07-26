<?php

/**
 * This is the model class for table "act_matrix".
 *
 * The followings are the available columns in table 'act_matrix':
 * @property integer $id
 * @property string $name
 * @property integer $discipline_id
 * @property integer $degree_id
 *
 * The followings are the available model relations:
 * @property ActGoalMatrix[] $actGoalMatrixes
 * @property ActDiscipline $discipline
 * @property ActDegree $degree
 */
class ActMatrix extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActMatrix the static model class
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
		return 'act_matrix';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, discipline_id, degree_id', 'required'),
			array('discipline_id, degree_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, discipline_id, degree_id', 'safe', 'on'=>'search'),
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
			'actGoalMatrixes' => array(self::HAS_MANY, 'ActGoalMatrix', 'matrix_id'),
			'discipline' => array(self::BELONGS_TO, 'ActDiscipline', 'discipline_id'),
			'degree' => array(self::BELONGS_TO, 'ActDegree', 'degree_id'),
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
			'discipline_id' => Yii::t('default', 'Discipline'),
			'degree_id' => Yii::t('default', 'Degree'),
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
		$criteria->compare('discipline_id',$this->discipline_id);
		$criteria->compare('degree_id',$this->degree_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}