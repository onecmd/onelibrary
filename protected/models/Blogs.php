<?php

/**
 * This is the model class for table "{{blogs}}".
 *
 * The followings are the available columns in table '{{blogs}}':
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $blog_type
 * @property string $keywords
 * @property string $content
 * @property string $create_time
 * @property string $last_modify_time
 * @property string $total_clicks
 * @property string $say_goods
 */
class Blogs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{blogs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, title', 'required'),
			array('user_id, total_clicks, say_goods', 'length', 'max'=>10),
			array('title', 'length', 'max'=>45),
			array('blog_type', 'length', 'max'=>20),
			array('keywords', 'length', 'max'=>50),
			array('content', 'length', 'max'=>2000),
			array('create_time, last_modify_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, title, blog_type, keywords, content, create_time, last_modify_time, total_clicks, say_goods', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'blog_type' => 'Blog Type',
			'keywords' => 'Keywords',
			'content' => 'Content',
			'create_time' => 'Create Time',
			'last_modify_time' => 'Last Modify Time',
			'total_clicks' => 'Total Clicks',
			'say_goods' => 'Say Goods',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('blog_type',$this->blog_type,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('last_modify_time',$this->last_modify_time,true);
		$criteria->compare('total_clicks',$this->total_clicks,true);
		$criteria->compare('say_goods',$this->say_goods,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Blogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
