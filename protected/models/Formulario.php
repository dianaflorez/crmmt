<?php

/**
 * This is the model class for table "crmformulario".
 *
 * The followings are the available columns in table 'crmformulario':
 * @property integer $id_for
 * @property string $titulo
 * @property string $contenido
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 * @property boolean $estado
 * @property string $fecini
 * @property string $fecfin
 *
 * The followings are the available model relations:
 * @property General $idUsu
 * @property Crmforpre[] $crmforpres
 */
class Formulario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmformulario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('titulo, id_usu', 'required', 'message' => 'No puede ser vacio.'),
			array('titulo', 'length', 'max'=>64),
			array('contenido, feccre, fecmod, estado, fecini, fecfin', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_for, titulo, contenido, feccre, fecmod, id_usu, estado, fecini, fecfin', 'safe', 'on'=>'search'),
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
			'idUsu' => array(self::BELONGS_TO, 'General', 'id_usu'),
			'crmforpres' => array(self::HAS_MANY, 'Crmforpre', 'id_for'),
			'preguntas' => array(self::MANY_MANY, 'Pregunta', 'crmforpre(id_pre,id_for)'),
			//'respuestas' => array(self::MANY_MANY, 'Respuesta', 'crmforpre(id_pre,id_fp)'),
			//'formulariosPregunta' => array(self::HAS_MANY, 'FormularioPregunta', 'id_for')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_for'    => 'Id For',
			'titulo'    => 'Título',
			'contenido' => 'Contenido',
			'feccre'    => 'Feccre',
			'fecmod'    => 'Fecmod',
			'id_usu'    => 'Id Usu',
			'estado'    => 'Estado',
			'fecini'    => 'Fecini',
			'fecfin'    => 'Fecfin',
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

		$criteria->compare('id_for',$this->id_for);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('feccre',$this->feccre,true);
		$criteria->compare('fecmod',$this->fecmod,true);
		$criteria->compare('id_usu',$this->id_usu,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecini',$this->fecini,true);
		$criteria->compare('fecfin',$this->fecfin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Formulario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
