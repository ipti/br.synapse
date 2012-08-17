<?php

/**
 * This is the model class for table "editor_screen".
 *
 * The followings are the available columns in table 'editor_screen':
 * @property integer $ID
 * @property integer $cobjectID
 * @property integer $number
 * @property integer $width
 * @property integer $height
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property Cobject $cobject
 * @property EditorScreenPieceset[] $editorScreenPiecesets
 */
class EditorScreen extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EditorScreen the static model class
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
		return 'editor_screen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cobjectID', 'required'),
			array('cobjectID, number, width, height, order', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, cobjectID, number, width, height, order', 'safe', 'on'=>'search'),
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
			'cobject' => array(self::BELONGS_TO, 'Cobject', 'cobjectID'),
			'editorScreenPiecesets' => array(self::HAS_MANY, 'EditorScreenPieceset', 'screenID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => Yii::t('default', 'ID'),
			'cobjectID' => Yii::t('default', 'Cobject'),
			'number' => Yii::t('default', 'Number'),
			'width' => Yii::t('default', 'Width'),
			'height' => Yii::t('default', 'Height'),
			'order' => Yii::t('default', 'Order'),
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
		$criteria->compare('cobjectID',$this->cobjectID);
		$criteria->compare('number',$this->number);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}