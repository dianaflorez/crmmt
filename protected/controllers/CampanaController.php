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
				'actions'=>array('update', 'admin', 'delete', 'view', 'index', 'create', 'veamos', 'obtenerCorreos', 'enviar', 'enviarPrueba', 'duplicar'),
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
		if($model->estado)
			$this->redirect(array('index'));

		$error                = null;
		$errorPublicoObjetivo = null;
		$publicos             = PublicoObjetivo::model()->findAll();

		// Clase proporcionada por mailchimp para el uso de su API.
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
				$model  = $this->loadModel($id_cam);

				//$correosDesuscripcion = $this->obtenerCorreosDesuscripcion($_POST['Campana']['PublicoObjetivo']);
				//$this->desuscribirListaMailChimp($correosDesuscripcion);
			   
				if(isset($_POST['Campana']['PublicoObjetivo']))
				{
					$id_publico      = (int) $_POST['Campana']['PublicoObjetivo'];
					$publicoObjetivo = PublicoObjetivo::model()->findByPk($id_publico);
					
					if($publicoObjetivo === null)
					{
						$errorPublicoObjetivo = 'No ha seleccionado un público';
					}

					$correosSuscripcion = $this->obtenerCorreosSuscripcion($id_publico);
					
					if(count($correosSuscripcion) > 0)
					{
						if($this->suscribirListaMailChimp($correosSuscripcion))
						{
							//$mailChimp = new UtilidadesMailChimp;
							$id_segmento      = $this->crearSegmentoMailChimp($id_publico);
							$id_cam_mailchimp = $this->crearCampanaMailChimp($model,  $id_segmento);	
							
							if($id_cam_mailchimp != false)
							{
								// Enviar correo.
								$enviar = $MailChimp->call('campaigns/send', array(
									'cid' => $id_cam_mailchimp
								));
								
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
						}
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
					
					$correosSuscripcion = array();
					array_push($correosSuscripcion, array('email'=>array('email'=>$correoPrueba)));
				

					// Clase proporcionada por mailchimp para el uso de su API.
					Yii::import('application.extensions.mailchimp.Mailchimp');
					// Llave del API autorizada en el perfil.
					$MailChimp = new Mailchimp($this->api_key);
	            
				
			
					if(count($correosSuscripcion) > 0)
					{
						if($this->suscribirListaMailChimp($correosSuscripcion))
						{
							$segmento = $MailChimp->call('lists/static-segment-add', array(
								           	'id'   => 'a61184ea34',
								           	'name' => 'segmento_'.rand(1, 100000)
							));
														
							$correosSegmento = array();
							array_push($correosSegmento, array('email'=>$correoPrueba));
							
							$agregarUsuariosSegmento = $MailChimp->call('lists/static-segment-members-add', array(
							           	'id'     => 'a61184ea34',
							           	'seg_id' => $segmento['id'],
							           	'batch'  => $correosSegmento
							));

							$id_cam_mailchimp  = $this->crearCampanaMailChimp($model,  $segmento['id']);	
							
							if($id_cam_mailchimp)
							{
								// Enviar correo.
								$enviar = $MailChimp->call('campaigns/send', array(
									'cid' => $id_cam_mailchimp
								));
								
								
							}
						}
					}
				}
				catch(Exception $e)
				{
					throw new CHttpException(500,'La petición fallo.');
				}
			}
		}
		
	
	}




	protected function suscribirListaMailChimp($emails)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);

		try
		{
			$suscripcion = $MailChimp->call('lists/batch-subscribe', array(
			            'id'           => 'a61184ea34',
			            'batch'        => $emails,
			            'double_optin' => false,
			            'update_existing' => true
			));
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo suscribir');
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
				$campanaUsuario->id_usuc = $usuario->id_usu;
				$campanaUsuario->save();
			}
			$transaccion->commit();
		}
		catch(Exception $e)
		{
			$transaccion->rollback();
		}
	}

	protected function obtenerCorreosSuscripcion($id_po, $esSegmento = false)
	{
		$publicoObjetivo = PublicoObjetivo::model()->findByPk($id_po);
		if(!$publicoObjetivo)
			return array();
		
		$emails = array();
		foreach ($publicoObjetivo->usuarios as $usuario)
		{
			$cantidadEmails = count($usuario->general->emails);
			if($cantidadEmails > 0)
			{
				if($esSegmento)
				{
					array_push($emails, array('email'=>$usuario->general->emails[0]->direccion)); 
				}
				else
				{
					$merge_vars = array(
					    'FNAME' => $usuario->general->nombre1,
					    'LNAME' => $usuario->general->apellido1,
					);
					array_push($emails, array('email'=>array('email'=>$usuario->general->emails[0]->direccion), 'merge_vars'=>$merge_vars));
				}
				
			}
		}
		return $emails;
	}

	protected function crearSegmentoMailChimp($idPublico)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);

		try
		{
			$segmento = $MailChimp->call('lists/static-segment-add', array(
							           	'id'   => 'a61184ea34',
							           	'name' => 'segmento_'.rand(1, 100000)
			));
			
			$correosSegmento = $this->obtenerCorreosSuscripcion($idPublico, true);

			$agregarUsuariosSegmento = $MailChimp->call('lists/static-segment-members-add', array(
			           	'id'     => 'a61184ea34',
			           	'seg_id' => $segmento['id'],
			           	'batch'  => $correosSegmento
			));

			return $segmento['id'];
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo crear segmento');
		}
	}

	protected function eliminarSegmentoMailChimp($idSegmento)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);

		try
		{
			$segmentoEliminar = $MailChimp->call('lists/static-segment-del', array(
		           	'id'     => 'a61184ea34',
		           	'seg_id' => $idSegmento
			));
			
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo eliminar segmento');
		}
	}

	protected function crearCampanaMailChimp($campana, $idSegmento)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp($this->api_key);
		
		try
		{
			$campanaMailChimp = $MailChimp->call('campaigns/create', array(
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
								'std_preheader_content' => 'Estamos para ofrecerte los mejores articulos y promociones.',
								'imagen_subida'         => $campana->urlimage ? '<img src="'.$campana->urlimage.'" style="max-width:600px;>' : '', // '<img src="http://localhost:8888/crmmt/images/descarga.jpg" style="max-width:600px;>',
								'saludo'                => $campana->personalizada === true ? 'Hola *|TITLE:FNAME|*,' : '',
								'contenido'             => $campana->contenido,
								)
							),
							'segment_opts' => array('saved_segment_id' => $idSegmento, 'match'=> 'all', array('field' => 'static_segment', 'value' => $idSegmento,  'p' => 'eq'))
					));

			return $campanaMailChimp['id'];
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo crear la campaña');
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


	public function actionVeamos()
	{
		// // Clase proporcionada por mailchimp para el uso de su API.
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
}