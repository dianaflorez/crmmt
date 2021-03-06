<?php

/**
 * This is the model class for table "direcciones".
 *
 * The followings are the available columns in table 'direcciones':
 * @property integer $id_direccion
 * @property string $id
 * @property string $id_pais
 * @property string $id_dep
 * @property string $municipio
 * @property string $descripcion
 * @property string $direccion
 *
 * The followings are the available model relations:
 * @property General $id0
 * @property Municipios $idPais
 * @property Municipios $idDep
 * @property Municipios $municipio0
 */
class Direcciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'direcciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_pais, id_dep, municipio, direccion', 'required'),
			array('id_pais, id_dep, municipio', 'length', 'max'=>3),
			array('descripcion, direccion', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_direccion, id, id_pais, id_dep, municipio, descripcion, direccion', 'safe', 'on'=>'search'),
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
			'pais' => array(self::BELONGS_TO, 'Pais', 'id_pais'),
			'departamento' => array(self::BELONGS_TO, 'Departamento', 'id_dep'),
			'municipio' => array(self::BELONGS_TO, 'Municipios', 'municipio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_direccion' => 'Id Direccion',
			'id' => 'ID',
			'id_pais' => 'Id Pais',
			'id_dep' => 'Id Dep',
			'municipio' => 'Municipio',
			'descripcion' => 'Descripcion',
			'direccion' => 'Direccion',
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

		$criteria->compare('id_direccion',$this->id_direccion);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_pais',$this->id_pais,true);
		$criteria->compare('id_dep',$this->id_dep,true);
		$criteria->compare('municipio',$this->municipio,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('direccion',$this->direccion,true);

		$criteria->order = 'id_direccion DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Direcciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
