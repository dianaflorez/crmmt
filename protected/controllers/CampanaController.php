<?php
//Yii::import('ext.runactions.components.ERunActions');

class CampanaController extends Controller
{
	protected $api_key = '515d5d909933946cd00c0473675cf6b7-us3';
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
				'actions'=>array('update', 'admin', 'delete', 'view', 'index', 'create', 'veamos', 'obtenerCorreos', 'enviar', 'duplicar'),
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
			//var_dump($model->image);
			if($model->image != null)
			{
				$nombre = rand(1, 10000).$model->image;
				$directorio = Yii::app()->basePath.'/../images/'.$nombre;
				$model->image -> saveAs($directorio);
				$image = Yii::app()->image->load($directorio);   
			   	$image->resize(560, 100, Image::WIDTH);    
			   	$image->save();

			   	//$model->urlimage = $nombre;
			   	$model->urlimage = Yii::app()->getBaseUrl(true).'/images/'.$nombre;
			 	// var_dump($model->validate());
			  //  	var_dump($model->hasErrors());
			  //  	var_dump($model->getErrors());
				if($model->save())
				{
					$this->redirect(array('index'));
					
				}

				
			}
			else{
			 	$model->validate();
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
		$error = null;
		$errorPublicoOjetivo = null;
		$publicos = PublicoObjetivo::model()->findAll();

		// Clase proporcuinada por mailchimp para el uso de su API.
		Yii::import('application.extensions.mailchimp.Mailchimp');
		// Llave del API autorizada en el perfil.
		$MailChimp = new Mailchimp($this->api_key);
		       
		if(isset($_POST['Campana']))
		{
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation($model);

			try
			{
				$id_cam = isset($_POST['Campana']['id_cam']) ? $_POST['Campana']['id_cam'] : null;
				$model = $this->loadModel($id_cam);

				$correosDesuscripcion = $this->obtenerCorreosDesuscripcion($_POST['Campana']['PublicoObjetivo']);
				$this->desuscribirLista($correosDesuscripcion);
			   
				if(isset($_POST['Campana']['PublicoObjetivo']))
				{
					$id_publico = (int) $_POST['Campana']['PublicoObjetivo'];
					$publicoObjetivo = PublicoObjetivo::model()->findByPk($id_publico);
					
					if($publicoObjetivo === null)
					{
						$errorPublicoOjetivo = 'No ha seleccionado un público';
					}


					$correosSuscripcion = $this->obtenerCorreosSuscripcion($_POST['Campana']['PublicoObjetivo']);
					if(count($correosSuscripcion) > 0)
					{
						if($this->suscribirLista($correosSuscripcion))
						{
							$id_campana = $this->crearMailChimpCampana($model);	
							if($id_campana != false)
							{
								// Enviar correo.
								// $enviar = $MailChimp->call('campaigns/send', array(
								// 	'cid' => $id_campana
								// ));
								$model->estado = true;
								if($model->save())
								{
									$this->redirect(array('index'));
								}
								else
								{
									var_dump($model->getErrors());
								}
								
							}
						}
					}
				}
				else
				{
					$errorPublicoOjetivo = 'No ha seleccionado un público';
				}
				
			}
			catch(Exception $e)
			{
				$error = $e->getMessage();
				//$model->delete();
				//$this->redirect(array('view','id'=>$model->id_cam));
			}
		
		}

		$this->render('enviar',array(
			'model'               => $model,
			'publicos'            => $publicos,
			'error'               => $error,
			'errorPublicoOjetivo' => $errorPublicoOjetivo
		));
	}

	public function actionVeamos()
	{
		// // Clase proporcuinada por mailchimp para el uso de su API.
		// Yii::import('application.extensions.mailchimp.Mailchimp');
		// // Llave del API autorizada en el perfil.
		// $api_key    = '515d5d909933946cd00c0473675cf6b7-us3';
		// $MailChimp = new Mailchimp($api_key);
		// $result = $MailChimp->call('lists/list', array(
		//             // 'id'                => $listid,
		//             // 'email'             => array('email'=>$email),
		//             // 'merge_vars'        => $merge_vars,
		//             // 'double_optin'      => false,
		//             // 'update_existing'   => true,
		//             // 'replace_interests' => false,
		//             // 'send_welcome'      => false,
		// ));

		// $susc = $MailChimp->call('lists/batch-subscribe', array(
		//             'id'                => 'a61184ea34',
		//             'batch'             => array(
		//             							//array('email'=> array('email'=> 'jaoi55@gmail.com')),
		//             							//array('email'=> array('email'=> 'dianaflorezbravo@gmail.com')),
		//             							array('email'=> array('email'=> 'nismbreath@gmail.com')),
		//             						),
		//              'double_optin' => false
		// ));

		// $usupres = $MailChimp->call('lists/members', array(
		//              'id' => 'a61184ea34',
		            
		          
		// ));
		// //var_dump($result);
		// var_dump($usupres);
		// //var_dump($usupres);
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);
		// $emails = $this->obtenerCorreosDesuscripcion(2);//$this->obtenerCorreosSuscripcion(2);
		// if(count($emails) > 0)
		// {
		// 	$suscripcion = $MailChimp->call('lists/batch-unsubscribe', array(
		// 	            'id'                => 'a61184ea34',
		// 	            'batch'             => $emails, 
		// 	            //'double_optin' => false

		// 	           'delete_member' => true
		// 	));
		// 	var_dump($suscripcion);
				
		// }

