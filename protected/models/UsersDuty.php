<?php

/**
 * This is the model class for table "{{users_duty}}".
 *
 * The followings are the available columns in table '{{users_duty}}':
 * @property string $id
 * @property string $nsn_id
 * @property string $user_name
 * @property string $user_email
 * @property double $duty_point
 * @property string $comment
 * @property string $start_time
 * @property string $end_time
 * @property string $create_time
 * @property integer $got_gift
 * @property string $author_nsn_id
 * @property string $author_user_name
 * @property string $author_email
 */
class UsersDuty extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users_duty}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nsn_id', 'required'),
			array('got_gift', 'numerical', 'integerOnly'=>true),
			array('duty_point', 'numerical'),
			array('nsn_id, author_nsn_id', 'length', 'max'=>20),
			array('user_name', 'length', 'max'=>45),
			array('user_email, start_time, end_time, author_user_name, author_email', 'length', 'max'=>100),
			array('comment', 'length', 'max'=>500),
			array('create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nsn_id, user_name, user_email, duty_point, comment, start_time, end_time, create_time, got_gift, author_nsn_id, author_user_name, author_email', 'safe', 'on'=>'search'),
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
			'nsn_id' => 'Nsn',
			'user_name' => 'User Name',
			'user_email' => 'User Email',
			'duty_point' => 'Duty Point',
			'comment' => 'Comment',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'create_time' => 'Create Time',
			'got_gift' => 'Got Gift',
			'author_nsn_id' => 'Author Nsn',
			'author_user_name' => 'Author User Name',
			'author_email' => 'Author Email',
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
		$criteria->compare('nsn_id',$this->nsn_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('duty_point',$this->duty_point);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('got_gift',$this->got_gift);
		$criteria->compare('author_nsn_id',$this->author_nsn_id,true);
		$criteria->compare('author_user_name',$this->author_user_name,true);
		$criteria->compare('author_email',$this->author_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersDuty the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
