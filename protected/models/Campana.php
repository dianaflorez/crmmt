<?php

/**
 * This is the model class for table "crmcampana".
 *
 * The followings are the available columns in table 'crmcampana':
 * @property integer $id_cam
 * @property integer $id_tc
 * @property string $asunto
 * @property string $contenido
 * @property string $urlimage
 * @property string $fecini
 * @property string $fecfin
 * @property integer $precio
 * @property string $fecenvio
 * @property boolean $estado
 * @property boolean $personalizada
 * @property string $almacen
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 *
 * The followings are the available model relations:
 * @property Crmcampanausu[] $crmcampanausus
 * @property General $idUsu
 * @property Crmtipocam $idTc
 */
class Campana extends CActiveRecord
{
	public $image;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmcampana';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asunto, id_usu, contenido', 'required', 'message' => 'No puede ser vacio.'),
			array('id_tc', 'required', 'message' => 'Por favor seleccione un tipo de campaña.'),
			//array('urlimage', 'required', 'message' => 'Debe seleccionar una imagen.'),
			array('id_tc, precio', 'numerical', 'integerOnly'=>true),
			array('asunto', 'length', 'max'=>128),
			array('urlimage', 'length', 'max'=>100),
			array('almacen', 'length', 'max'=>3),
			array('contenido, fecini, fecfin, fecenvio, estado, personalizada, feccre, fecmod', 'safe'),
			// Atributo para subir la imagen al servidor.
			//array('image', 'file', 'types'=>'jpg, gif, png'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cam, id_tc, asunto, contenido, urlimage, fecini, fecfin, precio, fecenvio, estado, personalizada, almacen, feccre, fecmod, id_usu', 'safe', 'on'=>'search'),
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
			'crmcampanausus' => array(self::HAS_MANY, 'Crmcampanausu', 'id_cam'),
			'idUsu' => array(self::BELONGS_TO, 'General', 'id_usu'),
			'tipoCampana' => array(self::BELONGS_TO, 'TipoCam', 'id_tc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cam' => 'Id Cam',
			'id_tc' => 'Id Tc',
			'asunto' => 'Asunto',
			'contenido' => 'Contenido',
			'urlimage' => 'Urlimage',
			'fecini' => 'Fecini',
			'fecfin' => 'Fecfin',
			'precio' => 'Precio',
			'fecenvio' => 'Fecenvio',
			'estado' => 'Estado',
			'personalizada' => 'Personalizada',
			'almacen' => 'Almacén',
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

		$criteria->compare('id_cam',$this->id_cam);
		$criteria->compare('id_tc',$this->id_tc);
		$criteria->compare('asunto',$this->asunto,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('urlimage',$this->urlimage,true);
		$criteria->compare('fecini',$this->fecini,true);
		$criteria->compare('fecfin',$this->fecfin,true);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('fecenvio',$this->fecenvio,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('personalizada',$this->personalizada);
		$criteria->compare('almacen',$this->almacen,true);
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
	 * @return Campana the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
