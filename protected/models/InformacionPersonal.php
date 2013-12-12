<?php

/**
 * This is the model class for table "informacion_personal".
 *
 * The followings are the available columns in table 'informacion_personal':
 * @property string $id
 * @property boolean $genero
 * @property string $fecha_nacimiento
 * @property integer $id_ocupacion
 * @property string $id_estado_civil
 *
 * The followings are the available model relations:
 * @property General $id0
 * @property EstadoCivil $idEstadoCivil
 * @property Crmocupacion $idOcupacion
 */
class InformacionPersonal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informacion_personal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id_ocupacion', 'numerical', 'integerOnly'=>true),
			array('id_estado_civil', 'length', 'max'=>3),
			array('genero, fecha_nacimiento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, genero, fecha_nacimiento, id_ocupacion, id_estado_civil', 'safe', 'on'=>'search'),
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
			'id0' => array(self::BELONGS_TO, 'General', 'id'),
			'estadoCivil' => array(self::BELONGS_TO, 'EstadoCivil', 'id_estado_civil'),
			'idOcupacion' => array(self::BELONGS_TO, 'Crmocupacion', 'id_ocupacion'),
			'ocupacion' => array(self::BELONGS_TO, 'Ocupacion', 'id_ocupacion')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'genero' => 'Genero',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'id_ocupacion' => 'Id Ocupacion',
			'id_estado_civil' => 'Id Estado Civil',
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
		$criteria->compare('genero',$this->genero);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('id_ocupacion',$this->id_ocupacion);
		$criteria->compare('id_estado_civil',$this->id_estado_civil,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformacionPersonal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
