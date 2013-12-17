<?php

/**
 * This is the model class for table "crmusuariopo".
 *
 * The followings are the available columns in table 'crmusuariopo':
 * @property integer $id_upo
 * @property integer $id_po
 * @property string $id_usupo
 * @property boolean $estado
 * @property string $feccre
 * @property string $fecmod
 * @property string $id_usu
 *
 * The followings are the available model relations:
 * @property Crmpublicobjetivo $idPo
 * @property General $idUsupo
 * @property General $idUsu
 */
class UsuarioPublicoObjetivo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'crmusuariopo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usupo, id_usu', 'required'),
			array('id_po', 'numerical', 'integerOnly'=>true),
			array('estado, feccre, fecmod', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_upo, id_po, id_usupo, estado, feccre, fecmod, id_usu', 'safe', 'on'=>'search'),
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
			'idPo' => array(self::BELONGS_TO, 'Crmpublicobjetivo', 'id_po'),
			'general' => array(self::BELONGS_TO, 'General', 'id_usupo'),
			'idUsu' => array(self::BELONGS_TO, 'General', 'id_usu')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_upo' => 'Id Upo',
			'id_po' => 'Id Po',
			'id_usupo' => 'Id Usupo',
			'estado' => 'Estado',
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

		$criteria->compare('id_upo',$this->id_upo);
		$criteria->compare('id_po',$this->id_po);
		$criteria->compare('id_usupo',$this->id_usupo,true);
		$criteria->compare('estado',$this->estado);
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
	 * @return UsuarioPublicoObjetivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
