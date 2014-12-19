<?php

/**
 * This is the model class for table "lead_tracker".
 *
 * The followings are the available columns in table 'lead_tracker':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $number
 * @property string $query
 * @property string $created_time
 * @property string $updated_time
 * @property integer $current_status
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $source
 * @property string $comments
 * @property integer $assigned_to
 */
class LeadTracker extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LeadTracker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lead_tracker';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('name, email, number, query, created_time, updated_time, current_status, created_by, updated_by, source, comments, assigned_to', 'required'),
			array('name, source', 'required'),
			array('contact_number,current_status,created_time,updated_time,assigned_on, created_by, updated_by, assigned_to', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>128),
			array('email', 'email'),
		//	array('contact_number', 'unique'),
			array('contact_number', 'length', 'max'=>10),
			array('source', 'length', 'max'=>32),
			array('query, comments', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, contact_number, query, created_time, updated_time, current_status, created_by, updated_by, source, comments, assigned_to,assigned_on', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'email' => 'Email',
			'contact_number' => 'Number',
			'query' => 'Query',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'current_status' => 'Current Status',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
			'source' => 'Source',
			'comments' => 'Comments',
			'assigned_to' => 'Assigned To',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact_number',$this->contact_number,true);
		$criteria->compare('query',$this->query,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('current_status',$this->current_status);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('assigned_to',$this->assigned_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}