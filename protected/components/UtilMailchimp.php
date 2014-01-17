<?php 
 
class UtilMailchimp extends CApplicationComponent
{
    public $api_key = '515d5d909933946cd00c0473675cf6b7-us3';
    //static static 

    protected function cargarMailchimp(){
        try
        {
            Yii::import('application.extensions.mailchimp.Mailchimp');
            return new Mailchimp($this->api_key);
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo cargar mailchimp.');
        }
    }

    public function crearSegmentoMailChimp($id_publico)
    {
        try
        {
            $MailChimp = $this->cargarMailchimp();
            $segmento = $MailChimp->call('lists/static-segment-add', array(
                                        'id'   => 'a61184ea34',
                                        'name' => 'segmento_'.rand(1, 100000)
            ));
            
            $correosSegmento = $this->obtenerCorreosSuscripcion($id_publico, true);

            $agregarUsuariosSegmento = $MailChimp->call('lists/static-segment-members-add', array(
                        'id'     => 'a61184ea34',
                        'seg_id' => $segmento['id'],
                        'batch'  => $correosSegmento
            ));

            return $segmento['id'];
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo crear segmento.');
        }
    }

    public function eliminarSegmentoMailChimp($id_segmento)
    {
        try
        {
            $MailChimp = $this->cargarMailchimp();
            $segmentoEliminar = $MailChimp->call('lists/static-segment-del', array(
                    'id'     => 'a61184ea34',
                    'seg_id' => $id_segmento
            ));
            
            return true;
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo eliminar segmento.');
        }
    }

    public function crearCampanaMailChimp($campana, $id_segmento)
    {
        try
        {
            $MailChimp = $this->cargarMailchimp();
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
                            'segment_opts' => array('saved_segment_id' => $id_segmento, 'match'=> 'all', array('field' => 'static_segment', 'value' => $id_segmento,  'p' => 'eq'))
                    ));

            return $campanaMailChimp['id'];
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo crear la campaña.');
        }
    }


    public function suscribirListaMailChimp($id_publico)
    {
        $emails = $this->obtenerCorreosSuscripcion($id_publico);
        if(count($emails) <= 0)
            return false;

        try
        {
            $MailChimp = $this->cargarMailchimp();
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
            throw new Exception('Oops, no se pudo suscribir.');
        }
    }



    public function obtenerCorreosSuscripcion($id_po, $es_segmento = false)
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
                if($es_segmento)
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



}