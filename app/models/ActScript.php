<?php

/**
 * This is the model class for table "act_script".
 *
 * The followings are the available columns in table 'act_script':
 * @property integer $ID
 * @property integer $disciplineID
 * @property integer $performanceIndice
 * @property integer $contentParentID
 *
 * The followings are the available model relations:
 * @property ActDiscipline $discipline
 * @property ActContent $contentParent
 * @property ActScriptContent[] $actScriptContents
 */
class ActScript extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActScript the static model class
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
		return 'act_script';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('disciplineID, contentParentID,performanceIndice', 'required'),
			array('disciplineID, performanceIndice, contentParentID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, disciplineID, performanceIndice, contentParentID', 'safe', 'on'=>'search'),
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
			'discipline' => array(self::BELONGS_TO, 'ActDiscipline', 'disciplineID'),
			'contentParent' => array(self::BELONGS_TO, 'ActContent', 'contentParentID'),
			'actScriptContents' => array(self::HAS_MANY, 'ActScriptContent', 'scriptID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'disciplineID' => Yii::t('default', 'Discipline'),
			'performanceIndice' => Yii::t('default', 'Performance Indice'),
			'contentParentID' => Yii::t('default', 'Content Parent'),
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
		$criteria->compare('disciplineID',$this->disciplineID);
		$criteria->compare('performanceIndice',$this->performanceIndice);
		$criteria->compare('contentParentID',$this->contentParentID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}