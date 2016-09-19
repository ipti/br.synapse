<?php

/**
 * This is the model class for table "act_goal".
 *
 * The followings are the available columns in table 'act_goal':
 * @property integer $id
 * @property string $name
 * @property integer $degree_id
 * @property integer $discipline_id
 *
 * The followings are the available model relations:
 * @property ActDegree $degree
 * @property ActDiscipline $discipline
 * @property ActGoalContent[] $actGoalContents
 * @property ActGoalMatrix[] $actGoalMatrixes
 * @property ActGoalModality[] $actGoalModalities
 * @property ActGoalSkill[] $actGoalSkills
 */
class ActGoal extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ActGoal the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'act_goal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, degree_id, discipline_id', 'required'),
            array('degree_id, discipline_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, degree_id, discipline_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'degree' => array(self::BELONGS_TO, 'ActDegree', 'degree_id'),
            'discipline' => array(self::BELONGS_TO, 'ActDiscipline', 'discipline_id'),
            'actGoalContents' => array(self::HAS_MANY, 'ActGoalContent', 'goal_id'),
            'actGoalMatrixes' => array(self::HAS_MANY, 'ActGoalMatrix', 'goal_id'),
            'actGoalModalities' => array(self::HAS_MANY, 'ActGoalModality', 'goal_id'),
            'actGoalSkills' => array(self::HAS_MANY, 'ActGoalSkill', 'goal_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('default', 'ID'),
            'name' => Yii::t('default', 'Name'),
            'degree_id' => Yii::t('default', 'Degree'),
            'discipline_id' => Yii::t('default', 'Discipline'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->alias='goal';
        $criteria->together = true;
        $criteria->with = array('degree', 'discipline');
        $criteria->compare('goal.name', $this->name, true);
        $criteria->addSearchCondition('degree.name', $this->degree_id);
        $criteria->addSearchCondition('discipline.name', $this->discipline_id);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
