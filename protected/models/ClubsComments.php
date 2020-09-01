<?php

/**
 * This is the model class for table "{{clubs_comments}}".
 *
 * The followings are the available columns in table '{{clubs_comments}}':
 * @property string $id
 * @property string $club_id
 * @property string $user_id
 * @property string $comments
 * @property string $parent_id
 * @property string $user_name
 * @property string $add_time
 * @property string $add_ip
 */
class ClubsComments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{clubs_comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('club_id, user_id', 'required'),
			array('club_id, user_id, parent_id', 'length', 'max'=>10),
			array('comments', 'length', 'max'=>400),
			array('user_name', 'length', 'max'=>45),
			array('add_ip', 'length', 'max'=>15),
			array('add_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, club_id, user_id, comments, parent_id, user_name, add_time, add_ip', 'safe', 'on'=>'search'),
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
			'club_id' => 'Club',
			'user_id' => 'User',
			'comments' => 'Comments',
			'parent_id' => 'Parent',
			'user_name' => 'User Name',
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
		$criteria->compare('club_id',$this->club_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('user_name',$this->user_name,true);
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
	 * @return ClubsComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
