<?php

/**
 * This is the model class for table "{{users_follows}}".
 *
 * The followings are the available columns in table '{{users_follows}}':
 * @property string $id
 * @property string $user_id
 * @property string $follow_id
 * @property string $follow_name
 * @property string $follow_time
 * @property string $user_name
 */
class UsersFollows extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users_follows}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, follow_id', 'required'),
			array('user_id, follow_id', 'length', 'max'=>10),
			array('follow_name, user_name', 'length', 'max'=>45),
			array('follow_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, follow_id, follow_name, follow_time, user_name', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'follow_id' => 'Follow',
			'follow_name' => 'Follow Name',
			'follow_time' => 'Follow Time',
			'user_name' => 'User Name',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('follow_id',$this->follow_id,true);
		$criteria->compare('follow_name',$this->follow_name,true);
		$criteria->compare('follow_time',$this->follow_time,true);
		$criteria->compare('user_name',$this->user_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersFollows the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
