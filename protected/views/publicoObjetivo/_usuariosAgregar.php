<?php $this->widget('zii.widgets.grid.CGridView', array(
	    //'dataProvider'=>$usuarios->anotherDataProvider($usuariosRespondieronId),
		'dataProvider'  => $proveedorDatos,//$model->filtradoPorUsuarios($usuariosId),
		'filter'        => $model,
		'ajaxUrl'       => $ajaxUrl,
		'itemsCssClass' => 'table table-condensed table-hover',
		'htmlOptions'   => array('class' => 'table-responsive'),
		'rowHtmlOptionsExpression' => '["id" => $data->id, "class" => $data->presentepo('.$id_po.') ? "success" : ""]',
		'columns'       => array(
			array(
				'id' => 'usuarios',
				'class'=>'CCheckBoxColumn',
				'selectableRows'=>2,
				//'checked'=>'$data->mail != "No registra" && !$data->presentepo('.$id_po.') ? 1 : 0',
				'disabled'=>'$data->mail != "No registra" && !$data->presentepo('.$id_po.') ? 0 : 1',
				//'type'=>'$data->mail != "No registra" && !$data->presentepo('.$id_po.') ? "hidden" : "checkbox" ',
				//'htmlOptions' =>array('class'=>'{$data->id}')
				//'cssClassExpression'=>
			),
	        array(
	        	'name' => 'id_char',
	        	'headerHtmlOptions'=>array('class'=>'hidden-xs'),
	        	'htmlOptions'=>array('class'=>'hidden-xs'),
	        	 'filterHtmlOptions' => array('class'=>'hidden-xs'),
	        ),
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
	            'headerHtmlOptions'=>array('class'=>'hidden-xs'),
	           	'htmlOptions'=>array('class'=>'hidden-xs'),
	           	'filterHtmlOptions' => array('class'=>'hidden-xs'),
	            'header' => 'Fecha de nacimiento',
	            'value' => '$data->fechanacimientoformateado' ,
	        ),
	        array(            
	            'name'  => 'genero',
	            'filter'=> array(0 => 'Femenino', 1 => 'Masculino'),
	            //'filterHtmlOptions' => array('class'=>'input-lg'),
	            'value' => '$data->generoformateado' ,
	        ),
	        array(            
	            'name'  => 'ocupacion',
	            'value' => '$data->ocupacionformateado' ,
	        ),
	        array(            
	            'name'  => 'pais',
	            'value' => '$data->paisformateado' ,
	        ),
	        array(          
	            'name'  => 'estadoCivil',
	            'filter'=> CHtml::listData(EstadoCivil::model()->findAll(),'id_estado_civil','descripcion'),
	            'headerHtmlOptions'=>array('class'=>'hidden-xs'),
	           	'htmlOptions'=>array('class'=>'hidden-xs'),
	           	'filterHtmlOptions' => array('class'=>'hidden-xs'),
	            //'filterHtmlOptions' => array('class'=>'input-lg'),
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