<?php

/**
 * This is the model class for table "{{books_likes}}".
 *
 * The followings are the available columns in table '{{books_likes}}':
 * @property string $id
 * @property string $user_id
 * @property string $book_id
 * @property string $user_name
 * @property string $book_name
 * @property integer $is_like
 * @property string $add_time
 */
class BooksLikes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books_likes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, book_id', 'required'),
			array('is_like', 'numerical', 'integerOnly'=>true),
			array('user_id, book_id', 'length', 'max'=>10),
			array('user_name, book_name', 'length', 'max'=>45),
			array('add_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, book_id, user_name, book_name, is_like, add_time', 'safe', 'on'=>'search'),
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
			'book_id' => 'Book',
			'user_name' => 'User Name',
			'book_name' => 'Book Name',
			'is_like' => 'Is Like',
			'add_time' => 'Add Time',
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
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('book_name',$this->book_name,true);
		$criteria->compare('is_like',$this->is_like);
		$criteria->compare('add_time',$this->add_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BooksLikes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
