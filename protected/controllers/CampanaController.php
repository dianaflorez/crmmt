<?php
//Yii::import('ext.runactions.components.ERunActions');

class CampanaController extends Controller
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
				'actions'=>array('update', 'admin', 'delete', 'view', 'index', 'create', 'veamos'),
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
		$error = null;
		

		// Clase proporcuinada por mailchimp para el uso de su API.
		Yii::import('application.extensions.mailchimp.Mailchimp');
		// Llave del API autorizada en el perfil.
		$api_key    = '515d5d909933946cd00c0473675cf6b7-us3';
		$MailChimp = new Mailchimp($api_key);

		$result = $MailChimp->call('lists/list', array(
		           /* 'id'                => $listid,
		            'email'             => array('email'=>$email),
		            'merge_vars'        => $merge_vars,
		            'double_optin'      => false,
		            'update_existing'   => true,
		            'replace_interests' => false,
		            'send_welcome'      => false,*/
		        ));

		        // $result = $MailChimp->call('campaigns/send', array(
		        // 'cid' => '61682076ff'
		        // ));

		//var_dump($result);
		       
		if(isset($_POST['Campana']))
		{
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation($model);

			$model->attributes = $_POST['Campana'];
			$model->feccre     = date('Y-m-d H:i:s', strtotime('Wed, 21 Jul 2010 00:28:50 GMT'));
			$model->id_usu     = Yii::app()->user->getState('usuid');
			 

			// Almacenar la imagen.
			$model->image = CUploadedFile::getInstance($model, 'image');
			//var_dump($model->image);
			if($model->image!=null)
			{
				$nombre = Yii::app()->basePath.'/../images/'.rand(1, 10000).$model->image;
				$model->image -> saveAs($nombre);
				$image = Yii::app()->image->load($nombre);   
			   	$image->resize(560, 100, Image::WIDTH);    
			   	$image->save();

			   	$model->urlimage = $nombre;

			 	// var_dump($model->validate());
			  //  	var_dump($model->hasErrors());
			  //  	var_dump($model->getErrors());
				if($model->save())
				{
					try
					{
					   // Crear una campana.
						$campana = $MailChimp->call('campaigns/create', array(
							'type'    => 'regular',
							'options' => array(
							'list_id'     => 'df822d066e', // Id de la lista a quien queremos enviar el correo.
							'subject'     => $model->asunto, //'Este es un correo de prueba desde Yii',
							'from_email'  => 'ventas@marcasytendencias.com',
							'from_name'   => 'Almacenes MT',
							'to_name'     => 'No sé qué es exactamente', // Debería contener el nombre o algo que haga referencia a la persona que recibe el correo.
							'template_id' => '47773', // Id de la plantilla a usar en este correo.
							'tracking'    => array(
							'opens'       => true,
							'html_clicks' => true,
							'text_clicks' => true
							),
							'title' => 'Titulo desde el API',
							),
							'content' => array(
							'sections' => array(
								// Secciones editables en la plantilla.
								'imagen_subida' => '<img src="'.Yii::app()->getBaseUrl(true).'/images/'.$model->image.'" style="max-width:600px;>', // '<img src="http://localhost:8888/crmmt/images/descarga.jpg" style="max-width:600px;>',
								'std_content00' => $model->contenido,
								)
							)
						));
						// Enviar correo.
						$enviar = $MailChimp->call('campaigns/send', array(
							'cid' => $campana['id']
						));

						//var_dump($enviar);

						// if(array_key_exists('error', $enviar)){
						// 	//var_dump('pailas');
						// 	$error = $enviar['error'];
						// }else{
						// //var_dump($model->getErrors());

						$this->redirect(array('view','id'=>$model->id_camp));
						// }
						   // $template = $MailChimp->call('templates/info', array(
						   // 'template_id' => '47773',
						   // 'type' => 'user'
						   // ));

						   //var_dump($template);
					}catch(Exception $e){
						//var_dump($e->getMessage());
						//var_dump($e->getCode());
						//$model->addError('asunto', $e->getMessage());
						
						$error = $e->getMessage();
						$model->delete();
						//$this->redirect(array('view','id'=>$model->id_camp));
					}
				}

				
			}
			else{
			 	$model->validate();
			}
		}

		$this->render('create',array(
			'model' => $model,
			'error' => $error
		));
	}

	public function actionVeamos()
	{
		// Clase proporcuinada por mailchimp para el uso de su API.
		Yii::import('application.extensions.mailchimp.Mailchimp');
		// Llave del API autorizada en el perfil.
		$api_key    = '515d5d909933946cd00c0473675cf6b7-us3';
		$MailChimp = new Mailchimp($api_key);
		$result = $MailChimp->call('lists/list', array(
		           /* 'id'                => $listid,
		            'email'             => array('email'=>$email),
		            'merge_vars'        => $merge_vars,
		            'double_optin'      => false,
		            'update_existing'   => true,
		            'replace_interests' => false,
		            'send_welcome'      => false,*/
		));

		$susc = $MailChimp->call('lists/batch-subscribe', array(
		            'id'                => 'a61184ea34',
		            'batch'             => array('email'=>array('email'=> 'jaoi55@gmail.com')),
		            // 'merge_vars'        => $merge_vars,
		            // 'double_optin'      => false,
		            // 'update_existing'   => true,
		            // 'replace_interests' => false,
		            // 'send_welcome'      => false,
		));
		var_dump($susc);

	}

	protected function convertirListaMailChimp($publicoObjetivo)
	{
		$result = $MailChimp->call('lists/list', array(
		           /* 'id'                => $listid,
		            'email'             => array('email'=>$email),
		            'merge_vars'        => $merge_vars,
		            'double_optin'      => false,
		            'update_existing'   => true,
		            'replace_interests' => false,
		            'send_welcome'      => false,*/
		));
		var_dump($result);

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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Campana']))
		{
			$model->attributes=$_POST['Campana'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_camp));
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
		$dataProvider=new CActiveDataProvider('Campana');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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