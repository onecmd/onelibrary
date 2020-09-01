<?php

/**
 * This is the model class for table "{{clubs}}".
 *
 * The followings are the available columns in table '{{clubs}}':
 * @property string $id
 * @property string $club_name
 * @property string $creater_id
 * @property string $about
 * @property integer $head_limit
 * @property string $join_about
 * @property string $create_time
 * @property integer $is_close
 */
class Clubs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{clubs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('club_name, creater_id', 'required'),
			array('head_limit, is_close', 'numerical', 'integerOnly'=>true),
			array('club_name', 'length', 'max'=>45),
			array('creater_id', 'length', 'max'=>10),
			array('about, join_about', 'length', 'max'=>1000),
			array('create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, club_name, creater_id, about, head_limit, join_about, create_time, is_close', 'safe', 'on'=>'search'),
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
			'club_name' => 'Club Name',
			'creater_id' => 'Creater',
			'about' => 'About',
			'head_limit' => 'Head Limit',
			'join_about' => 'Join About',
			'create_time' => 'Create Time',
			'is_close' => 'Is Close',
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
		$criteria->compare('club_name',$this->club_name,true);
		$criteria->compare('creater_id',$this->creater_id,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('head_limit',$this->head_limit);
		$criteria->compare('join_about',$this->join_about,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('is_close',$this->is_close);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clubs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
