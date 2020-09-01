<?php

/**
 * This is the model class for table "{{library_finance}}".
 *
 * The followings are the available columns in table '{{library_finance}}':
 * @property string $id
 * @property string $title
 * @property string $detail
 * @property integer $is_income
 * @property double $value
 * @property string $record_time
 * @property string $pay_time
 * @property string $record_id
 */
class LibraryFinance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{library_finance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, record_id', 'required'),
			array('is_income', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('title', 'length', 'max'=>100),
			array('detail', 'length', 'max'=>1000),
			array('record_id', 'length', 'max'=>10),
			array('record_time, pay_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, detail, is_income, value, record_time, pay_time, record_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'detail' => 'Detail',
			'is_income' => 'Is Income',
			'value' => 'Value',
			'record_time' => 'Record Time',
			'pay_time' => 'Pay Time',
			'record_id' => 'Record',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('is_income',$this->is_income);
		$criteria->compare('value',$this->value);
		$criteria->compare('record_time',$this->record_time,true);
		$criteria->compare('pay_time',$this->pay_time,true);
		$criteria->compare('record_id',$this->record_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibraryFinance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
