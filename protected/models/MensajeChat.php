<?php

/**
 * This is the model class for table "mensaje_chat".
 *
 * The followings are the available columns in table 'mensaje_chat':
 * @property integer $id
 * @property integer $id_sesion
 * @property string $mensaje
 * @property string $nombre_usuario
 * @property string $fecha
 */
class MensajeChat extends CActiveRecord
{
	private static $dbchat = null;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mensaje_chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_sesion', 'numerical', 'integerOnly'=>true),
			array('nombre_usuario', 'length', 'max'=>30),
			array('mensaje, fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_sesion, mensaje, nombre_usuario, fecha', 'safe', 'on'=>'search'),
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
			'id_sesion' => 'Id Sesion',
			'mensaje' => 'Mensaje',
			'nombre_usuario' => 'Nombre Usuario',
			'fecha' => 'Fecha',
		);
	}

	/**
	 * Asigna la fecha de creación o actualización automáticamente antes de grabar el modelo.
	 **/

	public function beforeSave() {
	    if ($this->isNewRecord)
	        $this->fecha = new CDbExpression('CURRENT_TIMESTAMP');
	 
	    return parent::beforeSave();
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
		$criteria->compare('id_sesion',$this->id_sesion);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('nombre_usuario',$this->nombre_usuario,true);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MensajeChat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	// Retorna la conexión a la base de datos de chat.
	public function getAdvertDbConnection()
    {
        if (self::$dbchat !== null)
            return self::$dbchat;
        else
        {
            self::$dbchat = Yii::app()->dbchat;
            if (self::$dbchat instanceof CDbConnection)
            {
                self::$dbchat->setActive(true);
                return self::$dbchat;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }

    // Sobrescribe el método de conexión de la clase.
    public function getDbConnection()
    {
        return self::getAdvertDbConnection();
    }
}
