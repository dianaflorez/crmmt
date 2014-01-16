<?php

class PublicoObjetivoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'create','update', 'usuarios', 'agregarUsuarios', 'agregar', 'departamentos'),
				'expression' => 'Yii::app()->user->checkAccess("CRMAdmin")',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PublicoObjetivo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PublicoObjetivo']))
		{
			$model->attributes = $_POST['PublicoObjetivo'];
			$model->id_usu     = Yii::app()->user->getState('usuid');
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_po));
		}

		$publicos = PublicoObjetivo::model()->findAll();

		//var_dump(PublicoObjetivo::model()->getAttributes());
		$this->render('create',array(
			'model'=>$model,
			'publicos'=>$publicos
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PublicoObjetivo']))
		{
			$model->attributes=$_POST['PublicoObjetivo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_po));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionUsuarios($id)
	{
		$model = $this->loadModel($id);

		$this->render('usuarios', array(
			'model' => $model
		));
	}


	public function actionAgregarUsuarios($id)
	{
		$model = $this->loadModel($id);

		//$general = new General;

		$usuariosPorPagina = 20;
		$pagina            = (isset($_GET['page']) ? $_GET['page'] : 1);
		$pagina            = (int) $pagina;
		
		$criterio = new CDbCriteria();	

		if(isset($_POST['Usuario']))
		{
			$pagina = 0;
			//$_GET['page'] = 1;
			$identificacion = (isset($_POST['Usuario']['identificacion'])) ? $_POST['Usuario']['identificacion'] : '';
			if($identificacion != '')
			{
				$criterio->addSearchCondition('id_char', $identificacion, true, 'OR', 'ILIKE');
			}

			$nombresCadena = (isset($_POST['Usuario']['nombre'])) ? $_POST['Usuario']['nombre'] : '';
			if($nombresCadena != '')
			{
				$nombres = explode(' ', $nombresCadena);
				foreach ($nombres as $nombre) 
				{
					$criterio->addSearchCondition('nombre1', $nombre, true, 'OR', 'ILIKE');
					$criterio->addSearchCondition('nombre2', $nombre, true, 'OR', 'ILIKE');
				}
			}

			$apellidosCadena = (isset($_POST['Usuario']['apellido'])) ? $_POST['Usuario']['apellido'] : '';
			if($apellidosCadena != '')
			{
				$apellidos = explode(' ', $apellidosCadena);
				foreach ($apellidos as $apellido) 
				{
					$criterio->addSearchCondition('apellido1', $apellido, true, 'OR', 'ILIKE');
					$criterio->addSearchCondition('apellido2', $apellido, true, 'OR', 'ILIKE');
				}
			}

			$generoCadena = (isset($_POST['Usuario']['genero'])) ? $_POST['Usuario']['genero'] : '';
			//var_dump($generoCadena);
			
			if($generoCadena != '' || $generoCadena === '1' || $generoCadena === '0')
			{
				$genero = $generoCadena === '1' ? true : false;
				$criterio->join ='JOIN informacion_personal ON t.id = informacion_personal.id';
				$criterio->addCondition('genero =:genero');
				$criterio->params += array(':genero' => $genero);
			}

			// $mesCadena = (isset($_POST['Usuario']['mes_nacimiento'])) ? $_POST['Usuario']['mes_nacimiento'] : '';
			// //$anhoCadena = (isset($_POST['Usuario']['anho_nacimiento'])) ? $_POST['Usuario']['anho_nacimiento'] : '';
			// if($mesCadena != '' && $anhoCadena !='')
			// {
			// 	$mes = new date('m', $mesCadena);
			// 	//$anho = 
			// 	$criterio->join ='JOIN informacion_personal ON t.id = informacion_personal.id';
			// 	$criterio->addCondition('genero =:genero');
			// 	$criterio->params = array(':genero' => $genero);
			// }


			$fechaInicio = (isset($_POST['Usuario']['fecha_inicio'])) ? $_POST['Usuario']['fecha_inicio'] : '';
			$fechanFin = (isset($_POST['Usuario']['fecha_fin'])) ? $_POST['Usuario']['fecha_fin'] : '';
			if($fechaInicio != '' && $fechanFin !='')
			{
				$criterio->join ='JOIN informacion_personal ON t.id = informacion_personal.id';
				$criterio->addBetweenCondition('fecha_nacimiento', $fechaInicio, $fechanFin);
			}
			
			$estadoCivilCadena = (isset($_POST['Usuario']['estado_civil'])) ? $_POST['Usuario']['estado_civil'] : '';
			if($estadoCivilCadena != '')
			{
				$criterio->join = 'JOIN informacion_personal ON t.id = informacion_personal.id';
				$criterio->addCondition('id_estado_civil =:id_estado_civil');
				$criterio->params += array(':id_estado_civil' => $estadoCivilCadena);
			}

			$ocupacionCadena = (isset($_POST['Usuario']['ocupacion'])) ? $_POST['Usuario']['ocupacion'] : '';
			if($ocupacionCadena != '')
			{
				$criterio->join = 'JOIN informacion_personal ON t.id = informacion_personal.id';
				$criterio->addCondition('id_ocupacion =:id_ocupacion');
				$criterio->params += array(':id_ocupacion' => (int) $ocupacionCadena);
			}

			$departamentoCadena = (isset($_POST['Usuario']['departamento'])) ? $_POST['Usuario']['departamento'] : '';
			if($departamentoCadena != '' && $departamentoCadena !='2')
			{
				//$departamento = (int) $departamentoCadena;
				$criterio->join = 'JOIN direcciones ON t.id = direcciones.id';
				$criterio->addCondition('id_dep =:id_dep');
				$criterio->params += array(':id_dep' => $departamentoCadena);
			}

			$paisCadena = (isset($_POST['Usuario']['pais'])) ? $_POST['Usuario']['pais'] : '';
			if($paisCadena != '' && $paisCadena !='2')
			{
				$criterio->join = 'JOIN direcciones ON t.id = direcciones.id';
				$criterio->addCondition('id_pais =:id_pais');
				$criterio->params += array(':id_pais' => $paisCadena);                
			}                                                                

		}

		$comenzar_desde = ($pagina - 1) * $usuariosPorPagina;

		
		$criterio->limit  = $usuariosPorPagina;
		$criterio->offset = $comenzar_desde;
		$criterio->order  = 'apellido1';

		$usuariosGeneral  = General::model()->findAll($criterio);
		$total            = General::model()->count($criterio);
		
		$ocupacion           = Ocupacion::model()->findAll();
		$estadoCivil         = EstadoCivil::model()->findAll();
		$departamento        = Departamentos::model()->findAll();
		$criterioPais        = new CDbCriteria;
		$criterioPais->order = 'nombre ASC';
		$pais                = Pais::model()->findAll($criterioPais);

		//var_dump($total);
		//var_dump(count($usuariosGeneral));
		$paginas = new CPagination($total);
		$paginas->setPageSize($usuariosPorPagina);
		$paginas->applyLimit($criterio);
		if(isset($_POST['Usuario']))
			$paginas->currentPage = 0;

		$this->render('agregarUsuarios', array(
			'model'           => $model,
			'usuariosGeneral' => $usuariosGeneral,
			'pages'           => $paginas,
			'total'           => $total,
			'ocupacion'       => $ocupacion,
			'estadoCivil'     => $estadoCivil,
			'departamento'    => $departamento,
			'pais'            => $pais
			//'nombres' => $nombresCadena,
			//'apellidos' => $apellidosCadena
		));
	}

	public function actionAgregar()
	{	
		if(isset($_POST['id_po']) && Yii::app()->user->getState('usuid') != null)
		{
			$id                   = (int) $_POST['id_po'];//$id;
			$model                = $this->loadModel($id);
			$id_usupo             = (int) $_POST['id_usupo'];//$id_usupo;

			$usuario_po           = new UsuarioPublicoObjetivo;
			$usuario_po->id_po    = $id;
			$usuario_po->id_usupo = $id_usupo;
			$usuario_po->id_usu   = Yii::app()->user->getState('usuid');
		
			try
			{
				if($usuario_po->save())
				{
					echo 'true';
				}
				else
				{
					throw new CHttpException(500,'La petición fallo.');
				}
			}
			catch(Exception $e)
			{
				throw new CHttpException(500,'La petición fallo.');
			}
		}
		else
		{
			throw new CHttpException(400, 'La petición fallo.');
		}		
	}

	public function actionDepartamentos($id)
	{
		$criterio = new CDbCriteria;
		$criterio->addCondition('id_pais =:id_pais');
		$criterio->params = array(':id_pais'=>$id);
		$criterio->order = 'nombre ASC';

		$paises = Departamentos::model()->findAll($criterio);
		echo CJavaScript::jsonEncode($paises);
		Yii::app()->end();
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('PublicoObjetivo');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));

		$publicos = PublicoObjetivo::model()->findAll();

		//var_dump(PublicoObjetivo::model()->getAttributes());
		$this->render('index',array(
			'publicos' => $publicos
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PublicoObjetivo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PublicoObjetivo']))
			$model->attributes=$_GET['PublicoObjetivo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PublicoObjetivo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PublicoObjetivo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PublicoObjetivo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='publico-objetivo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
