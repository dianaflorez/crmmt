<?php

/**
 * This is the model class for table "crmpregunta".
 *
 * The followings are the available columns in table 'crmpregunta':
 * @property integer $id_pre
 * @property string $txtpre
 * @property string $despre
 * @property integer $id_tp
 * @property integer $id_tpr
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 *
 * The followings are the available model relations:
 * @property General $idUsu
 * @property Crmtipopre $idTp
 * @property Crmtipopreres $idTpr
 * @property Crmforpre[] $crmforpres
 * @property Crmopcionpre[] $crmopcionpres
 */
class Pregunta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmpregunta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('txtpre, id_tp, id_usu', 'required', 'message' => 'No puede ser vacio.'),
			array('id_tp, id_tpr', 'numerical', 'integerOnly'=>true),
			array('txtpre', 'length', 'max'=>70),
			array('despre, feccre, fecmod', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pre, txtpre, despre, id_tp, id_tpr, feccre, fecmod, id_usu', 'safe', 'on'=>'search'),
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
			'tipo' => array(self::BELONGS_TO, 'TipoPregunta', 'id_tp'),
			'idTpr' => array(self::BELONGS_TO, 'Crmtipopreres', 'id_tpr'),
			'formularioPregunta' => array(self::HAS_ONE, 'FormularioPregunta', 'id_pre'),
			'opciones' => array(self::HAS_MANY, 'OpcionPregunta', 'id_pre'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pre' => 'Id Pre',
			'txtpre' => 'Pregunta',
			'despre' => 'Despre',
			'id_tp' => 'Id Tp',
			'id_tpr' => 'Id Tpr',
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

		$criteria->compare('id_pre',$this->id_pre);
		$criteria->compare('txtpre',$this->txtpre,true);
		$criteria->compare('despre',$this->despre,true);
		$criteria->compare('id_tp',$this->id_tp);
		$criteria->compare('id_tpr',$this->id_tpr);
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
	 * @return Pregunta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
