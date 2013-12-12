<?php

/**
 * This is the model class for table "departamentos".
 *
 * The followings are the available columns in table 'departamentos':
 * @property string $id_dep
 * @property string $id_pais
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Pais $idPais
 * @property Municipios[] $municipioses
 * @property Municipios[] $municipioses1
 */
class Departamentos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'departamentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_dep, id_pais, nombre', 'required'),
			array('id_dep, id_pais', 'length', 'max'=>3),
			array('nombre', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dep, id_pais, nombre', 'safe', 'on'=>'search'),
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
			'idPais' => array(self::BELONGS_TO, 'Pais', 'id_pais'),
			'municipioses' => array(self::HAS_MANY, 'Municipios', 'id_pais'),
			'municipioses1' => array(self::HAS_MANY, 'Municipios', 'id_dep'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_dep' => 'Id Dep',
			'id_pais' => 'Id Pais',
			'nombre' => 'Nombre',
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

		$criteria->compare('id_dep',$this->id_dep,true);
		$criteria->compare('id_pais',$this->id_pais,true);
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Departamentos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
