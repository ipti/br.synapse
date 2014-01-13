<?php

/**
 * This is the model class for table "cobject_metadata".
 *
 * The followings are the available columns in table 'cobject_metadata':
 * @property integer $ID
 * @property integer $cobjectID
 * @property integer $typeID
 * @property string $value
 *
 * The followings are the available model relations:
 * @property CommonType $type
 * @property Cobject $cobject
 */
class CobjectData extends CActiveRecord {

    public $cobject_id;
    public $rules;
    public $labels;

    function __construct($cObjectID = null) {
        $types = CommonType::model()->findAllByAttributes(array('context' => 'CobjectData'));
        foreach ($types as $type) {
            eval("\$rule = array('$type->name',$type->validator);");
            $this->labels[$type->name] = $type->label;
            $this->rules[] = $rule;
        }
        $this->cobject_id = $cObjectID;
    }

    public function __get($name) {
        $type = CommonType::model()->findByAttributes(array('name' => $name));
        if (isset($this->cobject_id)) {
            $data = CobjectMetadata::model()->findByAttributes(array('cobject_id' => $this->cobject_id, 'type_id' => $type->id));
            if (isset($data)) {
                return $data->value;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function __set($name, $value) {
        if ($name == 'atrributes') {
            foreach ($value as $key => $val) {
                $type = CommonType::model()->findByAttributes(array('name' => $key));
                $data = CobjectMetadata::model()->findByAttributes(array('type_id' => $type->id, 'cobject_id' => $this->cobject_id));
                if (isset($data)) {
                    $data->value = $val;
                    $data->save();
                } else {
                    $data = new CobjectMetadata();
                    $data->cobject_id = $this->cobject_id;
                    $data->type_id = $type->id;
                    $data->value = $val;
                    $data->save();
                }
            }
        } else {
            $type = CommonType::model()->findByAttributes(array('name' => $name));
            $data = CobjectMetadata::model()->findByAttributes(array('type_id' => $type->id, 'cobject_id' => $this->cobject_id));
            if (isset($data)) {
                $data->value = $value;
                $data->save();
            } else {
                $data = new CobjectMetadata();
                $data->cobject_id = $this->cobject_id;
                $data->type_id = $type->id;
                $data->value = $value;
                $data->save();
            }
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CobjectMetadata the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cobject_metadata';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return $this->rules;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'type' => array(self::BELONGS_TO, 'CommonType', 'type_id'),
            'cobject' => array(self::BELONGS_TO, 'Cobject', 'cobject_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return $this->labels;
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
        $criteria->compare('cobject_id', $this->cobject_id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}