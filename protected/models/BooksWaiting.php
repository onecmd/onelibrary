<?php

/**
 * This is the model class for table "{{books_waiting}}".
 *
 * The followings are the available columns in table '{{books_waiting}}':
 * @property string $id
 * @property string $book_id
 * @property string $book_name
 * @property string $user_id
 * @property string $user_name
 * @property string $join_time
 * @property integer $status
 * @property string $inbooking_time
 * @property string $borrowed_time
 * @property string $due_time
 * @property string $return_time
 * @property string $cancel_time
 * @property string $libration_user_id
 * @property string $book_no
 * @property string $user_email
 */
class BooksWaiting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books_waiting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id, book_name, user_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('book_id, user_id, libration_user_id', 'length', 'max'=>10),
			array('book_name, user_name, user_email', 'length', 'max'=>45),
			array('book_no', 'length', 'max'=>20),
			array('join_time, inbooking_time, borrowed_time, due_time, return_time, cancel_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, book_name, user_id, user_name, join_time, status, inbooking_time, borrowed_time, due_time, return_time, cancel_time, libration_user_id, book_no, user_email', 'safe', 'on'=>'search'),
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
			'join_time' => 'Join Time',
			'status' => 'Status',
			'inbooking_time' => 'Inbooking Time',
			'borrowed_time' => 'Borrowed Time',
			'due_time' => 'Due Time',
			'return_time' => 'Return Time',
			'cancel_time' => 'Cancel Time',
			'libration_user_id' => 'Libration User',
			'book_no' => 'Book No',
			'user_email' => 'User Email',
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
		$criteria->compare('join_time',$this->join_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('inbooking_time',$this->inbooking_time,true);
		$criteria->compare('borrowed_time',$this->borrowed_time,true);
		$criteria->compare('due_time',$this->due_time,true);
		$criteria->compare('return_time',$this->return_time,true);
		$criteria->compare('cancel_time',$this->cancel_time,true);
		$criteria->compare('libration_user_id',$this->libration_user_id,true);
		$criteria->compare('book_no',$this->book_no,true);
		$criteria->compare('user_email',$this->user_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BooksWaiting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
