<?php

/**
 * This is the model class for table "editor_screen".
 *
 * The followings are the available columns in table 'editor_screen':
 * @property integer $id
 * @property integer $cobject_id
 * @property integer $order
 * @property integer $oldID
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
			array('cobject_id', 'required'),
			array('cobject_id, order, oldID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cobject_id, order, oldID', 'safe', 'on'=>'search'),
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
			'cobject' => array(self::BELONGS_TO, 'Cobject', 'cobject_id'),
			'editorScreenPiecesets' => array(self::HAS_MANY, 'EditorScreenPieceset', 'screen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'cobject_id' => Yii::t('default', 'Cobject'),
			'order' => Yii::t('default', 'Order'),
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
		$criteria->compare('cobject_id',$this->cobject_id);
		$criteria->compare('order',$this->order);
		$criteria->compare('oldID',$this->oldID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}