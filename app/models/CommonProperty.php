<?php

/**
 * This is the model class for table "common_property".
 *
 * The followings are the available columns in table 'common_property':
 * @property integer $id
 * @property string $name
 * @property string $context
 *
 * The followings are the available model relations:
 * @property EditorElementProperty[] $editorElementProperties
 * @property EditorPieceelementProperty[] $editorPieceelementProperties
 * @property LibraryProperty[] $libraryProperties
 */
class CommonProperty extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommonProperty the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'common_property';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, context', 'required'),
            array('name', 'length', 'max' => 100),
            array('context', 'length', 'max' => 30),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, context', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'editorElementProperties' => array(self::HAS_MANY, 'EditorElementProperty', 'property_id'),
            'editorPieceelementProperties' => array(self::HAS_MANY, 'EditorPieceelementProperty', 'property_id'),
            'libraryProperties' => array(self::HAS_MANY, 'LibraryProperty', 'property_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('default', 'ID'),
            'name' => Yii::t('default', 'Name'),
            'context' => Yii::t('default', 'Context'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('context', $this->context, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    //Static Functions
    public static function getPropertyIDByName($propertyName, $propertyContext) {
        $property = CommonProperty::model()->findByAttributes(array('name' => strtolower($propertyName), 'context' => strtolower($propertyContext)));
        $propertyID = $property->id;

        return $propertyID;
    }

}
