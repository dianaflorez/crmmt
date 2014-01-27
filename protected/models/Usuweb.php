<?php

/**
 * This is the model class for table "usuarioweb".
 *
 * The followings are the available columns in table 'usuarioweb':
 * @property string $id_usuario
 * @property string $login
 * @property string $password
 * @property integer $level
 *
 * The followings are the available model relations:
 * @property General $idUsuario
 */
class Usuweb extends CActiveRecord
{
	public $repeat_clave;
	public $password;
	public $claveant;
	public $initialPassword;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuweb the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarioweb';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario,login', 'required'),
			array('level', 'numerical', 'integerOnly'=>true),
			array('login', 'length', 'max'=>20),
			array('estado', 'length', 'max'=>1),			
			array('password', 'length', 'max'=>40),
			array('feccre, fecmod, recibir_correo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_usuario, login, password, level, feccre, fecmod, estado, recibir_correo',  'safe', 'on'=>'search'),
   	     	//password and repeat password
		    array('password, claveant', 'required', 'on'=>'insert'),
            array('password, repeat_clave', 'required', 'on'=>'insert'),
            array('password, repeat_clave', 'length', 'min'=>5, 'max'=>40),
            array('password', 'compare', 'compareAttribute'=>'repeat_clave'),
			
			array('login', 'unique', 'message'=>'Lo siento no se debe repetir'),
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
			'general' => array(self::BELONGS_TO, 'General', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_usuario' => 'Id Usuario',
			'login' => 'Nombre de Usuario ( Login )',
			'password' => 'Clave',
			'repeat_clave' => 'Repetir Clave',
			'level' => 'Level',
			'claveant'=>'Clave Anterior',
			'feccre' => 'Feccre',
			'fecmod' => 'Fecmod',
			'estado' => 'Estado',
			'recibir_correo' => 'Recibir Correo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		/*		$criteria->with = array('general','emails');
		$criteria->together = true;
		$criteria->addInCondition('t.idtb1',1,3,5,6,7);
		$criteria->compare('idtb2',$this->idtb2);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('tabla2.codigo',$this->codigo,true);
		$criteria->compare('tabla3.description',$this->descrip,true);
		*/

		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('estado',$this->estado,true);		
		$criteria->compare('password',$this->password,true);
		$criteria->compare('level',$this->level);
//		$criteria->compare('idUsuario.nombre1',$this->id_usuario,true);	
		$criteria->compare('feccre',$this->feccre,true);
		$criteria->compare('fecmod',$this->fecmod,true);
		//$criteria->compare('estado',$this->estado,true);
		$criteria->compare('recibir_correo',$this->recibir_correo);	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	//codigo DF
	public function validatePassword($password, $username){
		 $password = md5($password);
		 $user = Usuweb::model()->find('login=? AND password=?', array($username,$password));
		if($user === NULL)
		    return false;
		else
			return true;	
	}
	
	protected function beforeSave()
	{
		if ($this->isNewRecord) {
		$this->password=md5($this->password);
 	 	}
  	  elseif(  $this->password!==$this->initialPassword )
        {
			$this->password=md5($this->password);
	    }
		return parent::beforeSave(); // don't forget this line!
	}
	
	 public function afterFind()
    {
        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->password;
		$this->repeat_clave=$this->password;
        parent::afterFind();
    }
}