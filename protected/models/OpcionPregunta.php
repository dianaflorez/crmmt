<?php

/**
 * This is the model class for table "crmopcionpre".
 *
 * The followings are the available columns in table 'crmopcionpre':
 * @property integer $id_op
 * @property integer $id_pre
 * @property string $txtop
 * @property integer $orden
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 *
 * The followings are the available model relations:
 * @property General $idUsu
 * @property Crmpregunta $idPre
 * @property Crmrespuesta[] $crmrespuestas
 */
class OpcionPregunta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmopcionpre';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pre, txtop, id_usu', 'required'),
			array('id_pre, orden', 'numerical', 'integerOnly'=>true),
			array('txtop', 'length', 'max'=>70),
			array('feccre, fecmod', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_op, id_pre, txtop, orden, feccre, fecmod, id_usu', 'safe', 'on'=>'search'),
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
			'idPre' => array(self::BELONGS_TO, 'Crmpregunta', 'id_pre'),
			'crmrespuestas' => array(self::HAS_MANY, 'Crmrespuesta', 'id_op'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_op' => 'Id Op',
			'id_pre' => 'Id Pre',
			'txtop' => 'Txtop',
			'orden' => 'Orden',
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

		$criteria->compare('id_op',$this->id_op);
		$criteria->compare('id_pre',$this->id_pre);
		$criteria->compare('txtop',$this->txtop,true);
		$criteria->compare('orden',$this->orden);
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
	 * @return OpcionPregunta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
