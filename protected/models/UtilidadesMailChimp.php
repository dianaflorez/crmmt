<?php 

class UtilidadesMailChimp{

	const $API_KEY = '515d5d909933946cd00c0473675cf6b7-us3';
	//static static 

	static function crearSegmentoMailChimp($id_statico)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp(self::$API_KEY);

		try
		{
			$segmento = $MailChimp->call('lists-segment-add', array(
							           	'id'   => 'a61184ea34',
							           	'name' => 'segmento_'.rand(1, 100000)
			));
			
			$correosSegmento = $this->obtenerCorreosSuscripcion($id_statico, true);

			$agregarUsuariosSegmento = $MailChimp->call('lists-segment-members-add', array(
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

	static function eliminarSegmentoMailChimp($id_segmento)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp(self::$API_KEY);

		try
		{
			$segmentoEliminar = $MailChimp->call('lists-segment-del', array(
			           	'id'   => 'a61184ea34',
			           	'seg_id' => $id_segmento
			));
			
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo eliminar segmento');
		}
	}

	static function crearCampanaMailChimp($campana, $id_segmento)
	{
		Yii::import('application.extensions.mailchimp.Mailchimp');
		$MailChimp = new Mailchimp(self::$API_KEY);
		
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
								'std_content00'         => $campana->contenido,
								)
							),
							'segment_opts' => array('saved_segment_id' => $id_segmento, 'match'=> 'all', array('field' => 'static_segment', 'value' => $id_segmento,  'p' => 'eq'))
					));
			return $campanaMailChimp['id'];
		}
		catch(Exception $e)
		{
			throw new Exception('Oops, no se pudo crear la campaña');
		}
	}

}