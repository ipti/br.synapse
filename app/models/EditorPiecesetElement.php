<?php

/**
 * This is the model class for table "editor_pieceset_element".
 *
 * The followings are the available columns in table 'editor_pieceset_element':
 * @property integer $id
 * @property integer $pieceset_id
 * @property integer $element_id
 * @property integer $position
 * @property integer $oldID
 *
 * The followings are the available model relations:
 * @property EditorPieceset $pieceset
 * @property EditorElement $element
 */
class EditorPiecesetElement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorPiecesetElement the static model class
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
		return 'editor_pieceset_element';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pieceset_id, element_id', 'required'),
			array('pieceset_id, element_id, position, oldID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pieceset_id, element_id, position, oldID', 'safe', 'on'=>'search'),
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
			'pieceset' => array(self::BELONGS_TO, 'EditorPieceset', 'pieceset_id'),
			'element' => array(self::BELONGS_TO, 'EditorElement', 'element_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'pieceset_id' => Yii::t('default', 'Pieceset'),
			'element_id' => Yii::t('default', 'Element'),
			'position' => Yii::t('default', 'Position'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('pieceset_id',$this->pieceset_id);
		$criteria->compare('element_id',$this->element_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}