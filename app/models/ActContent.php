<?php

/**
 * This is the model class for table "act_content".
 *
 * The followings are the available columns in table 'act_content':
 * @property integer $id
 * @property integer $content_parent
 * @property integer $discipline_id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property ActContent $contentParent
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
		// @TODO: TESTANDOS
		// @todo testando 23
		// @AWESOME: testeando
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('discipline_id, description', 'required'),
			array('content_parent, discipline_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content_parent, discipline_id, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: ydddou may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'contentParent' => array(self::BELONGS_TO, 'ActContent', 'content_parent'),
			'actContents' => array(self::HAS_MANY, 'ActContent', 'content_parent'),
			'discipline' => array(self::BELONGS_TO, 'ActDiscipline', 'discipline_id'),
			'actGoalContents' => array(self::HAS_MANY, 'ActGoalContent', 'content_id'),
			'actScripts' => array(self::HAS_MANY, 'ActScript', 'father_content'),
			'actScriptContents' => array(self::HAS_MANY, 'ActScriptContent', 'content_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'content_parent' => Yii::t('default', 'Content Parent'),
			'discipline_id' => Yii::t('default', 'Discipline'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('content_parent',$this->content_parent);
		$criteria->compare('discipline_id',$this->discipline_id);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}