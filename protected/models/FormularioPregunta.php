<?php

/**
 * This is the model class for table "crmforpre".
 *
 * The followings are the available columns in table 'crmforpre':
 * @property integer $id_fp
 * @property integer $id_pre
 * @property integer $id_for
 * @property boolean $estado
 * @property string $fecini
 * @property string $fecfin
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 *
 * The followings are the available model relations:
 * @property General $idUsu
 * @property Crmpregunta $idPre
 * @property Crmformulario $idFor
 * @property Crmrespuesta[] $crmrespuestas
 */
class FormularioPregunta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmforpre';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pre, id_for, id_usu', 'required'),
			array('id_pre, id_for', 'numerical', 'integerOnly'=>true),
			array('feccre, fecmod', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_fp, id_pre, id_for, feccre, fecmod, id_usu', 'safe', 'on'=>'search'),
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
			'idPre' => array(self::BELONGS_TO, 'Pregunta', 'id_pre'),
			'idFor' => array(self::BELONGS_TO, 'Crmformulario', 'id_for'),
			'respuestas' => array(self::HAS_MANY, 'Respuesta', 'id_fp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_fp' => 'Id Fp',
			'id_pre' => 'Id Pre',
			'id_for' => 'Id For',
			// 'estado' => 'Estado',
			// 'fecini' => 'Fecini',
			// 'fecfin' => 'Fecfin',
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

		$criteria->compare('id_fp',$this->id_fp);
		$criteria->compare('id_pre',$this->id_pre);
		$criteria->compare('id_for',$this->id_for);
		// $criteria->compare('estado',$this->estado);
		// $criteria->compare('fecini',$this->fecini,true);
		// $criteria->compare('fecfin',$this->fecfin,true);
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
	 * @return FormularioPregunta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
