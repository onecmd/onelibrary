<?php

/**
 * This is the model class for table "{{books_buy_list}}".
 *
 * The followings are the available columns in table '{{books_buy_list}}':
 * @property string $id
 * @property string $list_name
 * @property string $creator_user_id
 * @property string $creator_name
 * @property string $create_time
 * @property double $budget
 * @property double $paid_account
 * @property string $request_ids
 * @property integer $status
 * @property string $start_time
 * @property string $finished_time
 * @property string $buyer_names
 * @property string $approves_names
 * @property string $addtion_info
 */
class BooksBuyList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books_buy_list}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('list_name, creator_user_id, creator_name, create_time', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('budget, paid_account', 'numerical'),
			array('list_name, creator_name', 'length', 'max'=>45),
			array('creator_user_id', 'length', 'max'=>10),
			array('request_ids, addtion_info', 'length', 'max'=>2048),
			array('buyer_names, approves_names', 'length', 'max'=>512),
			array('start_time, finished_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, list_name, creator_user_id, creator_name, create_time, budget, paid_account, request_ids, status, start_time, finished_time, buyer_names, approves_names, addtion_info', 'safe', 'on'=>'search'),
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
			'list_name' => 'List Name',
			'creator_user_id' => 'Creator User',
			'creator_name' => 'Creator Name',
			'create_time' => 'Create Time',
			'budget' => 'Budget',
			'paid_account' => 'Paid Account',
			'request_ids' => 'Request Ids',
			'status' => 'Status',
			'start_time' => 'Start Time',
			'finished_time' => 'Finished Time',
			'buyer_names' => 'Buyer Names',
			'approves_names' => 'Approves Names',
			'addtion_info' => 'Addtion Info',
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
		$criteria->compare('list_name',$this->list_name,true);
		$criteria->compare('creator_user_id',$this->creator_user_id,true);
		$criteria->compare('creator_name',$this->creator_name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('paid_account',$this->paid_account);
		$criteria->compare('request_ids',$this->request_ids,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('finished_time',$this->finished_time,true);
		$criteria->compare('buyer_names',$this->buyer_names,true);
		$criteria->compare('approves_names',$this->approves_names,true);
		$criteria->compare('addtion_info',$this->addtion_info,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BooksBuyList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
