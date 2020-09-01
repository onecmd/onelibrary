<?php

/**
 * This is the model class for table "{{library_assets}}".
 *
 * The followings are the available columns in table '{{library_assets}}':
 * @property string $id
 * @property string $asset_name
 * @property string $asset_type
 * @property integer $amount
 * @property double $total_value
 * @property double $unit_value
 * @property string $book_id
 * @property string $add_time
 * @property integer $is_available
 * @property string $remove_time
 * @property string $hander_id
 * @property string $comments
 */
class LibraryAssets extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{library_assets}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asset_name, asset_type', 'required'),
			array('amount, is_available', 'numerical', 'integerOnly'=>true),
			array('total_value, unit_value', 'numerical'),
			array('asset_name', 'length', 'max'=>100),
			array('asset_type', 'length', 'max'=>45),
			array('book_id, hander_id', 'length', 'max'=>10),
			array('add_time, remove_time', 'length', 'max'=>20),
			array('comments', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, asset_name, asset_type, amount, total_value, unit_value, book_id, add_time, is_available, remove_time, hander_id, comments', 'safe', 'on'=>'search'),
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
			'asset_name' => 'Asset Name',
			'asset_type' => 'Asset Type',
			'amount' => 'Amount',
			'total_value' => 'Total Value',
			'unit_value' => 'Unit Value',
			'book_id' => 'Book',
			'add_time' => 'Add Time',
			'is_available' => 'Is Available',
			'remove_time' => 'Remove Time',
			'hander_id' => 'Hander',
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
		$criteria->compare('asset_name',$this->asset_name,true);
		$criteria->compare('asset_type',$this->asset_type,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('total_value',$this->total_value);
		$criteria->compare('unit_value',$this->unit_value);
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('is_available',$this->is_available);
		$criteria->compare('remove_time',$this->remove_time,true);
		$criteria->compare('hander_id',$this->hander_id,true);
		$criteria->compare('comments',$this->comments,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibraryAssets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
