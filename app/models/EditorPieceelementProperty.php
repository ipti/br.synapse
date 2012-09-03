<?php

/**
 * This is the model class for table "editor_pieceelement_property".
 *
 * The followings are the available columns in table 'editor_pieceelement_property':
 * @property integer $ID
 * @property integer $propertyID
 * @property string $value
 * @property integer $pieceElementID
 *
 * The followings are the available model relations:
 * @property EditorPieceElement $pieceElement
 * @property CommonProperty $property
 */
class EditorPieceelementProperty extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorPieceelementProperty the static model class
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
		return 'editor_pieceelement_property';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propertyID, pieceElementID', 'required'),
			array('propertyID, pieceElementID', 'numerical', 'integerOnly'=>true),
			array('value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, propertyID, value, pieceElementID', 'safe', 'on'=>'search'),
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
			'pieceElement' => array(self::BELONGS_TO, 'EditorPieceElement', 'pieceElementID'),
			'property' => array(self::BELONGS_TO, 'CommonProperty', 'propertyID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'propertyID' => Yii::t('default', 'Property'),
			'value' => Yii::t('default', 'Value'),
			'pieceElementID' => Yii::t('default', 'Piece Element'),
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
		$criteria->compare('propertyID',$this->propertyID);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('pieceElementID',$this->pieceElementID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}