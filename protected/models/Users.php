<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property string $id
 * @property string $user_name
 * @property string $nsn_id
 * @property string $email
 * @property string $password
 * @property string $create_time
 * @property string $last_time
 * @property string $create_ip
 * @property string $last_ip
 * @property string $logo
 * @property string $title
 * @property string $seat
 * @property integer $is_scrum_borrow_leader
 * @property string $scrum_name
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nsn_id, email, password', 'required'),
			array('is_scrum_borrow_leader', 'numerical', 'integerOnly'=>true),
			array('user_name, email, password, logo, title, seat', 'length', 'max'=>45),
			array('nsn_id', 'length', 'max'=>10),
			array('create_ip, last_ip', 'length', 'max'=>15),
			array('scrum_name', 'length', 'max'=>100),
			array('create_time, last_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_name, nsn_id, email, password, create_time, last_time, create_ip, last_ip, logo, title, seat, is_scrum_borrow_leader, scrum_name', 'safe', 'on'=>'search'),
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
			'user_name' => 'User Name',
			'nsn_id' => 'Nsn',
			'email' => 'Email',
			'password' => 'Password',
			'create_time' => 'Create Time',
			'last_time' => 'Last Time',
			'create_ip' => 'Create Ip',
			'last_ip' => 'Last Ip',
			'logo' => 'Logo',
			'title' => 'Title',
			'seat' => 'Seat',
			'is_scrum_borrow_leader' => 'Is Scrum Borrow Leader',
			'scrum_name' => 'Scrum Name',
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
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('nsn_id',$this->nsn_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('last_time',$this->last_time,true);
		$criteria->compare('create_ip',$this->create_ip,true);
		$criteria->compare('last_ip',$this->last_ip,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('seat',$this->seat,true);
		$criteria->compare('is_scrum_borrow_leader',$this->is_scrum_borrow_leader);
		$criteria->compare('scrum_name',$this->scrum_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
