<?php

class SesionChatController extends Controller
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
				'actions'=>array('index','view', 'chat', 'asignarsala', 'create', 'guardarmensaje', 'admin', 'responder', 'terminarsesion', 'activa'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'expression' => 'Yii::app()->user->checkAccess("CRMAdminEncargado")',
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
		$criteria = new CDbCriteria;

		$criteria->addCondition('id_sesion =:id_sesion');
		$criteria->params += array(':id_sesion' => $id);

		$criteria->order = 'fecha ASC';	
		$dataProvider = new CActiveDataProvider('MensajeChat', array(
				'criteria'   => $criteria,
		   	 	'pagination' => array(
		        'pageSize' => 20,
		    ),
		));

		$model=$this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SesionChat;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		$id_sesion = Yii::app()->request->cookies->contains('id_sesion') ? Yii::app()->request->cookies['id_sesion']->value : '';
		if($id_sesion){
			$model = $this->loadModel($id_sesion);
			if($model->terminada){
				unset(Yii::app()->request->cookies['id_sesion']);
			}
		}

		if(isset($_POST['SesionChat']))
		{				
			if(!$id_sesion){
				$model->id = null;
				$model->attributes=$_POST['SesionChat'];
				if($model->save())
					$this->redirect(array('chat','id'=>$model->id));
			}else{
				$model=$this->loadModel($id_sesion);
				if($model->terminada){
					unset(Yii::app()->request->cookies['id_sesion']);
					$this->renderPartial('_form',array(
						'model'=>$model,
					));	
				}else{
					$this->redirect(array('chat','id'=>$model->id));
				}
			}				
		}else{	
			$this->render('create',array(
				'model'=>$model,
			));
		}
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

		if(isset($_POST['SesionChat']))
		{
			$model->attributes=$_POST['SesionChat'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('SesionChat');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionChat($id)
	{
		$model=$this->loadModel($id);

		$cookie = new CHttpCookie('id_sesion', $id);
		$cookie->expire = time() + 60 * 30; 
		$cookie->httpOnly = true;
		Yii::app()->request->cookies['id_sesion'] = $cookie;

		$this->renderPartial('chat',array(
			'model'=>$model,
		));
	}

	public function actionResponder($id)
	{
		$model = $this->loadModel($id);
		if($model->terminada)
			$this->redirect(array('admin'));
		$atiende = General::model()->findByPk(Yii::app()->user->getState('usuid'));

		$model->contestada = true;
		$model->usuario_atendio = $atiende->id;

		if($model->save())
		{
			$this->render('responder',array(
				'model'=>$model,
				'nombre'=> ucfirst(strtolower($atiende->nombre1))
			));
		}
		else
		{
			$this->redirect(array('admin'));
		}				
	}


	public function actionGuardarMensaje()
	{
		if(isset($_POST['id']) && isset($_POST['mensaje']) && isset($_POST['nombre_usuario']))
		{
			$id = (int) $_POST['id'];	
			$model=$this->loadModel($id);
			if(!$model->terminada)
			{
				$mensaje = new MensajeChat;
				$mensaje->id_sesion = $model->id;
				$mensaje->mensaje = $_POST['mensaje'];
				$mensaje->nombre_usuario = $_POST['nombre_usuario'];
				if(!$mensaje->save()){
					throw new CHttpException(500, "Error Processing Request");
				}		
			}
		}
	}

	public function actionAsignarSala(){
		if(isset($_POST['id']) && isset($_POST['id_room']) && isset($_POST['id_user']))
		{
			$id = (int) $_POST['id'];	
			$model=$this->loadModel($id);
			$model->id_room = $_POST['id_room'];
			$model->id_user = $_POST['id_user'];
			if(!$model->save())
				throw new CHttpException(500,'No se pudo asignar la sala.');

		}	
	}

	public function actionTerminarSesion($id)
	{		
		$model = $this->loadModel($id);
		$model->terminada = true;
		if(!$model->save())
		{
			throw new CHttpException(500, 'Error.');
		}	
	}

	public function actionActiva($id)
	{	
		//if(isset($_POST['peticion']) && $_POST['peticion']==='sesion-chat-form'){
			$model = $this->loadModel($id);
			

			if($model->terminada)
			{
				$this->renderPartial('_form',array(
						'model'=>$model,
					));
			}
		//}	
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SesionChat('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SesionChat']))
			$model->attributes=$_GET['SesionChat'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SesionChat the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SesionChat::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SesionChat $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sesion-chat-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}