		//$emails = $this->obtenerCorreosDesuscripcion(2);//$this->obtenerCorreosSuscripcion(2);
		
			$suscripcion = $MailChimp->call('lists/members', array(
			            'id'                => 'a61184ea34',
			            //'batch'             => $emails, 
			            //'double_optin' => false

			           //'delete_member' => true
			));
			var_dump($suscripcion);
				
		

	}


	protected function suscribirLista($emails)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);

		try
		{
			$suscripcion = $MailChimp->call('lists/batch-subscribe', array(
			            'id'           => 'a61184ea34',
			            'batch'        => $emails,
			            'double_optin' => false
			));
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo suscribir');
		}
	}

	protected function desuscribirLista($emails)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);

		try
		{
			$suscripcion = $MailChimp->call('lists/batch-unsubscribe', array(
			            'id'                => 'a61184ea34',
			            'batch'             => $emails,
			           	'delete_member' => true
			));
			//var_dump($suscripcion);
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo desuscribir');
		}
	}


	protected function obtenerCorreosSuscripcion($id_po)
	{
		$publicoObjetivo = PublicoObjetivo::model()->findByPk($id_po);
		if(!$publicoObjetivo)
			return array();
		
		$emails = array();
		foreach ($publicoObjetivo->usuarios as $usuario) {
			$cantidadEmails = count($usuario->general->emails);
			if($cantidadEmails > 0)
				array_push($emails, array('email'=>array('email'=>$usuario->general->emails[0]->direccion)));
				
		}
		return $emails;

	}

	protected function obtenerCorreosDesuscripcion($id_po)
	{
		// $publicoObjetivo = PublicoObjetivo::model()->findByPk($id_po);
		// if(!$publicoObjetivo)
		// 	return array();
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);
		$emails = array();
		// foreach ($publicoObjetivo->usuarios as $usuario) {
		// 	$cantidadEmails = count($usuario->general->emails);
		// 	if($cantidadEmails > 0)
		// 		array_push($emails, array('email'=>$usuario->general->emails[0]->direccion));
				
		// }

		$suscripcion = $MailChimp->call('lists/members', array(
			            'id'                => 'a61184ea34',
			            //'batch'             => $emails, 
			            //'double_optin' => false

			           //'delete_member' => true
			));

		foreach ($suscripcion['data'] as $value) {
			array_push($emails, array('email'=> $value['email'])); 
		}
		return $emails;

	}

	protected function crearMailChimpCampana($campana)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);
		
		try
		{
			$campana = $MailChimp->call('campaigns/create', array(
							'type'    => 'regular',
							'options' => array(
								'list_id'     => 'a61184ea34', // Id de la lista a quien queremos enviar el correo.
								'subject'     => $campana->asunto, //'Este es un correo de prueba desde Yii',
								'from_email'  => 'ventas@marcasytendencias.com',
								'from_name'   => 'Almacenes MT',
								'to_name'     => 'No sé qué es exactamente', // Debería contener el nombre o algo que haga referencia a la persona que recibe el correo.
								'template_id' => '47773', // Id de la plantilla a usar en este correo.
								'title'       => 'Titulo desde el API',
								'tracking'    => array(
													'opens'       => true,
													'html_clicks' => true,
													'text_clicks' => true
												),
								
							),
							'content'  => array(
							'sections' => array(
								// Secciones editables en la plantilla.
								'imagen_subida' => '<img src="'.Yii::app()->getBaseUrl(true).'/images/'.$campana->image.'" style="max-width:600px;>', // '<img src="http://localhost:8888/crmmt/images/descarga.jpg" style="max-width:600px;>',
								'std_content00' => $campana->contenido,
								)
							)
					));
			return $campana['id'];
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo crear la campaña');
		}
	}



	// public function actionObtenerCorreos($id_po)
	// {
	// 	$publicoObjetivo = PublicoObjetivo::model()->findByPk($id_po);
	// 	if(!$publicoObjetivo)
	// 		throw new CHttpException(500, 'Error');
	// 	$emails = array();
	// 	foreach ($publicoObjetivo->usuarios as $usuario) {
	// 		$cantidadEmails = count($usuario->general->emails);
	// 		if($cantidadEmails > 0)
	// 			array_push($emails,array('email'=>array('email'=>$usuario->general->emails[0]->direccion)));
				
	// 	}
	// 	$this->renderJSON($emails);

	// }

	// protected function convertirListaMailChimp($publicoObjetivo)
	// {
	// 	$result = $MailChimp->call('lists/list', array(
	// 	            'id'                => $listid,
	// 	            'email'             => array('email'=>$email),
	// 	            'merge_vars'        => $merge_vars,
	// 	            'double_optin'      => false,
	// 	            'update_existing'   => true,
	// 	            'replace_interests' => false,
	// 	            'send_welcome'      => false,
	// 	));
	// 	var_dump($result);

	// }

	public function actionDuplicar($id)
	{
		$model=Campana::model()->findByPk($id);
		//$model = new Campana;
		//$model->attributes=$anotherModel->attributes;
		$model->id_cam = null;
		$model->estado = false;
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
		$model=$this->loadModel($id);
		
		if(!$model->estado)
		{
			$error = null;
			$tiposCampana = TipoCam::model()->findAll();
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Campana']))
			{
				$model->attributes=$_POST['Campana'];
				if($model->save())
					$this->redirect(array('index'));
			}

			$this->render('create',array(
				'model' => $model,
				'tiposCampana' => $tiposCampana,
				'error' => $error
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