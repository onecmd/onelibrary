<?php

/**
 * This is the model class for table "{{books}}".
 *
 * The followings are the available columns in table '{{books}}':
 * @property string $id
 * @property string $book_id
 * @property string $book_name
 * @property string $author
 * @property string $owner_team
 * @property string $book_admin
 * @property string $isbn
 * @property string $tags
 * @property integer $status
 * @property string $holder_nsn_id
 * @property string $return_time
 * @property integer $total_pages
 * @property string $publish_time
 * @property string $add_time
 * @property string $remove_time
 * @property string $adder_nsn_id
 * @property string $remover_nsn_id
 * @property string $book_summary
 * @property string $book_logo
 * @property string $more_url
 * @property string $suggest_reason
 * @property string $book_type
 * @property string $language
 * @property string $publisher
 * @property string $holder_name
 * @property string $borrowed_time
 * @property string $due_date
 * @property double $fine_overdue_per_day
 * @property string $liked_num
 * @property string $comments
 * @property integer $notify_email_times
 * @property string $last_email_time
 * @property string $category_1
 * @property string $category_2
 * @property string $total_borrowed
 * @property string $total_clicks
 * @property string $total_saygood
 * @property string $donate_nsn_id
 * @property string $donate_time
 * @property string $donate_name
 * @property string $location_library
 * @property string $holder_email
 * @property integer $location_building
 */
class Books extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_name', 'required'),
			array('status, total_pages, notify_email_times, location_building', 'numerical', 'integerOnly'=>true),
			array('fine_overdue_per_day', 'numerical'),
			array('book_id, publish_time, language', 'length', 'max'=>20),
			array('book_name, more_url', 'length', 'max'=>100),
			array('author, owner_team, book_admin, isbn, tags, book_logo, holder_name, donate_time, donate_name, location_library, holder_email', 'length', 'max'=>45),
			array('holder_nsn_id, adder_nsn_id, remover_nsn_id, book_type, liked_num, total_borrowed, total_clicks, total_saygood, donate_nsn_id', 'length', 'max'=>10),
			array('book_summary, comments', 'length', 'max'=>2000),
			array('suggest_reason', 'length', 'max'=>200),
			array('publisher', 'length', 'max'=>80),
			array('category_1', 'length', 'max'=>2),
			array('category_2', 'length', 'max'=>5),
			array('return_time, add_time, remove_time, borrowed_time, due_date, last_email_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, book_name, author, owner_team, book_admin, isbn, tags, status, holder_nsn_id, return_time, total_pages, publish_time, add_time, remove_time, adder_nsn_id, remover_nsn_id, book_summary, book_logo, more_url, suggest_reason, book_type, language, publisher, holder_name, borrowed_time, due_date, fine_overdue_per_day, liked_num, comments, notify_email_times, last_email_time, category_1, category_2, total_borrowed, total_clicks, total_saygood, donate_nsn_id, donate_time, donate_name, location_library, holder_email, location_building', 'safe', 'on'=>'search'),
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
			'book_name' => 'Book Name',
			'author' => 'Author',
			'owner_team' => 'Owner Team',
			'book_admin' => 'Book Admin',
			'isbn' => 'Isbn',
			'tags' => 'Tags',
			'status' => 'Status',
			'holder_nsn_id' => 'Holder Nsn',
			'return_time' => 'Return Time',
			'total_pages' => 'Total Pages',
			'publish_time' => 'Publish Time',
			'add_time' => 'Add Time',
			'remove_time' => 'Remove Time',
			'adder_nsn_id' => 'Adder Nsn',
			'remover_nsn_id' => 'Remover Nsn',
			'book_summary' => 'Book Summary',
			'book_logo' => 'Book Logo',
			'more_url' => 'More Url',
			'suggest_reason' => 'Suggest Reason',
			'book_type' => 'Book Type',
			'language' => 'Language',
			'publisher' => 'Publisher',
			'holder_name' => 'Holder Name',
			'borrowed_time' => 'Borrowed Time',
			'due_date' => 'Due Date',
			'fine_overdue_per_day' => 'Fine Overdue Per Day',
			'liked_num' => 'Liked Num',
			'comments' => 'Comments',
			'notify_email_times' => 'Notify Email Times',
			'last_email_time' => 'Last Email Time',
			'category_1' => 'Category 1',
			'category_2' => 'Category 2',
			'total_borrowed' => 'Total Borrowed',
			'total_clicks' => 'Total Clicks',
			'total_saygood' => 'Total Saygood',
			'donate_nsn_id' => 'Donate Nsn',
			'donate_time' => 'Donate Time',
			'donate_name' => 'Donate Name',
			'location_library' => 'Location Library',
			'holder_email' => 'Holder Email',
			'location_building' => 'Location Building',
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
		$criteria->compare('book_name',$this->book_name,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('owner_team',$this->owner_team,true);
		$criteria->compare('book_admin',$this->book_admin,true);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('holder_nsn_id',$this->holder_nsn_id,true);
		$criteria->compare('return_time',$this->return_time,true);
		$criteria->compare('total_pages',$this->total_pages);
		$criteria->compare('publish_time',$this->publish_time,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('remove_time',$this->remove_time,true);
		$criteria->compare('adder_nsn_id',$this->adder_nsn_id,true);
		$criteria->compare('remover_nsn_id',$this->remover_nsn_id,true);
		$criteria->compare('book_summary',$this->book_summary,true);
		$criteria->compare('book_logo',$this->book_logo,true);
		$criteria->compare('more_url',$this->more_url,true);
		$criteria->compare('suggest_reason',$this->suggest_reason,true);
		$criteria->compare('book_type',$this->book_type,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('publisher',$this->publisher,true);
		$criteria->compare('holder_name',$this->holder_name,true);
		$criteria->compare('borrowed_time',$this->borrowed_time,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('fine_overdue_per_day',$this->fine_overdue_per_day);
		$criteria->compare('liked_num',$this->liked_num,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('notify_email_times',$this->notify_email_times);
		$criteria->compare('last_email_time',$this->last_email_time,true);
		$criteria->compare('category_1',$this->category_1,true);
		$criteria->compare('category_2',$this->category_2,true);
		$criteria->compare('total_borrowed',$this->total_borrowed,true);
		$criteria->compare('total_clicks',$this->total_clicks,true);
		$criteria->compare('total_saygood',$this->total_saygood,true);
		$criteria->compare('donate_nsn_id',$this->donate_nsn_id,true);
		$criteria->compare('donate_time',$this->donate_time,true);
		$criteria->compare('donate_name',$this->donate_name,true);
		$criteria->compare('location_library',$this->location_library,true);
		$criteria->compare('holder_email',$this->holder_email,true);
		$criteria->compare('location_building',$this->location_building);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Books the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
