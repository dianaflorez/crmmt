<?php $this->widget('zii.widgets.grid.CGridView', array(
	    //'dataProvider'=>$usuarios->anotherDataProvider($usuariosRespondieronId),
		'dataProvider'  => $model->filtradoPorUsuarios($usuariosId),
		'filter'        => $model,
		'ajaxUrl'       => $ajaxUrl,
		'itemsCssClass' => 'table table-condensed table-hover',
		'htmlOptions'   => array('class' => 'table-responsive'),
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