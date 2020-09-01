<?php

/**
 * This is the model class for table "{{books_type}}".
 *
 * The followings are the available columns in table '{{books_type}}':
 * @property string $id
 * @property string $type_name
 * @property integer $borrow_days_limit
 * @property integer $grade
 * @property double $overdue_fine_per_day
 * @property string $type_code
 * @property string $type_parent
 */
class BooksType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_name', 'required'),
			array('borrow_days_limit, grade', 'numerical', 'integerOnly'=>true),
			array('overdue_fine_per_day', 'numerical'),
			array('type_name', 'length', 'max'=>45),
			array('type_code, type_parent', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type_name, borrow_days_limit, grade, overdue_fine_per_day, type_code, type_parent', 'safe', 'on'=>'search'),
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
			'type_name' => 'Type Name',
			'borrow_days_limit' => 'Borrow Days Limit',
			'grade' => 'Grade',
			'overdue_fine_per_day' => 'Overdue Fine Per Day',
			'type_code' => 'Type Code',
			'type_parent' => 'Type Parent',
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
		$criteria->compare('type_name',$this->type_name,true);
		$criteria->compare('borrow_days_limit',$this->borrow_days_limit);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('overdue_fine_per_day',$this->overdue_fine_per_day);
		$criteria->compare('type_code',$this->type_code,true);
		$criteria->compare('type_parent',$this->type_parent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BooksType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
