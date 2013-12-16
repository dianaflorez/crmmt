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
				'actions'=>array('index','view', 'agregarUsuarios'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'usuarios', 'agregarUsuarios'),
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
		$model=new PublicoObjetivo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PublicoObjetivo']))
		{
			$model->attributes=$_POST['PublicoObjetivo'];
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
		//$pagina          = (int) $pagina;
		$comenzar_desde    = ($pagina - 1) * $usuariosPorPagina;

		$criterio         = new CDbcriteria();
		$criterio->limit  = $usuariosPorPagina;
		$criterio->offset = $pagina;
		$criterio->order  = 'apellido1';

		

		if(isset($_POST['Usuario']))
		{
			
			//$identificacion = (isset($_POST['Usuario']['identificacion'])) ? $_POST['Usuario']['identificacion'] : '';
			//$criterio->addSearchCondition('id_char', $identificacion, true, 'OR');
			
			//$criterio->addCondition("id_char = '".$identificacion."'");
			// $criterio->params = array(':identificacion'=>$identificacion);

			//$criterio->condition = "id_char1 =:id_char";
			//$criterio->params = array(':id_char' => $identificacion);

			// $criterio->addCondition('id_char = :identificacion');
			// $criterio->params = array(':identificacion'=>$identificacion);

			$nombresCadena = (isset($_POST['Usuario']['nombre'])) ? $_POST['Usuario']['nombre'] : '';
			$nombres = explode(' ', $nombresCadena);
			foreach ($nombres as $nombre) {
					$criterio->addSearchCondition('nombre1', $nombre, true, 'OR', 'ILIKE');
					$criterio->addSearchCondition('nombre2', $nombre, true, 'OR', 'ILIKE');
					//$criterio->addSearchCondition('apellido1', $nombre, true, 'OR', 'ILIKE');
					//$criterio->addSearchCondition('apellido2', $nombre, true, 'OR', 'ILIKE');
			}

			$apellidosCadena = (isset($_POST['Usuario']['apellido'])) ? $_POST['Usuario']['apellido'] : '';
			$apellidos = explode(' ', $apellidosCadena);
			foreach ($apellidos as $apellido) {
					$criterio->addSearchCondition('apellido1', $apellido, true, 'OR', 'ILIKE');
					$criterio->addSearchCondition('apellido2', $apellido, true, 'OR', 'ILIKE');
			}

			if(isset($_POST['Usuario']['genero'])){
			$generoCadena = (isset($_POST['Usuario']['genero'])) ? $_POST['Usuario']['genero'] : '';
			$genero = $generoCadena ==='1' ? true : false;
			$criterio->join ='JOIN informacion_personal ON t.id = informacion_personal.id';
			//foreach ($apellidos as $apellido) {
					$criterio->addCondition('genero =:genero');
					$criterio->params = array(':genero' => $genero);
					//$criterio->addSearchCondition('apellido2', $apellido, true, 'OR', 'ILIKE');
			//}
}

		}


		//$usu = General::model()->find($criterio);
		$usuariosGeneral = General::model()->findAll($criterio);
		$total           = General::model()->count($criterio);
		var_dump($total);
		var_dump(count($usuariosGeneral));
		$paginas = new CPagination($total);
		$paginas->setPageSize($usuariosPorPagina);
		$paginas->applyLimit($criterio);

		$this->render('agregarUsuarios', array(
			'model'           => $model,
			'usuariosGeneral' => $usuariosGeneral,
			'pages'           => $paginas,
			'total' => $total,
			//'nombres' => $nombresCadena,
			//'apellidos' => $apellidosCadena
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
		$dataProvider=new CActiveDataProvider('PublicoObjetivo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
