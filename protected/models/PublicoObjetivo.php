<?php

/**
 * This is the model class for table "crmpublicobjetivo".
 *
 * The followings are the available columns in table 'crmpublicobjetivo':
 * @property integer $id_po
 * @property string $nombre
 * @property string $descripcion
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 *
 * The followings are the available model relations:
 * @property Crmusuariopo[] $crmusuariopos
 */
class PublicoObjetivo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmpublicobjetivo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, id_usu', 'required'),
			array('nombre', 'length', 'max'=>128),
			array('descripcion, feccre, fecmod', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_po, nombre, descripcion, feccre, fecmod, id_usu', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * Asigna la fecha de creación o actualización automáticamente antes de grabar el modelo.
	 **/

	public function beforeSave() {
	    if ($this->isNewRecord)
	        $this->feccre = new CDbExpression('CURRENT_TIMESTAMP');
	    else
	        $this->fecmod = new CDbExpression('CURRENT_TIMESTAMP');
	 
	    return parent::beforeSave();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'crmusuariopos' => array(self::HAS_MANY, 'Crmusuariopo', 'id_po'),
			'usuarios' => array(self::HAS_MANY, 'UsuarioPublicoObjetivo', 'id_po'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_po' => 'Id Po',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
			'feccre' => 'Feccre',
			'fecmod' => 'Fecmod',
			'id_usu' => 'Id Usu',
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

		$criteria->compare('id_po',$this->id_po);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('feccre',$this->feccre,true);
		$criteria->compare('fecmod',$this->fecmod,true);
		$criteria->compare('id_usu',$this->id_usu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PublicoObjetivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
