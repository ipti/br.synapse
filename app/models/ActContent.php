<?php

/**
 * This is the model class for table "act_content".
 *
 * The followings are the available columns in table 'act_content':
 * @property integer $ID
 * @property integer $contentParent
 * @property integer $disciplineID
 * @property string $description
 *
 * The followings are the available model relations:
 * @property ActContent $contentParent0
 * @property ActContent[] $actContents
 * @property ActDiscipline $discipline
 * @property ActGoalContent[] $actGoalContents
 * @property ActScript[] $actScripts
 * @property ActScriptContent[] $actScriptContents
 */
class ActContent extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActContent the static model class
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
		return 'act_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('disciplineID, description', 'required'),
			array('contentParent, disciplineID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, contentParent, disciplineID, description', 'safe', 'on'=>'search'),
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
			'contentParent0' => array(self::BELONGS_TO, 'ActContent', 'contentParent'),
			'actContents' => array(self::HAS_MANY, 'ActContent', 'contentParent'),
			'discipline' => array(self::BELONGS_TO, 'ActDiscipline', 'disciplineID'),
			'actGoalContents' => array(self::HAS_MANY, 'ActGoalContent', 'contentID'),
			'actScripts' => array(self::HAS_MANY, 'ActScript', 'contentParentID'),
			'actScriptContents' => array(self::HAS_MANY, 'ActScriptContent', 'contentID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'contentParent' => Yii::t('default', 'Content Parent'),
			'disciplineID' => Yii::t('default', 'Discipline'),
			'description' => Yii::t('default', 'Description'),
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
		$criteria->compare('contentParent',$this->contentParent);
		$criteria->compare('disciplineID',$this->disciplineID);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}