<?php

/**
 * This is the model class for table "{{users_score_history}}".
 *
 * The followings are the available columns in table '{{users_score_history}}':
 * @property string $id
 * @property string $user_id
 * @property integer $scores
 * @property string $add_time
 * @property string $action
 * @property integer $is_deleted
 * @property string $supplier
 * @property string $user_name
 * @property string $user_email
 */
class UsersScoreHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users_score_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('scores, is_deleted', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('action, user_email', 'length', 'max'=>100),
			array('supplier, user_name', 'length', 'max'=>45),
			array('add_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, scores, add_time, action, is_deleted, supplier, user_name, user_email', 'safe', 'on'=>'search'),
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
			'scores' => 'Scores',
			'add_time' => 'Add Time',
			'action' => 'Action',
			'is_deleted' => 'Is Deleted',
			'supplier' => 'Supplier',
			'user_name' => 'User Name',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('scores',$this->scores);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('supplier',$this->supplier,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_email',$this->user_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersScoreHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
