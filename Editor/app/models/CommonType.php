<?php

/**
 * This is the model class for table "common_type".
 *
 * The followings are the available columns in table 'common_type':
 * @property integer $id
 * @property string $context
 * @property string $name
 * @property integer $type_parent
 * @property string $validator
 * @property string $label
 * @property string $html_source
 * @property string $html_type
 * @property string $code
 *
 * The followings are the available model relations:
 * @property Cobject[] $cobjects
 * @property CobjectMetadata[] $cobjectMetadatas
 * @property CobjectTemplate[] $cobjectTemplates
 * @property CobjectTemplate[] $cobjectTemplates1
 * @property CommonType $typeParent
 * @property CommonType[] $commonTypes
 * @property EditorElement[] $editorElements
 * @property EditorElementAlias[] $editorElementAliases
 * @property EditorElementAlias[] $editorElementAliases1
 * @property EditorEvents[] $editorEvents
 * @property Library[] $libraries
 */
class CommonType extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommonType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'common_type';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('context, name', 'required'),
            array('type_parent', 'numerical', 'integerOnly' => true),
            array('context', 'length', 'max' => 30),
            array('name, label, html_type, code', 'length', 'max' => 45),
            array('validator, html_source', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, context, name, type_parent, validator, label, html_source, html_type, code', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cobjects' => array(self::HAS_MANY, 'Cobject', 'type_id'),
            'cobjectMetadatas' => array(self::HAS_MANY, 'CobjectMetadata', 'type_id'),
            'cobjectTemplates' => array(self::HAS_MANY, 'CobjectTemplate', 'format_type_id'),
            'cobjectTemplates1' => array(self::HAS_MANY, 'CobjectTemplate', 'interative_type_id'),
            'typeParent' => array(self::BELONGS_TO, 'CommonType', 'type_parent'),
            'commonTypes' => array(self::HAS_MANY, 'CommonType', 'type_parent'),
            'editorElements' => array(self::HAS_MANY, 'EditorElement', 'type_id'),
            'editorElementAliases' => array(self::HAS_MANY, 'EditorElementAlias', 'primary_type_id'),
            'editorElementAliases1' => array(self::HAS_MANY, 'EditorElementAlias', 'secondary_type_id'),
            'editorEvents' => array(self::HAS_MANY, 'EditorEvents', 'type_id'),
            'libraries' => array(self::HAS_MANY, 'Library', 'type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('default', 'ID'),
            'context' => Yii::t('default', 'Context'),
            'name' => Yii::t('default', 'Name'),
            'type_parent' => Yii::t('default', 'Type Parent'),
            'validator' => Yii::t('default', 'Validator'),
            'label' => Yii::t('default', 'Label'),
            'html_source' => Yii::t('default', 'Html Source'),
            'html_type' => Yii::t('default', 'Html Type'),
            'code' => Yii::t('default', 'Code'),
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
        $criteria->compare('context', $this->context, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type_parent', $this->type_parent);
        $criteria->compare('validator', $this->validator, true);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('html_source', $this->html_source, true);
        $criteria->compare('html_type', $this->html_type, true);
        $criteria->compare('code', $this->code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    //Static Functions
    public static function getTypeIDbyName_Context($context, $name) {
        $type = CommonType::model()->findByAttributes(array('context' => $context, 'name' => $name));
        return $type->id;
    }

    public static function getTypeNameByID($typeID) {
        $type = CommonType::model()->findByPk($typeID);
        $typeName = $type->name;

        return $typeName;
    }

}
