<?php

/**
 * This is the model class for table "{{books_history}}".
 *
 * The followings are the available columns in table '{{books_history}}':
 * @property string $id
 * @property string $book_id
 * @property string $librarian_borrow_id
 * @property string $user_id
 * @property string $librarian_return_id
 * @property string $borrow_time
 * @property string $return_time
 * @property string $actual_return_time
 * @property string $user_name
 * @property integer $notify_email_times
 * @property string $last_email_time
 * @property integer $is_return
 * @property string $comments
 * @property double $overdue_fine
 * @property double $fine_overdue_per_day
 * @property string $book_name
 * @property string $user_email
 * @property string $fine_notify_times
 * @property string $fine_lastnotify_time
 * @property integer $fine_is_paid
 * @property string $fine_paid_time
 * @property string $pay_password
 * @property integer $fine_paid_method
 * @property string $paid_scores
 */
class BooksHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id', 'required'),
			array('notify_email_times, is_return, fine_is_paid, fine_paid_method', 'numerical', 'integerOnly'=>true),
			array('overdue_fine, fine_overdue_per_day', 'numerical'),
			array('book_id, librarian_borrow_id, user_id, librarian_return_id, fine_notify_times, paid_scores', 'length', 'max'=>10),
			array('user_name, user_email, pay_password', 'length', 'max'=>45),
			array('comments', 'length', 'max'=>400),
			array('book_name', 'length', 'max'=>100),
			array('borrow_time, return_time, actual_return_time, last_email_time, fine_lastnotify_time, fine_paid_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, librarian_borrow_id, user_id, librarian_return_id, borrow_time, return_time, actual_return_time, user_name, notify_email_times, last_email_time, is_return, comments, overdue_fine, fine_overdue_per_day, book_name, user_email, fine_notify_times, fine_lastnotify_time, fine_is_paid, fine_paid_time, pay_password, fine_paid_method, paid_scores', 'safe', 'on'=>'search'),
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
			'librarian_borrow_id' => 'Librarian Borrow',
			'user_id' => 'User',
			'librarian_return_id' => 'Librarian Return',
			'borrow_time' => 'Borrow Time',
			'return_time' => 'Return Time',
			'actual_return_time' => 'Actual Return Time',
			'user_name' => 'User Name',
			'notify_email_times' => 'Notify Email Times',
			'last_email_time' => 'Last Email Time',
			'is_return' => 'Is Return',
			'comments' => 'Comments',
			'overdue_fine' => 'Overdue Fine',
			'fine_overdue_per_day' => 'Fine Overdue Per Day',
			'book_name' => 'Book Name',
			'user_email' => 'User Email',
			'fine_notify_times' => 'Fine Notify Times',
			'fine_lastnotify_time' => 'Fine Lastnotify Time',
			'fine_is_paid' => 'Fine Is Paid',
			'fine_paid_time' => 'Fine Paid Time',
			'pay_password' => 'Pay Password',
			'fine_paid_method' => 'Fine Paid Method',
			'paid_scores' => 'Paid Scores',
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
		$criteria->compare('librarian_borrow_id',$this->librarian_borrow_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('librarian_return_id',$this->librarian_return_id,true);
		$criteria->compare('borrow_time',$this->borrow_time,true);
		$criteria->compare('return_time',$this->return_time,true);
		$criteria->compare('actual_return_time',$this->actual_return_time,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('notify_email_times',$this->notify_email_times);
		$criteria->compare('last_email_time',$this->last_email_time,true);
		$criteria->compare('is_return',$this->is_return);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('overdue_fine',$this->overdue_fine);
		$criteria->compare('fine_overdue_per_day',$this->fine_overdue_per_day);
		$criteria->compare('book_name',$this->book_name,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('fine_notify_times',$this->fine_notify_times,true);
		$criteria->compare('fine_lastnotify_time',$this->fine_lastnotify_time,true);
		$criteria->compare('fine_is_paid',$this->fine_is_paid);
		$criteria->compare('fine_paid_time',$this->fine_paid_time,true);
		$criteria->compare('pay_password',$this->pay_password,true);
		$criteria->compare('fine_paid_method',$this->fine_paid_method);
		$criteria->compare('paid_scores',$this->paid_scores,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BooksHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
