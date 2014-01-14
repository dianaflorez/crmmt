<?php

class PreguntaController extends Controller
{
	public $id_for = null;
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
			'formulario + create' // filtro formulario para las acciones create
		);
	}

	/**
	 * Filtro para detectar que exista id_for porque la acción lo requiere.
	 * Al crear una pregunta debe siempre estar asociada a un formulario(encuesta).
	 */
	public function filterFormulario($filterChain)
	{
		$this->id_for = null;
        if (isset($_GET['id_for']))
            $this->id_for = $_GET['id_for'];
        else if (isset($_POST['id_for']))
            $this->id_for = $_POST['id_for'];
        if($this->id_for)
        	$filterChain->run();
        else
        	throw new CHttpException(404, "Opps estás en el lugar equivocado.");
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
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
		$model = new Pregunta;
		$error = null;
		$opciones = array();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pregunta']))
		{
			$model->attributes  = $_POST['Pregunta'];
			$p_opciones         = $_POST['Opcion']['Nuevas'];
			$p_tipo_pregunta    = $_POST['Tipo'];
			$p_opciones_abierta = $_POST['Opciones_abierta'];
			
			$tipos_pregunta     = TipoPregunta::model()->findAll();
			
			// Guardar las opciones nuevas antes de que ocurra algún error mientras se graba para que el usuario no pierda las opciones ingresadas.			
			foreach ($p_opciones as $texto) {
				array_push($opciones, array('id_op'=>'', 'txtop'=> $texto));
			}
			//$opciones = $p_opciones;

			foreach($tipos_pregunta as $tipo_pregunta)
			{
				if($p_tipo_pregunta === $tipo_pregunta->nombre)
				{
					$model->id_tp  = $tipo_pregunta->id_tp;
					$model->id_usu = Yii::app()->user->getState('usuid');
					
					$transaccion   = $model->dbConnection->beginTransaction();
					
					try
					{
						if($p_tipo_pregunta === 'abierta'){
							$tipo_pregunta_respuesta = TipoPreguntaRespuesta::model()->find('nombre = :nombre', array(':nombre'=>$p_opciones_abierta));
							$model->id_tpr           = $tipo_pregunta_respuesta->id_tpr;
							// TODO: Validar que existan retornados.
						}

						if($model->save())
						{
							$formulario_pregunta         = new FormularioPregunta;
							$formulario_pregunta->id_for = $this->id_for;//$idfor;
							$formulario_pregunta->id_pre = $model->id_pre;
							$formulario_pregunta->id_usu = Yii::app()->user->getState('usuid');
							
							if($formulario_pregunta->save())
							{
								if($p_tipo_pregunta != 'abierta')
								{
									foreach($p_opciones  as $texto_opcion)
									{
										$opcion_pregunta         = new OpcionPregunta;
										$opcion_pregunta->id_pre = $model->id_pre;
										$opcion_pregunta->txtop  = $texto_opcion;
										$opcion_pregunta->id_usu = Yii::app()->user->getState('usuid');

										if(!$opcion_pregunta->save())
										{
											throw new Exception('No se pudo asignar la opción a la pregunta.');
										}
									}
								}
								$transaccion->commit();
								$this->redirect(array('formulario/'));
							}
							else
							{
								throw new Exception('No se pudo asignar la pregunta a la encuesta.');
							}
						}
						else
						{
							throw new Exception('No se pudo guardar la pregunta.');
						}
					
					}
					catch(Exception $e)
					{
						$transaccion->rollback();
						$error = $e->getMessage();
						$model->setIsNewRecord(true);
					}

				}
			}
		}

		$this->render('create',array(
			'model' => $model,
			'error' => $error,
			'opciones' => $opciones
		));
	}

	// public function actionOpciones($id)
	// {
	// 	//if(isset($_POST['Consulta']))
	// 	//{
	// 		$model    = Pregunta::model()->findByPk($id);
	// 		$opciones = array();
	// 		if($model)
	// 			$opciones = $model->opciones;
	// 		//var_dump($opciones);
	// 		echo CJSON::encode($opciones);
	// 		Yii::app()->end();

	// 	//}		
	// }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model  = $this->loadModel($id);
		$error  = null;
		$opciones = $model->opciones; // Guarda las opciones de la pregunta, si hay errores de post mantiene guardadas las opciones nuevas entre cada petición POST.
		
		$id_fp  = $model->formularioPregunta->id_fp;
		$conteo = Respuesta::model()->count('id_fp=:id_fp', array('id_fp'=>$id_fp));
		
		if($conteo > 0)
		{
			throw new CHttpException(302,'No puede editar un formulario que ya ha sido respondido.');
		}

		$transaccion = $model->dbConnection->beginTransaction();
		
		try
		{
			if(isset($_POST['Pregunta']))
			{
				$model->attributes = $_POST['Pregunta'];
								
				//$opciones = $model->opciones;

				if(isset($_POST['Opcion']['Nuevas']))
				{
					$p_opciones_nuevas = $_POST['Opcion']['Nuevas'];

					// Guardar las opciones nuevas antes de que ocurra algún error mientras se graba para que el usuario no pierda las opciones ingresadas.
					foreach ($p_opciones_nuevas as $texto_opcion) 
					{
						array_push($opciones, array('id_op'=>'', 'txtop'=> $texto_opcion));
					}

					foreach($p_opciones_nuevas as $texto_opcion)
					{
						$opcion_pregunta         = new OpcionPregunta;
						$opcion_pregunta->id_pre = $model->id_pre;
						$opcion_pregunta->txtop  = $texto_opcion;
						$opcion_pregunta->id_usu = Yii::app()->user->getState('usuid');
						
						if(!$opcion_pregunta->save())
						{
							throw new Exception('No se pudo asignar la opción a la pregunta.');
						}
					}
				}


				if(isset($_POST['Opcion']['Existentes']))
				{
					$p_opciones = $_POST['Opcion']['Existentes'];

					foreach ($model->opciones as $opcion) 
					{
						if(array_key_exists($opcion->id_op, $p_opciones))
						{
							$opcion->txtop = $p_opciones[$opcion->id_op];
							
							if(!$opcion->save())
							{
								throw new Exception('No se pudo actualizar la opción.');
							}
						}
						else
						{
							$opcion->delete();
						}
					}
				}
				else
				{	
					foreach ($opciones as $opcion) 
					{
						$opcion->delete();
					}
				}


				if($model->save())
				{
					$transaccion->commit();
					$this->redirect(array('formulario/'));
				}
				else
				{
					throw new Exception('No se pudo actualizar la pregunta');
				}


			}
		}
		catch(Exception $e)
		{
			$transaccion->rollback();
			$error = $e->getMessage();
		}

		$this->render('update',array(
			'model' => $model,
			'error' => $error,
			'opciones' =>$opciones
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
		$dataProvider=new CActiveDataProvider('Pregunta');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pregunta('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pregunta']))
			$model->attributes=$_GET['Pregunta'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pregunta the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pregunta::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pregunta $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pregunta-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
