<?php

/**
 * This is the model class for table "{{clubs_user}}".
 *
 * The followings are the available columns in table '{{clubs_user}}':
 * @property string $id
 * @property string $user_id
 * @property string $club_id
 * @property integer $club_role
 * @property string $join_time
 * @property string $quit_time
 * @property integer $is_quit
 * @property string $comments
 */
class ClubsUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{clubs_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, club_id', 'required'),
			array('club_role, is_quit', 'numerical', 'integerOnly'=>true),
			array('user_id, club_id', 'length', 'max'=>10),
			array('comments', 'length', 'max'=>100),
			array('join_time, quit_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, club_id, club_role, join_time, quit_time, is_quit, comments', 'safe', 'on'=>'search'),
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
			'club_id' => 'Club',
			'club_role' => 'Club Role',
			'join_time' => 'Join Time',
			'quit_time' => 'Quit Time',
			'is_quit' => 'Is Quit',
			'comments' => 'Comments',
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
		$criteria->compare('club_id',$this->club_id,true);
		$criteria->compare('club_role',$this->club_role);
		$criteria->compare('join_time',$this->join_time,true);
		$criteria->compare('quit_time',$this->quit_time,true);
		$criteria->compare('is_quit',$this->is_quit);
		$criteria->compare('comments',$this->comments,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClubsUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
