<?php

/**
 * This is the model class for table "{{donate_books}}".
 *
 * The followings are the available columns in table '{{donate_books}}':
 * @property string $id
 * @property string $book_id
 * @property string $book_name
 * @property string $user_id
 * @property string $user_name
 * @property string $user_email
 * @property string $donate_time
 * @property integer $status
 * @property string $libration_id
 * @property string $present
 * @property string $present_status
 * @property string $present_give_time
 * @property string $add_time
 * @property string $add_ip
 */
class DonateBooks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{donate_books}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_name', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('book_id, user_id, libration_id', 'length', 'max'=>10),
			array('book_name, user_name, user_email, present, present_status', 'length', 'max'=>45),
			array('add_ip', 'length', 'max'=>15),
			array('donate_time, present_give_time, add_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, book_name, user_id, user_name, user_email, donate_time, status, libration_id, present, present_status, present_give_time, add_time, add_ip', 'safe', 'on'=>'search'),
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
			'book_id' => 'Book',
			'book_name' => 'Book Name',
			'user_id' => 'User',
			'user_name' => 'User Name',
			'user_email' => 'User Email',
			'donate_time' => 'Donate Time',
			'status' => 'Status',
			'libration_id' => 'Libration',
			'present' => 'Present',
			'present_status' => 'Present Status',
			'present_give_time' => 'Present Give Time',
			'add_time' => 'Add Time',
			'add_ip' => 'Add Ip',
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
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('book_name',$this->book_name,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('donate_time',$this->donate_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('libration_id',$this->libration_id,true);
		$criteria->compare('present',$this->present,true);
		$criteria->compare('present_status',$this->present_status,true);
		$criteria->compare('present_give_time',$this->present_give_time,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('add_ip',$this->add_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DonateBooks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
