<?php

/**
 * This is the model class for table "{{email_log}}".
 *
 * The followings are the available columns in table '{{email_log}}':
 * @property string $id
 * @property string $module
 * @property string $operator_id
 * @property string $email_subject
 * @property string $email_from
 * @property string $email_from_name
 * @property string $email_receiver
 * @property string $email_bcc
 * @property string $email_body
 * @property string $send_time
 * @property string $send_ip
 */
class EmailLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{email_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module, operator_id', 'required'),
			array('module', 'length', 'max'=>20),
			array('operator_id', 'length', 'max'=>10),
			array('email_subject, email_from, email_bcc', 'length', 'max'=>200),
			array('email_from_name', 'length', 'max'=>45),
			array('email_receiver', 'length', 'max'=>500),
			array('email_body', 'length', 'max'=>2000),
			array('send_ip', 'length', 'max'=>15),
			array('send_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module, operator_id, email_subject, email_from, email_from_name, email_receiver, email_bcc, email_body, send_time, send_ip', 'safe', 'on'=>'search'),
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
			'module' => 'Module',
			'operator_id' => 'Operator',
			'email_subject' => 'Email Subject',
			'email_from' => 'Email From',
			'email_from_name' => 'Email From Name',
			'email_receiver' => 'Email Receiver',
			'email_bcc' => 'Email Bcc',
			'email_body' => 'Email Body',
			'send_time' => 'Send Time',
			'send_ip' => 'Send Ip',
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
		$criteria->compare('module',$this->module,true);
		$criteria->compare('operator_id',$this->operator_id,true);
		$criteria->compare('email_subject',$this->email_subject,true);
		$criteria->compare('email_from',$this->email_from,true);
		$criteria->compare('email_from_name',$this->email_from_name,true);
		$criteria->compare('email_receiver',$this->email_receiver,true);
		$criteria->compare('email_bcc',$this->email_bcc,true);
		$criteria->compare('email_body',$this->email_body,true);
		$criteria->compare('send_time',$this->send_time,true);
		$criteria->compare('send_ip',$this->send_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
