<?php

/**
 * This is the model class for table "{{books_buy_request}}".
 *
 * The followings are the available columns in table '{{books_buy_request}}':
 * @property string $id
 * @property string $book_name
 * @property string $request_reason
 * @property string $user_id
 * @property string $user_name
 * @property string $user_email
 * @property integer $status
 * @property string $request_time
 * @property string $buy_time
 * @property string $last_updated
 * @property string $last_ip
 * @property string $comments
 * @property string $vote
 * @property string $vote_user_names
 * @property string $book_url
 * @property string $book_id
 * @property double $price_origin
 * @property double $price_discount
 * @property double $price_buyed
 * @property string $book_type
 * @property string $buy_list_id
 * @property string $buy_list_name
 */
class BooksBuyRequest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books_buy_request}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_name, user_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('price_origin, price_discount, price_buyed', 'numerical'),
			array('book_name, user_name, user_email, vote_user_names, book_type, buy_list_name', 'length', 'max'=>45),
			array('request_reason, comments', 'length', 'max'=>2048),
			array('user_id, vote, book_id, buy_list_id', 'length', 'max'=>10),
			array('last_ip', 'length', 'max'=>15),
			array('book_url', 'length', 'max'=>200),
			array('request_time, buy_time, last_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_name, request_reason, user_id, user_name, user_email, status, request_time, buy_time, last_updated, last_ip, comments, vote, vote_user_names, book_url, book_id, price_origin, price_discount, price_buyed, book_type, buy_list_id, buy_list_name', 'safe', 'on'=>'search'),
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
			'book_name' => 'Book Name',
			'request_reason' => 'Request Reason',
			'user_id' => 'User',
			'user_name' => 'User Name',
			'user_email' => 'User Email',
			'status' => 'Status',
			'request_time' => 'Request Time',
			'buy_time' => 'Buy Time',
			'last_updated' => 'Last Updated',
			'last_ip' => 'Last Ip',
			'comments' => 'Comments',
			'vote' => 'Vote',
			'vote_user_names' => 'Vote User Names',
			'book_url' => 'Book Url',
			'book_id' => 'Book',
			'price_origin' => 'Price Origin',
			'price_discount' => 'Price Discount',
			'price_buyed' => 'Price Buyed',
			'book_type' => 'Book Type',
			'buy_list_id' => 'Buy List',
			'buy_list_name' => 'Buy List Name',
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
		$criteria->compare('book_name',$this->book_name,true);
		$criteria->compare('request_reason',$this->request_reason,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('request_time',$this->request_time,true);
		$criteria->compare('buy_time',$this->buy_time,true);
		$criteria->compare('last_updated',$this->last_updated,true);
		$criteria->compare('last_ip',$this->last_ip,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('vote',$this->vote,true);
		$criteria->compare('vote_user_names',$this->vote_user_names,true);
		$criteria->compare('book_url',$this->book_url,true);
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('price_origin',$this->price_origin);
		$criteria->compare('price_discount',$this->price_discount);
		$criteria->compare('price_buyed',$this->price_buyed);
		$criteria->compare('book_type',$this->book_type,true);
		$criteria->compare('buy_list_id',$this->buy_list_id,true);
		$criteria->compare('buy_list_name',$this->buy_list_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BooksBuyRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
