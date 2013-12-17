<?php

/**
 * This is the model class for table "crmcampanausu".
 *
 * The followings are the available columns in table 'crmcampanausu':
 * @property integer $id_cu
 * @property string $id_cam
 * @property string $id_usuc
 *
 * The followings are the available model relations:
 * @property Crmcampana $idCam
 * @property General $idUsuc
 */
class CampanaUsuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmcampanausu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cam, id_usuc', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cu, id_cam, id_usuc', 'safe', 'on'=>'search'),
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
			'idCam' => array(self::BELONGS_TO, 'Crmcampana', 'id_cam'),
			'idUsuc' => array(self::BELONGS_TO, 'General', 'id_usuc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cu' => 'Id Cu',
			'id_cam' => 'Id Cam',
			'id_usuc' => 'Id Usuc',
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

		$criteria->compare('id_cu',$this->id_cu);
		$criteria->compare('id_cam',$this->id_cam,true);
		$criteria->compare('id_usuc',$this->id_usuc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CampanaUsuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
