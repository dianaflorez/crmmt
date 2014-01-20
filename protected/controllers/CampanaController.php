<?php
//Yii::import('ext.runactions.components.ERunActions');

class CampanaController extends Controller
{
	//protected $api_key = '515d5d909933946cd00c0473675cf6b7-us3';
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
			array('allow',
				'actions'=>array('index'),
				'users'=>array('?'),
			),
			array('allow',// allow authenticated user to perform 'view' actions
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('update', 'admin', 'delete', 'view', 'index', 'create', 'veamos', 'obtenerCorreos', 'enviar', 'enviarPrueba', 'duplicar', 'usuarioscampana'),
				'expression'=>'Yii::app()->user->checkAccess("CRMAdmin")',
				// or
				// 'roles'=>array('Admin'), 
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
		$model = new Campana;
		$model->almacen = 'MTA';
		$error = null;
		//$publicos = PublicoObjetivo::model()->findAll();
		$tiposCampana = TipoCam::model()->findAll();

		       
		if(isset($_POST['Campana']))
		{
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation($model);

			$model->attributes = $_POST['Campana'];
			$model->id_usu     = Yii::app()->user->getState('usuid');
			 
			// Almacenar la imagen.
			$model->image = CUploadedFile::getInstance($model, 'image');
			if($model->image != null)
			{
				$nombre = rand(1, 10000).$model->image;
				$directorio = Yii::app()->basePath.'/../images/'.$nombre;
				$model->image -> saveAs($directorio);
				$image = Yii::app()->image->load($directorio);   
			   	$image->resize(560, 100, Image::WIDTH);    
			   	$image->save();

			   	$model->urlimage = Yii::app()->getBaseUrl(true).'/images/'.$nombre;
			}

			if($model->save())
			{
				$this->redirect(array('index'));					
			}	
		}

		$this->render('create',array(
			'model' => $model,
			'tiposCampana' => $tiposCampana,
			'error' => $error
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEnviar($id)
	{
		$model = $this->loadModel($id);
		// if($model->estado)
		// 	$this->redirect(array('index'));

		$error                = null;
		$errorPublicoObjetivo = null;
		$publicos             = PublicoObjetivo::model()->findAll();
		       
		if(isset($_POST['Campana']))
		{
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation($model);

			try
			{
				$id_cam = isset($_POST['Campana']['id_cam']) ? $_POST['Campana']['id_cam'] : null;
				$model  = $this->loadModel($id_cam);

				//$correosDesuscripcion = $this->obtenerCorreosDesuscripcion($_POST['Campana']['PublicoObjetivo']);
				//$this->desuscribirListaMailChimp($correosDesuscripcion);
			   
				if(isset($_POST['Campana']['PublicoObjetivo']) && $_POST['Campana']['PublicoObjetivo'])
				{
					$id_publico = (int) $_POST['Campana']['PublicoObjetivo'];
					$correos    = Yii::app()->utilmailchimp->obtenerCorreosSuscripcion($id_publico);				
					
					if(count($correos['para_lista']) > 0)
					{
						
						Yii::app()->utilmailchimp->enviarCampana($model, $correos);
						$model->estado = true;

						//$this->eliminarSegmentoMailChimp($id_segmento);
						$this->registrarUsuariosCampanaEnviada($id_cam, $id_publico);

						if($model->save())
						{
							//$this->redirect(array('index'));
						}
						else
						{
							var_dump($model->getErrors());
						}
					}
					else
					{
						$errorPublicoObjetivo = 'El público objetivo no tiene correos válidos.';
					}
				
				}
				else
				{
					$errorPublicoObjetivo = 'No ha seleccionado un público';
				}
				
			}
			catch(Exception $e)
			{
				$error = $e->getMessage();
			}
		
		}

		$this->render('enviar', array(
			'model'                => $model,
			'publicos'             => $publicos,
			'error'                => $error,
			'errorPublicoObjetivo' => $errorPublicoObjetivo
		));
	}

	public function actionEnviarPrueba()
	{
		if(isset($_POST['id']) && isset($_POST['correoPrueba']))
		{
			$id_cam = (int) $_POST['id'];
			$correoPrueba = $_POST['correoPrueba'];
			$model = $this->loadModel($id_cam);
		
			if(!$model->estado)
			{	
				try
				{

					$validator = new CEmailValidator;
					if(!$validator->validateValue($correoPrueba))
						throw new Exception("Error Processing Request");
					
					$correos = array();
					$correos['para_lista'] = array();
					$correos['para_segmento'] = array();
					array_push($correos['para_lista'], array('email'=>array('email'=>$correoPrueba)));
					array_push($correos['para_segmento'], array('email'=>$correoPrueba));	            
					//var_dump(count($correos['para_lista']));
					
					if(count($correos['para_lista']) > 0)
					{

						Yii::app()->utilmailchimp->enviarCampana($model, $correos);
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
		}
		
	
	}


	protected function registrarUsuariosCampanaEnviada($id_cam, $id_po)
	{
		$publicoObjetivo = PublicoObjetivo::model()->findByPk($id_po);
		if(!$publicoObjetivo)
			return array();
		try
		{
			$transaccion = $publicoObjetivo->dbConnection->beginTransaction();
			foreach ($publicoObjetivo->usuarios as $usuario) {
				$campanaUsuario = new CampanaUsuario;
				$campanaUsuario->id_cam = $id_cam;
				$campanaUsuario->id_usuc = $usuario->id_usupo;
				$campanaUsuario->save();
			}
			$transaccion->commit();
		}
		catch(Exception $e)
		{
			$transaccion->rollback();
		}
	}


	public function actionDuplicar($id)
	{
		$model              = Campana::model()->findByPk($id);
		$model->id_cam      = null;
		$model->estado      = false;
		$model->isNewRecord = true;
	
		if($model->save())
			$this->redirect(array('index'));
	}

	/**
	 * Return data to browser as JSON
	 * @param array $data
	 */
	protected function renderJSON($data)
	{
	    header('Content-type: application/json');
	    echo CJSON::encode($data);

	    foreach (Yii::app()->log->routes as $route) {
	        if($route instanceof CWebLogRoute) {
	            $route->enabled = false; // disable any weblogroutes
	        }
	    }
	    Yii::app()->end();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		
		if(!$model->estado)
		{
			$error        = null;
			$tiposCampana = TipoCam::model()->findAll();
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Campana']))
			{
				$model->attributes = $_POST['Campana'];
				if($model->save())
					$this->redirect(array('index'));
			}

			$this->render('create',array(
				'model'        => $model,
				'tiposCampana' => $tiposCampana,
				'error'        => $error
			));
		}
		else
		{
			$this->redirect(array('index'));
		}
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
		//$dataProvider=new CActiveDataProvider('Campana');
		$criterio         = new CDbCriteria();
		$criterio->order  = 'feccre DESC';

		$campanas = Campana::model()->findAll($criterio);
		$this->render('index',array(
			//'dataProvider'=>$dataProvider,
			'campanas' => $campanas
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Campana('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Campana']))
			$model->attributes=$_GET['Campana'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Consulta los usuarios que contestaron determinada encuesta.
	 */
	public function actionUsuariosCampana($id_cam)
	{
		$model = new General('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['General']))
			$model->attributes = $_GET['General'];

		$criterio = new CDbCriteria;
		$criterio->addCondition('id_cam=:id_cam');
		$criterio->params += array(':id_cam' => $id_cam);
		
		$usuarios = CampanaUsuario::model()->findAll($criterio);
		$usuariosId = array_unique(array_map(function ($obj) { return $obj->id_usuc; }, $usuarios));
		
		$this->renderPartial('/formulario/_usuariosEncuesta',array(
			'model'      => $model,
			'usuariosId' => $usuariosId,
			'ajaxUrl'     => $this->createUrl('/campana/usuarioscampana', array('id_cam' => $id_cam))
		));
	}


	/**
	 *	 Devuelve un array con loss IDs de los usuarios que han respondido la encuesta.
	 **/
	protected function usuariosRespondida($id_for)
	{
		$criterio       = new CDbCriteria;
		$criterio->join = 'JOIN crmforpre ON t.id_fp = crmforpre.id_fp';
		
		//$criterio->distinct = true;
		$criterio->addCondition('id_for=:id_for');
		$criterio->params += array(':id_for' => $id_for);

		$respuestasEncuesta = Respuesta::model()->findAll($criterio);
		
		return array_unique(array_map(function ($obj) { return $obj->id_usur; }, $respuestasEncuesta));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Campana the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Campana::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Campana $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='campana-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	
}