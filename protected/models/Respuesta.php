<?php

/**
 * This is the model class for table "crmrespuesta".
 *
 * The followings are the available columns in table 'crmrespuesta':
 * @property integer $id_res
 * @property string $id_usur
 * @property integer $id_fp
 * @property integer $id_op
 * @property string $txtres
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 *
 * The followings are the available model relations:
 * @property General $idUsu
 * @property General $idUsur
 * @property Crmforpre $idFp
 * @property Crmopcionpre $idOp
 */
class Respuesta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmrespuesta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usur, id_fp', 'required'),
			array('id_fp, id_op', 'numerical', 'integerOnly'=>true),
			array('txtres, feccre, fecmod', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_res, id_usur, id_fp, id_op, txtres, feccre, fecmod', 'safe', 'on'=>'search'),
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
			//'idUsu' => array(self::BELONGS_TO, 'General', 'id_usu'),
			'idUsur' => array(self::BELONGS_TO, 'General', 'id_usur'),
			'idFp' => array(self::BELONGS_TO, 'Crmforpre', 'id_fp'),
			'opcion' => array(self::BELONGS_TO, 'OpcionPregunta', 'id_op'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_res' => 'Id Res',
			'id_usur' => 'Id Usur',
			'id_fp' => 'Id Fp',
			'id_op' => 'Id Op',
			'txtres' => 'Txtres',
			'feccre' => 'Feccre',
			'fecmod' => 'Fecmod',
			//'id_usu' => 'Id Usu',
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

		$criteria->compare('id_res',$this->id_res);
		$criteria->compare('id_usur',$this->id_usur,true);
		$criteria->compare('id_fp',$this->id_fp);
		$criteria->compare('id_op',$this->id_op);
		$criteria->compare('txtres',$this->txtres,true);
		$criteria->compare('feccre',$this->feccre,true);
		$criteria->compare('fecmod',$this->fecmod,true);
		//$criteria->compare('id_usu',$this->id_usu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Respuesta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
