<?php

/**
 * This is the model class for table "general".
 *
 * The followings are the available columns in table 'general':
 * @property integer $id
 * @property string $id_char
 * @property string $dv
 * @property string $nombre1
 * @property string $nombre2
 * @property string $apellido1
 * @property string $apellido2
 * @property string $razon_social
 * @property integer $id_clase_tercero
 *
 * The followings are the available model relations:
 * @property Emails[] $emails
 * @property InformacionPersonal[] $informacionPersonals
 * @property Crmcampana[] $crmcampanas
 * @property Crmcampanausu[] $crmcampanausus
 * @property Direcciones[] $direcciones
 * @property Usuarioweb $usuarioweb
 * @property Crmusuariopo[] $crmusuariopos
 * @property Crmusuariopo[] $crmusuariopos1
 * @property Crmpreferencia[] $crmpreferencias
 * @property Crmtipopreres[] $crmtipopreres
 * @property Crmtipopre[] $crmtipopres
 * @property Crmpregunta[] $crmpreguntas
 * @property Crmrespuesta[] $crmrespuestas
 * @property Crmrespuesta[] $crmrespuestas1
 * @property Crmopcionpre[] $crmopcionpres
 * @property Crmforpre[] $crmforpres
 * @property Crmformulario[] $crmformularios
 */
class General extends CActiveRecord
{
	public $nombres, $apellidos, $correo;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'general';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_char', 'required'),
			array('id_clase_tercero', 'numerical', 'integerOnly'=>true),
			array('id_char', 'length', 'max'=>14),
			array('dv', 'length', 'max'=>1),
			array('nombre1', 'length', 'max'=>60),
			array('nombre2, apellido1, apellido2', 'length', 'max'=>30),
			array('razon_social', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_char, dv, nombre1, nombre2, apellido1, apellido2, razon_social, id_clase_tercero, nombres, apellidos, correo', 'safe', 'on'=>'search'),
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
			'emails'                => array(self::HAS_MANY, 'Emails', 'id'),
			'informacionPersonal'   => array(self::HAS_ONE, 'InformacionPersonal', 'id'),
			//'informacionPersonal' => array(self::HAS_ONE, 'InformacionPersonal', 'id'),
			'crmcampanas'           => array(self::HAS_MANY, 'Crmcampana', 'id_usu'),
			'crmcampanausus'        => array(self::HAS_MANY, 'Crmcampanausu', 'id_usuc'),
			'direcciones'           => array(self::HAS_MANY, 'Direcciones', 'id'),
			'usuarioweb'            => array(self::HAS_ONE, 'Usuarioweb', 'id_usuario'),
			'crmusuariopos'         => array(self::HAS_MANY, 'Crmusuariopo', 'id_usupo'),
			'crmusuariopos1'        => array(self::HAS_MANY, 'Crmusuariopo', 'id_usu'),
			'crmpreferencias'       => array(self::HAS_MANY, 'Crmpreferencia', 'id_usup'),
			'crmtipopreres'         => array(self::HAS_MANY, 'Crmtipopreres', 'id_usu'),
			'crmtipopres'           => array(self::HAS_MANY, 'Crmtipopre', 'id_usu'),
			'crmpreguntas'          => array(self::HAS_MANY, 'Crmpregunta', 'id_usu'),
			'crmrespuestas'         => array(self::HAS_MANY, 'Crmrespuesta', 'id_usu'),
			'crmrespuestas1'        => array(self::HAS_MANY, 'Crmrespuesta', 'id_usur'),
			'crmopcionpres'         => array(self::HAS_MANY, 'Crmopcionpre', 'id_usu'),
			'crmforpres'            => array(self::HAS_MANY, 'Crmforpre', 'id_usu'),
			'crmformularios'        => array(self::HAS_MANY, 'Crmformulario', 'id_usu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'               => 'ID',
			'id_char'          => 'Identificación',
			'dv'               => 'Dv',
			'nombre1'          => 'Nombre',
			'nombre2'          => 'Nombre2',
			'apellido1'        => 'Apellido',
			'apellido2'        => 'Apellido2',
			'razon_social'     => 'Razon Social',
			'id_clase_tercero' => 'Id Clase Tercero',
			'nombres'          => 'Nombres',
			'apellidos'        => 'Apellidos',
			'correo'           => 'Correo'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_char',$this->id_char,true);
		$criteria->compare('dv',$this->dv,true);
		$criteria->compare('nombre1',$this->nombre1,true);
		$criteria->compare('nombre2',$this->nombre2,true);
		$criteria->compare('apellido1',$this->apellido1,true);
		$criteria->compare('apellido2',$this->apellido2,true);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('id_clase_tercero',$this->id_clase_tercero);

		$criteria->order = 'nombre1 ASC';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return General the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getNombresUnidos()
	{

		return ucfirst(strtolower($this->nombre1)).' '.ucfirst(strtolower($this->nombre2));
	}

	public function getApellidosUnidos()
	{
		return ucfirst(strtolower($this->apellido1)).' '.ucfirst(strtolower($this->apellido2));
	}

	public function getMail()
	{
		return $this->emails ? strtolower($this->emails[0]->direccion) : 'No registra';
	}

	public function filtradoPorUsuarios($usuariosId)
	{
		$criteria = new CDbCriteria;
		$criteria->addInCondition('t.id',$usuariosId);
		
		$criteria->addSearchCondition('id_char',$this->id_char,true);
		$criteria->addSearchCondition('CONCAT(LOWER(nombre1), \' \', LOWER(nombre2))', strtolower($this->nombres), true);
		$criteria->addSearchCondition('CONCAT(LOWER(apellido1), \' \', LOWER(apellido2))', strtolower($this->apellidos), true);
		
		$criteria->with = array('emails');
		$criteria->addSearchCondition('LOWER(direccion)', strtolower($this->correo), true);
		$criteria->together = true;
		
		$sort = new CSort;
		$sort->attributes = array(
			'id_char'   => array('*', 'id_char'),
			'nombres'   => array(
                    'asc'  => 'nombre1 ASC',
                    'desc' => 'nombre1 DESC',
            ),
			'apellidos' => array(
                    'asc'  => 'apellido1 ASC',
                    'desc' => 'apellido1 DESC',
            ),
			'correo'    => array(
                    'asc'  => 'direccion ASC',
                    'desc' => 'direccion DESC',
            ),
		);
		return new CActiveDataProvider('General', array(
		   	'criteria'   => $criteria,
		   	'sort'       => $sort,
		   	'pagination' => array(
		        'pageSize' => 20,
		    ),
		 ));

	}

}
