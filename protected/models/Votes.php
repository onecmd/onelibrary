<?php

/**
 * This is the model class for table "{{votes}}".
 *
 * The followings are the available columns in table '{{votes}}':
 * @property string $id
 * @property string $module
 * @property string $subject
 * @property string $option_1
 * @property string $option_1_selected
 * @property string $option_2
 * @property string $option_2_selected
 * @property string $option_3
 * @property string $option_3_selected
 * @property string $option_4
 * @property string $option_4_selected
 * @property string $option_5
 * @property string $option_5_selected
 * @property string $option_6
 * @property string $option_6_selected
 * @property string $option_7
 * @property string $option_7_selected
 * @property string $option_8
 * @property string $option_8_selected
 * @property string $author_id
 * @property string $created_time
 * @property string $start_time
 * @property string $due_date
 * @property integer $status
 */
class Votes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{votes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('module', 'length', 'max'=>20),
			array('subject', 'length', 'max'=>500),
			array('option_1, option_2, option_3, option_4, option_5, option_6, option_7, option_8', 'length', 'max'=>200),
			array('option_1_selected, option_2_selected, option_3_selected, option_4_selected, option_5_selected, option_6_selected, option_7_selected, option_8_selected, author_id', 'length', 'max'=>10),
			array('created_time, start_time, due_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module, subject, option_1, option_1_selected, option_2, option_2_selected, option_3, option_3_selected, option_4, option_4_selected, option_5, option_5_selected, option_6, option_6_selected, option_7, option_7_selected, option_8, option_8_selected, author_id, created_time, start_time, due_date, status', 'safe', 'on'=>'search'),
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
			'module' => 'Module',
			'subject' => 'Subject',
			'option_1' => 'Option 1',
			'option_1_selected' => 'Option 1 Selected',
			'option_2' => 'Option 2',
			'option_2_selected' => 'Option 2 Selected',
			'option_3' => 'Option 3',
			'option_3_selected' => 'Option 3 Selected',
			'option_4' => 'Option 4',
			'option_4_selected' => 'Option 4 Selected',
			'option_5' => 'Option 5',
			'option_5_selected' => 'Option 5 Selected',
			'option_6' => 'Option 6',
			'option_6_selected' => 'Option 6 Selected',
			'option_7' => 'Option 7',
			'option_7_selected' => 'Option 7 Selected',
			'option_8' => 'Option 8',
			'option_8_selected' => 'Option 8 Selected',
			'author_id' => 'Author',
			'created_time' => 'Created Time',
			'start_time' => 'Start Time',
			'due_date' => 'Due Date',
			'status' => 'Status',
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
		$criteria->compare('module',$this->module,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('option_1',$this->option_1,true);
		$criteria->compare('option_1_selected',$this->option_1_selected,true);
		$criteria->compare('option_2',$this->option_2,true);
		$criteria->compare('option_2_selected',$this->option_2_selected,true);
		$criteria->compare('option_3',$this->option_3,true);
		$criteria->compare('option_3_selected',$this->option_3_selected,true);
		$criteria->compare('option_4',$this->option_4,true);
		$criteria->compare('option_4_selected',$this->option_4_selected,true);
		$criteria->compare('option_5',$this->option_5,true);
		$criteria->compare('option_5_selected',$this->option_5_selected,true);
		$criteria->compare('option_6',$this->option_6,true);
		$criteria->compare('option_6_selected',$this->option_6_selected,true);
		$criteria->compare('option_7',$this->option_7,true);
		$criteria->compare('option_7_selected',$this->option_7_selected,true);
		$criteria->compare('option_8',$this->option_8,true);
		$criteria->compare('option_8_selected',$this->option_8_selected,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Votes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
