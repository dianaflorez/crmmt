<?php $this->widget('zii.widgets.grid.CGridView', array(
	    //'dataProvider'=>$usuarios->anotherDataProvider($usuariosRespondieronId),
		'dataProvider'  => $model->filtradoPorUsuarios($usuariosId),
		'filter'        => $model,
		'ajaxUrl'       => $ajaxUrl,
		'itemsCssClass' => 'table table-condensed table-hover',
		'htmlOptions'   => array('class' => 'table-responsive'),
		'rowHtmlOptionsExpression' => '["id" => $data->id, "data-idpo"=>"'.$id_po.'"]',
		'columns'       => array(
	        'id_char',         
	        array(            
	            'name'  => 'nombres',
	            'value' => '$data->nombresUnidos' ,
	        ),
	        array(            
	            'name'  => 'apellidos',
	            'value' => '$data->apellidosUnidos' ,
	        ),
	        array(            
	            'name'  => 'correo',
	            'value' => '$data->mail' ,
	        ),
	        array(            
	            'name'  => 'genero',
	            'filter'=> array(0 => 'Femenino', 1 => 'Masculino'),
	            'value' => '$data->generoformateado' ,
	        ),
	        // array(            
	        //     'name'  => 'ocupacion',
	        //     'value' => '$data->ocupacionformateado' ,
	        // ),
	        array(            
	            'name'  => 'pais',
	            'value' => '$data->paisformateado' ,
	        ),
	        array(
	        	'header' => 'Quitar',
	        	'value' => 'CHtml::link("<i class=\"fa fa-times fa-lg\"></i>", null ,array("class"=>"btn btn-primary activacion", "id"=>"btn_".$data->id, "data-toggle"=>"tooltip", "title"=>"Activar"))',
	        	'type' => 'raw'
	        ),
	        // array(          
	        //     'name'  => 'estadoCivil',
	        //     'filter'=> CHtml::listData(EstadoCivil::model()->findAll(),'id_estado_civil','descripcion'),
	        //     'headerHtmlOptions'=>array('class'=>'hidden-xs'),
	        //    	'htmlOptions'=>array('class'=>'hidden-xs'),
	        //    	'filterHtmlOptions' => array('class'=>'hidden-xs'),
	        //     'value' => '$data->estadocivilformateado' ,
	        // ),
	    ),
		'summaryText' => 'Mostrando {start} - {end} de {count} resultados',
		'emptyText' => 'No se encontraron registros.',
		'pager'       => array(
			'header'         => '',
			'firstPageLabel' => 'Primera &lt;&lt;',
			'prevPageLabel'  => '&lt;',
			'nextPageLabel'  => '&gt;',
			'lastPageLabel'  => 'Última &gt;&gt;',
			'htmlOptions'    => array('class'=>'pagination')
		),
		'pagerCssClass' => 'pagerClass',
)); ?>