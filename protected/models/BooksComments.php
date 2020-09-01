<?php

/**
 * This is the model class for table "{{books_comments}}".
 *
 * The followings are the available columns in table '{{books_comments}}':
 * @property string $id
 * @property string $book_id
 * @property string $user_id
 * @property integer $score
 * @property string $comments
 * @property string $add_time
 * @property string $add_ip
 * @property string $user_name
 */
class BooksComments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books_comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id, user_id', 'required'),
			array('score', 'numerical', 'integerOnly'=>true),
			array('book_id, user_id', 'length', 'max'=>10),
			array('comments', 'length', 'max'=>200),
			array('add_ip', 'length', 'max'=>15),
			array('user_name', 'length', 'max'=>45),
			array('add_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, user_id, score, comments, add_time, add_ip, user_name', 'safe', 'on'=>'search'),
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
			'book_id' => 'Book',
			'user_id' => 'User',
			'score' => 'Score',
			'comments' => 'Comments',
			'add_time' => 'Add Time',
			'add_ip' => 'Add Ip',
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
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('add_ip',$this->add_ip,true);
		$criteria->compare('user_name',$this->user_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BooksComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
