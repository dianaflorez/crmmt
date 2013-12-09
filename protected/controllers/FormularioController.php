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
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('update','admin','delete','view','index', 'create', 'encuesta', 'revisarencuesta'),
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
		$model=new Formulario;

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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Formulario']))
		{
			$model->attributes=$_POST['Formulario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_for));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

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
					$transaccion->commit();
				}
				catch(Exception $e)
				{
					$transaccion->rollback();
					$error = $e->getMessage();
				}
			}
			else
			{
				throw new Exception('No existe respuesta para una de las preguntas.');
			}
			
		}

		$this->render('encuesta', array(
			'model'  => $model,
			'activa' => true
		));	
	}

	public function actionRevisarEncuesta($id)
	{
		$model = $this->loadModel($id);
		

		$this->render('encuesta', array(
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
		$dataProvider=new CActiveDataProvider('Formulario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
