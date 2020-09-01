<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $module
 * @property string $author_id
 * @property string $created_time
 * @property string $created_ip
 * @property string $last_modified
 * @property string $tags
 * @property string $out_link
 */
class News extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title, out_link', 'length', 'max'=>100),
			array('content', 'length', 'max'=>5000),
			array('module', 'length', 'max'=>20),
			array('author_id', 'length', 'max'=>10),
			array('created_ip', 'length', 'max'=>15),
			array('tags', 'length', 'max'=>45),
			array('created_time, last_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, module, author_id, created_time, created_ip, last_modified, tags, out_link', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'content' => 'Content',
			'module' => 'Module',
			'author_id' => 'Author',
			'created_time' => 'Created Time',
			'created_ip' => 'Created Ip',
			'last_modified' => 'Last Modified',
			'tags' => 'Tags',
			'out_link' => 'Out Link',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('created_ip',$this->created_ip,true);
		$criteria->compare('last_modified',$this->last_modified,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('out_link',$this->out_link,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
