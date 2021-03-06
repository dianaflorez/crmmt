<?php

class FormularioController extends Controller
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
			array('allow',
				'actions'    => array('encuesta'),
				'users'      => array('*'),
			),
			array('deny',// allow authenticated user to perform 'view' actions
				'actions'    => array('*'),
				'users'      => array('@'),
			),
			array('allow',
				'actions'    => array('update','admin','delete','view','index', 'create', 'enviar', 'resultado', 'resultadojson', 'usuariosencuesta', 'desactivar', 'mensaje'),
				'expression' => 'Yii::app()->user->checkAccess("CRMAdminEncargado")',
				// or
				// 'roles'   => array('Admin'),
			),
			array('deny',  // deny all users
				'users'      => array('*'),
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
		$model     = new Formulario;
		$preguntas = array();
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Formulario']))
		{
			$model->attributes = $_POST['Formulario'];
			$model->id_usu     = Yii::app()->user->getState('usuid');

			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(count($model->usuariosRespondidaFormulario()) > 0 || !$model->estado)
		{
			$mensaje = 'No puedes editar una encuesta que ya ha sido respondida o desactivada.';
			$this->redirigir('Oops.', $mensaje, 'danger', Yii::app()->createUrl('formulario/'), 'column2');
		}

		if(isset($_POST['Formulario']))
		{
			$model->attributes = $_POST['Formulario'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'  => $model
		));
	}


	/**
	 * Genera la encuesta para ser diligenciada por el usuario.
	 * 
	*/
	public function actionEncuesta($id, $username)
	{
		$model = $this->loadModel($id);
		$error = null;
		
		$usuario = Usuweb::model()->findByAttributes(array('login'=>$username));
		if(!$usuario)
			throw new CHttpException(404, "Opps el usuario no existe.");

		if($this->encuestaRespondida($id, $usuario->id_usuario) || !$model->estado)
		{	
			$mensaje = 'Tus respuestas nos ayudan a ofrecerte un mejor servicio. Gracias por confiar en nosotros.';
			$this->redirigir('¡Gracias!', $mensaje, 'success', 'http://www.almacenesmt.com', 'column1', 'fa-smile-o');
		}

		if(isset($_POST['Pregunta']))
		{
			// Validar número de respuestas que llegan por POST debe ser
			// igual al número de preguntas que tiene la encuesta.
			$preguntas = $model->preguntas;
			
			// if(count($preguntas) === count($_POST['Pregunta']))
			// {
				$transaccion = $model->dbConnection->beginTransaction();
				try
				{
					foreach ($preguntas as $pregunta) 
					{
						$opcion_post = isset($_POST['Pregunta'][$pregunta->id_pre]) ? $_POST['Pregunta'][$pregunta->id_pre] : null;
						
						if(isset($opcion_post))
						{
							if($pregunta->id_tpr === null)
							{
								if($pregunta->id_tp === 1) // Pregunta de respuesta única.
								{
									foreach ($pregunta->opciones as $llave => $opcion)
									{
										if(''.$opcion->id_op === $opcion_post)
										{
											$this->guardarRespuesta($pregunta->formularioPregunta->id_fp, $opcion->id_op, $usuario->general->id);
										}
									}
								}
								elseif($pregunta->id_tp === 2) // Pregunta de respuesta multiple.
								{
									$opciones = $pregunta->opciones;
								
									foreach ($opcion_post as $op_p) 
									{
										foreach ($opciones as $opcion) 
										{	
											if(''.$opcion->id_op === $op_p)
											{
												$this->guardarRespuesta($pregunta->formularioPregunta->id_fp, $opcion->id_op, $usuario->general->id);
											}
											
										}
									}
								}
								
							}
							elseif($pregunta->id_tp === 3) // Pregunta de repuesta abierta.
							{
								$this->guardarRespuesta($pregunta->formularioPregunta->id_fp, null, $usuario->general->id, $opcion_post);
							}
										
						}
						
					}
					$transaccion->commit(); // Si todo salio bien, procedemos a almacenar.
					$mensaje = 'Tus respuestas nos ayudan a ofrecerte un mejor servicio. Gracias por confiar en nosotros.';
					$this->redirigir('¡Gracias!', $mensaje, 'success', 'http://www.almacenesmt.com', 'column1', 'fa-smile-o');
				}
				catch(Exception $e)
				{
					$transaccion->rollback(); // Si alguna de las transacciones falla deshacemos todo.
					$error = $e->getMessage();
				}
			// }
			// else
			// {
			// 	throw new CHttpException(400,'No existe respuesta para una de las preguntas.');
			// }
			
		}
		$this->layout = 'column1';
		
		$this->render('_encuesta', array(
			'model'  => $model,
			'activa' => true,
			'error' => $error
		));	
	}


	protected function guardarRespuesta($id_fp, $id_op, $id_usur, $texto = null)
	{		
		$respuesta          = new Respuesta;
		$respuesta->id_fp   = $id_fp;
		$respuesta->id_usur = $id_usur;
		//$respuesta->id_usu  = Yii::app()->user->getState('usuid');

		if($id_op)
			$respuesta->id_op   = $id_op;
		if($texto)
			$respuesta->txtres  = $texto;
		
		if(!$respuesta->save())
		{
			throw new Exception('No se pudo guardar la respuesta.');
		}
	}

	public function actionDesactivar($id)
	{
		$model = $this->loadModel($id);
		$model->estado = false;
		if($model->save())
			$this->redirect(array('index'));
	}

	public function actionResultado($id)
	{
		$model = $this->loadModel($id);
		$preguntas = $model->preguntas;
		//var_dump($model->respuestas);
		//header('Content-type: application/json');
		$opciones = array();
		$objeto = array();
		foreach ($preguntas as $pregunta) {
			$temporal             = array();
			$temporal['id_pre']   = $pregunta->id_pre;
			$temporal['pregunta'] = $pregunta->txtpre;
			$temporal['tipo']     = $pregunta->tipo->nombre;
			
			$respuestas = array();
			$resultados = array();
			
			$numeroRespuestas = count($pregunta->formularioPregunta->respuestas);
			$con = 1;
			foreach ($pregunta->opciones as $opcion)
			{
				$cantidad = Respuesta::model()->count('id_op=:id_op', array(':id_op' => $opcion->id_op));
				$resultados[$opcion->id_op] = $cantidad;
				$resultados['numero']     = $con;
				$resultados['txtop']      = $opcion->txtop;
				$resultados['cantidad']   = $cantidad;//Respuesta::model()->count('id_op=:id_op', array(':id_op' => $opcion->id_op));
				$resultados['porcentaje'] = $temporal['tipo'] === 'unica' && $numeroRespuestas > 0 ? round((100 * $resultados['cantidad']) / $numeroRespuestas, 2) : null;
				array_push($respuestas, $resultados);
				$con++;
			}
			$opciones[$pregunta->id_pre] = $resultados;
			//array_push($opciones[$pregunta->id_pre], $resultados);
			
			$temporal['respuestas'] = $temporal['tipo'] === 'abierta' ? null : $respuestas;
			array_push($objeto, $temporal);
			
		}
		
		$usuariosId = $this->usuariosRespondida($id);
		
		$this->render('resultado', array(
			'model'         => $model,
			'preguntas'     => $preguntas,
			'datosReportes' => $objeto,
			'usuariosId'    => $usuariosId,
			'usuarios'      => new General,
			'opciones' => $opciones
		));	
	}

	public function actionResultadoJson($id)
	{
		$model = $this->loadModel($id);
		$preguntas = $model->preguntas;
		//var_dump($model->respuestas);
		header('Content-type: application/json');
		$objeto = array();
		foreach ($preguntas as $pregunta) 
		{
			$temporal = array();
			$temporal['id_pre'] = $pregunta->id_pre;
			$temporal['pregunta'] = $pregunta->txtpre;
			$temporal['tipo'] = $pregunta->tipo->nombre;
			$respuestas = array();
			//$gola = $pregunta->formularioPregunta->respuestas;

			$resultados = array();
			$numeroRespuestas = count($pregunta->formularioPregunta->respuestas);
			foreach ($pregunta->opciones as $opcion) {
				$resultados['id_op'] = $opcion->id_op;
				$resultados['txtop'] = $opcion->txtop;
				$resultados['cantidad'] = Respuesta::model()->count('id_op=:id_op', array(':id_op' => $opcion->id_op));
				$resultados['porcentaje'] = $temporal['tipo'] === 'unica' ? (100 * $resultados['cantidad']) / $numeroRespuestas : null;
				array_push($respuestas, $resultados);
			}
			function devolverTxt($obj) { return $obj->txtres; };
			$temporal['respuestas'] = $temporal['tipo'] === 'abierta' ? array_map('devolverTxt', $pregunta->formularioPregunta->respuestas) : $respuestas;
			array_push($objeto, $temporal);
			
		}

		$criterio = new CDbCriteria;
		$criterio->join ='JOIN crmforpre ON t.id_fp = crmforpre.id_fp';
		$criterio->distinct = true;
		$criterio->addCondition('id_for=:id_for');
		$criterio->params += array(':id_for' => $id);

		$respuestasEncuesta = Respuesta::model()->findAll($criterio);

		function devolverId($obj)
		{
			return $obj->id_usur;
		};
		
		$usuariosRespondieronId = array_unique(array_map('devolverId', $respuestasEncuesta));
		echo CJSON::encode($usuariosRespondieronId);
		Yii::app()->end();
	}

	/**
	 *	Verifica si la encuesta ha sido respondida o no por determinado usuario.
	 *	
	 **/
	protected function encuestaRespondida($id_for, $id_usur)
	{
		$criterio       = new CDbCriteria;
		$criterio->join = 'JOIN crmforpre ON t.id_fp = crmforpre.id_fp';
		
		$criterio->addCondition('id_for =:id_for');
		$criterio->params += array(':id_for' => $id_for);
		$criterio->addCondition('id_usur =:id_usur');
		$criterio->params += array(':id_usur' => $id_usur);

		$respuestasExistentes = Respuesta::model()->count($criterio);
		if($respuestasExistentes > 0)
			return true;
		else
			return false;
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
		
		function devolverId($obj)
		{
			return $obj->id_usur;
		};

		return array_unique(array_map('devolverId', $respuestasEncuesta));
	}


	/**
	 * 	Genera una vista previa no editable de la encuesta.
	 **/
	public function actionEnviar($id)
	{
		$model                = $this->loadModel($id);
		$campana              = new Campana;
		$publicos             = PublicoObjetivo::model()->findAll();
		$error                = null;
		$errorPublicoObjetivo = null;
		$contenidoOriginal    = null; // Graba el contenido de la campaña sin el vínculo de la encuesta. Si hay una excepción puede ser restaurado para ser mostrado en la forma.

		if(!$model->estado){
			$mensaje = 'Esta encuesta ya ha sido desactivada. No se puede agregarle preguntas.';
			$this->redirigir('Oops.', $mensaje, 'danger', Yii::app()->createUrl('formulario/'), 'column2');
		}

		if(count($model->preguntas) <= 0){
			$mensaje = 'No has agregado ninguna pregunta a la encuesta.';
			$this->redirigir('Oops.', $mensaje, 'danger', Yii::app()->createUrl('pregunta/create', array('id_for'=>$id)), 'column2');
		}

		if(isset($_POST['Campana']))
		{
			try
			{
				$campana->attributes = $_POST['Campana'];
				if($campana->asunto && $campana->contenido)
				{

					if(isset($_POST['Campana']['PublicoObjetivo']) && $_POST['Campana']['PublicoObjetivo'])
					{
						$id_publico = (int) $_POST['Campana']['PublicoObjetivo'];
						$contenidoOriginal = $campana->contenido;
						$correos    = Yii::app()->utilmailchimp->obtenerCorreosSuscripcion($id_publico);				
						
						if(count($correos['para_lista']) > 0)
						{
							$url                    = Yii::app()->getBaseUrl(true).'/formulario/encuesta/'.$id.'?username=*|LOGIN|*';
							$campana->personalizada = true;
							$campana->contenido     = $campana->contenido.' Puedes responder '.CHtml::link('aquí', $url);
							Yii::app()->utilmailchimp->enviarCampana($campana, $correos);

							$mensaje = 'Felicitaciones, su encuesta ha sido enviada correctamente. En unos minutos los correos empezarán a llegar a sus clientes.';
							$this->redirigir('¡Encuesta enviada!', $mensaje, 'success', Yii::app()->createUrl('formulario/'), 'column2', 'fa-rocket');
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
				else
				{
					$campana->validate();
				}
				
			}
			catch(Exception $e)
			{
				$campana->contenido = $contenidoOriginal;
				$error = $e->getMessage();
			}
		}

		$this->render('enviar', array(
			'model'                => $model,
			'campana'              => $campana,
			'activa'               => false,
			'publicos'             => $publicos,
			'error'                => $error,
			'errorPublicoObjetivo' => $errorPublicoObjetivo
		));	
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
		$criterio         = new CDbCriteria();
		$criterio->order  = 'feccre DESC';

		$formularios = Formulario::model()->findAll($criterio);
		$this->render('index',array(
			'formularios' => $formularios
		));
	}

	/**
	 * Consulta los usuarios que contestaron determinada encuesta.
	 */
	public function actionUsuariosEncuesta($id_for)
	{
		$model = new General('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['General']))
			$model->attributes = $_GET['General'];
		
		$usuariosId = $this->usuariosRespondida($id_for);;

		$this->render('_usuariosEncuesta',array(
			'model'      => $model,
			'usuariosId' => $usuariosId,
			'ajaxUrl'     => $this->createUrl('/formulario/usuariosencuesta', array('id_for' => $id_for))
		));
	}

	public function actionAdmin()
	{
		$model = new Formulario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Formulario']))
			$model->attributes = $_GET['Formulario'];

		$this->render('admin',array(
			'model' => $model,
		));
	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Formulario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Formulario::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Formulario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='formulario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
