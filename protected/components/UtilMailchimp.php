<?php 

/**
 * Clase para facilitar el uso del API de MailChimp ya que se necesita enviar correos masivos para Campañas
 * y para Formularios(Ligas de las encuestas).
 */

class UtilMailchimp extends CApplicationComponent
{
    // Llave del API de Mailchimo. Usar una diferente cuándo se haga deploy.
    protected $API_KEY = '515d5d909933946cd00c0473675cf6b7-us3';   
    // ID de la lista fija que usamos en MailChimp.
    protected $LISTA_ID = 'a61184ea34';
    // ID de la template creada en MailChimp.
    protected $TEMPLATE_ID = '47773';

    /**
     * Carga y devuelve un objeto para poder hacer uso del API de MailChimp.
     * @return Objeto MailChimp.
     */
    protected function cargarMailchimp(){
        try
        {
            Yii::import('application.extensions.mailchimp.Mailchimp');
            return new Mailchimp($this->API_KEY);
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo cargar mailchimp.');
        }
    }

     /**
     * Suscribe una lista de correos a una lista predefinida de MailChimp.
     * @param $MailChimp objeto para poder hacer las llamadas al API.
     * @param $correos lista de correos con formato para suscribir una LISTA MAILCHIMP. Tener en cuenta que el formato
     * para LISTA y SEGMENTO MAILCHIMP son DIFERENTES.
     * @return true si no hubo problemas al suscribir.
     */

    protected function suscribirLista($MailChimp, $correos)
    {
        if(count($correos) <= 0)
            return false;

        try
        {
            $suscripcion = $MailChimp->call('lists/batch-subscribe', array(
                        'id'              => $this->LISTA_ID,
                        'batch'           => $correos,
                        'double_optin'    => false, // No queremos enviarle correo de confirmación.
                        'update_existing' => true // Si es true actualiza personas que ya están en la lista en lugar de retornar error.
            ));
            return true;
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo suscribir.');
        }
    }

     /**
     * Crea un segmento con nombre aleatorio en una lista de MailChimp y agrega los usuarios especificados en el batch de correos.
     * La lista de correos contiene usuarios que DEBEN EXISTIR en la lista de mailchimp.
     * @param $MailChimp objeto para poder hacer las llamadas al API.
     * @param $correos lista de correos con formato para suscribir un SEGMENTO MAILCHIMP. Tener en cuenta que el formato
     * para LISTA y SEGMENTO MAILCHIMP son DIFERENTES.
     * @return el ID del segmento creado.
     */

    protected function crearSegmento($MailChimp, $correos)
    {
        try
        {
            $segmento = $MailChimp->call('lists/static-segment-add', array(
                                        'id'   => $this->LISTA_ID,
                                        'name' => round(microtime(true) * 1000)//'seg_'.rand(1, 100000).rand(1,10000) // Nombre aleatorio.
            ));
            
            $MailChimp->call('lists/static-segment-members-add', array(
                        'id'     => 'a61184ea34',
                        'seg_id' => $segmento['id'],
                        'batch'  => $correos
            ));

            return $segmento['id'];
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo crear segmento.');
        }
    }

    // protected function eliminarSegmento($MailChimp, $id_segmento)
    // {
    //     try
    //     {
    //         $segmentoEliminar = $MailChimp->call('lists/static-segment-del', array(
    //                 'id'     => 'a61184ea34',
    //                 'seg_id' => $id_segmento
    //         ));
            
    //         return true;
    //     }
    //     catch(Exception $e)
    //     {
    //         throw new Exception('Oops, no se pudo eliminar segmento.');
    //     }
    // }


    /**
     * Crea una campaña de MailChimp.
     * @param $MailChimp objeto para poder hacer las llamadas al API.
     * @param $campana es un objeto de tipo Campana de donde se extrae la información que necesitamos para llenar la plantilla.
     * @param $id_segmento el ID del segmento en particular al que se le enviará la campaña.
     * @return el ID de la campaña creada.
     */
    protected function crearCampana($MailChimp, $campana, $id_segmento)
    {
        try
        {
            $campanaMailChimp = $MailChimp->call('campaigns/create', array(
                            'type'    => 'regular',
                            'options' => array(
                                'list_id'     => $this->LISTA_ID, // Id de la lista a quien queremos enviar el correo.
                                'subject'     => $campana->asunto, //'Este es un correo de prueba desde Yii',
                                'from_email'  => 'ventas@marcasytendencias.com',
                                'from_name'   => 'Almacenes MT',
                                'to_name'     => 'No sé qué es exactamente', // Debería contener el nombre o algo que haga referencia a la persona que recibe el correo.
                                'template_id' => $this->TEMPLATE_ID, // Id de la plantilla a usar en este correo.
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

    /**
     * Envia una campaña de MailChimp. Suscribe una lista con usuarios, crea un segmento con los mismos, y crea una campaña
     * dirigida a ese segmento. Luego procede a enviarla.
     * @param $campana es un objeto de tipo Campana de donde se extrae la información que necesitamos para llenar la plantilla.
     * @param $correos estructura que contiene dos listas de correos para LISTA('para_lista') y otra para SEGMENTO('para_segmento').
     * Tener en cuenta que el formato para LISTA y SEGMENTO MAILCHIMP son DIFERENTES.
     */

    public function enviarCampana($campana, $correos)
    {
        $MailChimp = $this->cargarMailchimp();

        $this->suscribirLista($MailChimp, $correos['para_lista']);
        $id_segmento = $this->crearSegmento($MailChimp, $correos['para_segmento']);
        $id_campana = $this->crearCampana($MailChimp, $campana, $id_segmento);

        try
        {
            // Enviar campana mailchimp.
            $resultado = $MailChimp->call('campaigns/send', array(
                'cid' => $id_campana
            ));
        }
        catch(Exception $e)
        {
            throw new Exception('Oops, no se pudo enviar.');
        }
    }

    /**
     * Arma la estructura de correos que se usa para la suscripción a una LISTA y SEGMENTO. Ambas estructuras son DIFERENTES a
     * pesar de usar los mismos correos. Usar llaves de array 'para_lista' y 'para_segmento' para acceder a cada lista.
     * @param $id_po ID del publico objetivo del que necesitamos la lista de correo.
     * @return estructura de correos con dos listas.
     */
    public function obtenerCorreosSuscripcion($id_po)
    {
        $publicoObjetivo = PublicoObjetivo::model()->findByPk($id_po);
        if(!$publicoObjetivo)
            return array();
        
        $emails = array();
        $emails['para_segmento'] = array();
        $emails['para_lista'] = array();
        foreach ($publicoObjetivo->usuarios as $usuario)
        {
            $cantidadEmails = count($usuario->general->emails);
            if($cantidadEmails > 0)
            {
                $correo = $usuario->general->emails[0]->direccion;
                $merge_vars = array(
                        'FNAME' => $usuario->general->nombre1,
                        'LNAME' => $usuario->general->apellido1,
                        'IDUSUR' => $usuario->general->id
                    );
                array_push($emails['para_segmento'], array('email' => $correo)); 
                array_push($emails['para_lista'], array('email'=>array('email'=>$correo), 'merge_vars'=>$merge_vars));
            }
        }
        return $emails;
    }



}