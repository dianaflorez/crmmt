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
				'actions'=>array('index'),
				'users'=>array('?'),
			),
			array('allow',// allow authenticated user to perform 'view' actions
				'actions'=>array('view', 'exito'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('update','admin','delete','view','index', 'create', 'encuesta', 'revisarencuesta', 'resultado', 'resultadojson'),
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
		$model = new Formulario;

		$preguntas = array();
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Formulario']))
		{
			$model->attributes=$_POST['Formulario'];
			$model->id_usu     = Yii::app()->user->getState('usuid');

			if($model->save())
				$this->redirect(array('view','id'=>$model->id_for));
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

		if(isset($_POST['Formulario']))
		{
			$model->attributes = $_POST['Formulario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_for));
		}

		$this->render('update',array(
			'model'  => $model,
			//'activa' => false
		));
	}


	/**
	 * Genera la encuesta para ser diligenciada por el usuario.
	 * 
	*/
	public function actionEncuesta($id, $id_usur)
	{
		$model = $this->loadModel($id);
		$error = null;
		// if($model){
		// 	var_dump('Total preguntas '.count($model->preguntas));
		// 	foreach ($model->preguntas as $pregunta) {
		// 		var_dump($pregunta->txtpre);
		// 		var_dump($pregunta->id_tpr);
		// 		var_dump('Total opciones '.count($pregunta->opciones));
		// 		foreach ($pregunta->opciones as $opcion) {
		// 			var_dump($opcion->txtop);
		// 		}
		// 	}
		// }

		$usuario = General::model()->findByPk($id_usur);
		if(!$usuario)
			throw new CHttpException(404, "Opps el usuario no existe.");

		// if($this->encuestaRespondida($id, $id_usur))
		// 	$this->redirect(array('exito'));
		
		if(isset($_POST['Pregunta']))
		{
			// Validar número de respuestas que llegan por POST debe ser
			// igual al número de preguntas que tiene la encuesta.
			$preguntas = $model->preguntas;
			
			if(count($preguntas) === count($_POST['Pregunta']))
			{
				$transaccion = $model->dbConnection->beginTransaction();
				try
				{
					foreach ($preguntas as $pregunta) 
					{
						$opcion_post = $_POST['Pregunta'][$pregunta->id_pre];
						
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
											$respuesta          = new Respuesta;
											$respuesta->id_fp   = $pregunta->formularioPregunta->id_fp;
											$respuesta->id_op   = $opcion->id_op;
											$respuesta->id_usur = $usuario->id;
											$respuesta->id_usu  = Yii::app()->user->getState('usuid');
											
											if(!$respuesta->save())
											{
												throw new Exception('No se pudo guardar la respuesta.');
											}
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
												$respuesta          = new Respuesta;
												$respuesta->id_fp   = $pregunta->formularioPregunta->id_fp;
												$respuesta->id_op   = $opcion->id_op;
												$respuesta->id_usur = $usuario->id;
												$respuesta->id_usu  = Yii::app()->user->getState('usuid');
												
												if(!$respuesta->save())
												{
													throw new Exception('No se pudo guardar la respuesta.');
												}
											}
											
										}
									}
								}
								
							}
							elseif($pregunta->id_tp === 3) // Pregunta de repuesta abierta.
							{
								$respuesta          = new Respuesta;
								$respuesta->id_fp   = $pregunta->formularioPregunta->id_fp;
								$respuesta->txtres  = $opcion_post;
								$respuesta->id_usur = $usuario->id;
								$respuesta->id_usu  = Yii::app()->user->getState('usuid');
								
								if(!$respuesta->save())
								{
									throw new Exception('No se pudo guardar la respuesta.');
								}
							}
										
						}
						
					}
					$transaccion->commit(); // Si todo salio bien, procedemos a almacenar.
					$this->redirect(array('exito'));
				}
				catch(Exception $e)
				{
					$transaccion->rollback(); // Si alguna de las transacciones falla deshacemos todo.
					$error = $e->getMessage();
				}
			}
			else
			{
				throw new Exception('No existe respuesta para una de las preguntas.');
			}
			
		}
		$this->layout = 'column1';
		
		$this->render('encuesta', array(
			'model'  => $model,
			'activa' => true
		));	
	}


	public function actionResultado($id)
	{
		$model = $this->loadModel($id);
		$preguntas = $model->preguntas;
		//var_dump($model->respuestas);
		//header('Content-type: application/json');
		$objeto = array();
		foreach ($preguntas as $pregunta) {
			$temporal = array();
			$temporal['id_pre'] = $pregunta->id_pre;
			$temporal['pregunta'] = $pregunta->txtpre;
			$temporal['tipo'] = $pregunta->tipo->nombre;
			$respuestas = array();
			
			$resultados = array();
			$numeroRespuestas = count($pregunta->formularioPregunta->respuestas);
			foreach ($pregunta->opciones as $opcion)
			{
				$resultados['id_op'] = $opcion->id_op;
				$resultados['txtop'] = $opcion->txtop;
				$resultados['cantidad'] = Respuesta::model()->count('id_op=:id_op', array(':id_op' => $opcion->id_op));
				$resultados['porcentaje'] = $temporal['tipo'] === 'unica' ? round((100 * $resultados['cantidad']) / $numeroRespuestas, 2) : null;
				array_push($respuestas, $resultados);
			}
			
			$temporal['respuestas'] = $temporal['tipo'] === 'abierta' ? null : $respuestas;
			array_push($objeto, $temporal);
			
		}


		$criterio = new CDbCriteria;
		$criterio->join ='JOIN crmforpre ON t.id_fp = crmforpre.id_fp';
		$criterio->distinct = true;
		$criterio->addCondition('id_for=:id_for');
		$criterio->params += array(':id_for' => $id);

		$respuestasEncuesta = Respuesta::model()->findAll($criterio);
		
		$usuariosRespondieronId = array_unique(array_map(function ($obj) { return $obj->id_usur; }, $respuestasEncuesta));

		$this->render('resultado', array(
			'model'  => $model,
			'preguntas' => $preguntas,
			'datosReportes' => $objeto,
			'usuariosRespondieron' => count($usuariosRespondieronId)
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
			// $opciones = CJSON::decode(CJSON::encode($pregunta->opciones));
			// foreach ($pregunta->formularioPregunta->respuestas as $respuesta) {
			// 	$array = CJSON::decode(CJSON::encode($respuesta));
			// 	$array['opcion'] = $respuesta->opcion;
			// 	array_push($respuestas, $array);
			// }
			//if($temporal['tipo'] === 'abierta')
			$temporal['respuestas'] = $temporal['tipo'] === 'abierta' ? array_map(function ($obj) { return $obj->txtres; }, $pregunta->formularioPregunta->respuestas) : $respuestas;
			//$temporal['respuestas']['txtop'] = $pregunta->formularioPregunta->respuestas;
			array_push($objeto, $temporal);
			//var_dump($pregunta->respuestas);
			// $criterio = new CDbCriteria;
			// $criterio
			// $criterio->addCondition('')
			 //var_dump($pregunta->formularioPregunta->respuestas);
		}

		$criterio = new CDbCriteria;
		$criterio->join ='JOIN crmforpre ON t.id_fp = crmforpre.id_fp';
		$criterio->distinct = true;
		$criterio->addCondition('id_for=:id_for');
		$criterio->params += array(':id_for' => $id);

		$respuestasEncuesta = Respuesta::model()->findAll($criterio);
		
		$usuariosRespondieronId = array_unique(array_map(function ($obj) { return $obj->id_usur; }, $respuestasEncuesta));
		echo CJSON::encode($usuariosRespondieronId);
		Yii::app()->end();
	}

	protected function encuestaRespondida($id_for, $id_usur)
	{
		$criterio = new CDbCriteria;
		$criterio->join ='JOIN crmforpre ON t.id_fp = crmforpre.id_fp';
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

	public function actionExito()
	{
		$this->layout = 'column1';
		$this->render('exito', array());	
			
	}

	/**
	 * Genera una vista previa no editable de la encuesta.
	 * 
	*/
	public function actionRevisarEncuesta($id)
	{
		$model = $this->loadModel($id);
		
		$this->render('revisar', array(
			'model'  => $model,
			'activa' => false
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
		// $dataProvider=new CActiveDataProvider('Formulario');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));
		$criterio         = new CDbCriteria();
		$criterio->order  = 'feccre DESC';

		$formularios = Formulario::model()->findAll($criterio);
		$this->render('index',array(
			//'dataProvider'=>$dataProvider,
			'formularios' => $formularios
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Formulario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Formulario']))
			$model->attributes=$_GET['Formulario'];

		$this->render('admin',array(
			'model'=>$model,
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
		$model=Formulario::model()->findByPk($id);
		if($model===null)
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
