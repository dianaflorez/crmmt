<?php

/**
 * This is the model class for table "sesion_chat".
 *
 * The followings are the available columns in table 'sesion_chat':
 * @property integer $id
 * @property string $nombre_usuario
 * @property boolean $contestada
 * @property string $id_room
 * @property string $id_user
 */
class SesionChat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sesion_chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_usuario', 'required', 'message' => 'Ingrese un nombre por favor.'),
			array('correo', 'required', 'message' => 'Ingrese un correo por favor.'),
			array('usuario_atendio', 'numerical', 'integerOnly'=>true),
			array('nombre_usuario, id_room, id_user', 'length', 'max'=>30),
			array('contestada, terminada, fecha_creacion', 'safe'),
			array('correo', 'email', 'message' => 'Revise que su dirección sea correcta.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre_usuario, contestada, id_room, id_user, terminada, correo, usuario_atendio, fecha_creacion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Asigna la fecha de creación o actualización automáticamente antes de grabar el modelo.
	 **/

	public function beforeSave() {
	    if ($this->isNewRecord)
	        $this->fecha_creacion = new CDbExpression('CURRENT_TIMESTAMP');
	 
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
			'mensajes' => array(self::HAS_MANY, 'MensajeChat', 'id_sesion'),
			'usuarioAtendio' => array(self::BELONGS_TO, 'General', 'usuario_atendio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre_usuario' => 'Nombres',
			'contestada' => 'Atendida',
			'id_room' => 'Id Room',
			'id_user' => 'Id User',
			'terminada' => 'Terminada',
			'correo' => 'Correo',
			'usuario_atendio' => 'Usuario Atendio',
			'fecha_creacion' => 'Creada el'
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
		$criteria->compare('nombre_usuario',$this->nombre_usuario,true);
		$criteria->compare('contestada',$this->contestada);
		$criteria->compare('id_room',$this->id_room,true);
		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('terminada',$this->terminada);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('usuario_atendio',$this->usuario_atendio);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->order = 'fecha_creacion DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SesionChat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}