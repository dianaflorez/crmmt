<?php $this->widget('zii.widgets.grid.CGridView', array(
	    //'dataProvider'=>$usuarios->anotherDataProvider($usuariosRespondieronId),
		'dataProvider'  => $model->filtradoPorUsuarios(),//$model->filtradoPorUsuarios($usuariosId),
		'filter'        => $model,
		'ajaxUrl'       => $ajaxUrl,
		'itemsCssClass' => 'table table-condensed table-hover',
		'htmlOptions'   => array('id'=> 'todos', 'class' => 'table-responsive'),
		'rowHtmlOptionsExpression' => '["id" => $data->id, "class" => $data->presentepo('.$id_po.') ? "success" : ""]',
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
	            //'name'  => 'fecha_nacimiento',
	            'header' => 'Fecha de nacimiento',
	            //'filter'=> array(1=>'Masculino', 0=>'Femenino'),
	            'value' => '$data->fechanacimientoformateado' ,
	        ),
	        array(            
	            'name'  => 'genero',
	            'filter'=> array(0 => 'Femenino', 1 => 'Masculino'),
	            'value' => '$data->generoformateado' ,
	        ),
	        array(            
	            'name'  => 'ocupacion',
	            'value' => '$data->ocupacionformateado' ,
	        ),
	          array(            
	            'name'  => 'estadoCivil',
	            'filter'=> CHtml::listData(EstadoCivil::model()->findAll(),'id_estado_civil','descripcion'),
	            'value' => '$data->estadocivilformateado' ,
	        ),
	        array(
	        	'header' => 'Agregar',
	        	'value' => '$data->mail != "No registra" && !$data->presentepo('.$id_po.') ? CHtml::link("<i class=\"fa fa-plus fa-lg\"></i>", null ,array("class"=>"btn btn-primary activacion", "id"=>"btn_".$data->id, "data-toggle"=>"tooltip", "title"=>"Activar")) : "" ',
	        	'type' => 'raw'
	        ),
	        // array(
	        // 	'header' => 'Pertenece',
	        // 	'value' => '$data->presentepo('.$id_po.') ? "Sí" : "No"'
	        // )
	        // array(
         //                'class'=>'CButtonColumn',
         //                'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
         //                          'onchange'=>"$.fn.yiiGridView.update('file-grid',{ data:{pageSize: $(this).val() }})",
         //            )),
         //    ),
	        
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