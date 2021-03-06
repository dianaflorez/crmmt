<?php

class UsuarioPublicoObjetivoController extends Controller
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
			array('deny',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('*'),
				'users'=>array('*'),
			),
			array('deny', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('*'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'create', 'update', 'index', 'view'),
				'expression'=>'Yii::app()->user->checkAccess("CRMAdminEncargado")',
				
				//'users'=>array('admin'),
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
		$model=new UsuarioPublicoObjetivo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UsuarioPublicoObjetivo']))
		{
			$model->attributes=$_POST['UsuarioPublicoObjetivo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_upo));
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

		if(isset($_POST['UsuarioPublicoObjetivo']))
		{
			$model->attributes = $_POST['UsuarioPublicoObjetivo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_upo));
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
	public function actionDelete()
	{
		$id_po = isset($_POST['id_po']) ? $_POST['id_po'] : null;
		$id_usupo = isset($_POST['id_usupo']) ? $_POST['id_usupo'] : null;
		
		if($id_po && $id_usupo){
			$usuario = UsuarioPublicoObjetivo::model()->findByAttributes(array('id_po'=>$id_po,'id_usupo'=>$id_usupo));
			if($usuario && !$usuario->delete())
				throw new CHttpException(500, 'No se pudo borrar.');
		}else{
			throw new CHttpException(400, 'Petición fallida.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UsuarioPublicoObjetivo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UsuarioPublicoObjetivo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UsuarioPublicoObjetivo']))
			$model->attributes=$_GET['UsuarioPublicoObjetivo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UsuarioPublicoObjetivo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UsuarioPublicoObjetivo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UsuarioPublicoObjetivo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-publico-objetivo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
