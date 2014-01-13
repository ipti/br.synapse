<?php

/**
 * This is the model class for table "actor_interaction".
 *
 * The followings are the available columns in table 'actor_interaction':
 * @property integer $id
 * @property integer $actor_id
 * @property integer $type_id
 * @property integer $start_time
 * @property integer $final_time
 * @property integer $where_id
 * @property string $where_table
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Actor $actor
 */
class ActorInteraction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActorInteraction the static model class
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
		return 'actor_interaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('actor_id, type_id, start_time, final_time, where_id, where_table', 'required'),
			array('actor_id, type_id, start_time, final_time, where_id', 'numerical', 'integerOnly'=>true),
			array('where_table', 'length', 'max'=>60),
			array('data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, actor_id, type_id, start_time, final_time, where_id, where_table, data', 'safe', 'on'=>'search'),
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
			'actor' => array(self::BELONGS_TO, 'Actor', 'actor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'actor_id' => Yii::t('default', 'Actor'),
			'type_id' => Yii::t('default', 'Type'),
			'start_time' => Yii::t('default', 'Start Time'),
			'final_time' => Yii::t('default', 'Final Time'),
			'where_id' => Yii::t('default', 'Where'),
			'where_table' => Yii::t('default', 'Where Table'),
			'data' => Yii::t('default', 'Data'),
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
		$criteria->compare('actor_id',$this->actor_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('start_time',$this->start_time);
		$criteria->compare('final_time',$this->final_time);
		$criteria->compare('where_id',$this->where_id);
		$criteria->compare('where_table',$this->where_table,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}