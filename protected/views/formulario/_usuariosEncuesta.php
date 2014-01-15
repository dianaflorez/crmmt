<?php $this->widget('zii.widgets.grid.CGridView', array(
	    //'dataProvider'=>$usuarios->anotherDataProvider($usuariosRespondieronId),
	    'dataProvider'=>$model->filtradoPorUsuarios($usuariosId),
	    'filter' =>$model,
	    'ajaxUrl' => $this->createUrl('/formulario/usuariosencuesta', array('id_for'=>$id_for)),
	    'itemsCssClass' => 'table table-condensed table-hover',
		'htmlOptions' => array('class' => 'table-responsive'),
	    'columns'=>array(
	        'id_char',          // display the 'title' attribute
	        array(            // display 'create_time' using an expression
	            'name'=>'nombres',
	            'value'=>'ucfirst(strtolower($data->nombre1))." ".ucfirst(strtolower($data->nombre2))' ,
	        ),
	        array(            // display 'create_time' using an expression
	            'name'=>'apellidos',
	            'value'=>'ucfirst(strtolower($data->apellido1))." ".ucfirst(strtolower($data->apellido2))' ,
	        ),
	        array(            // display 'create_time' using an expression
	            'name'=>'correo',
	            'value'=>'$data->mail' ,
	            //'value' => ''
	        ),
	        
	      // 'mail',
	        
	        // array(            // display 'create_time' using an expression
	        //     'name'=>'Emaila',
	        //     'header' =>'aaa',
	        //     'value'=>'$data->correo' ,
	        // ),
	        // 'category.name',  // display the 'name' attribute of the 'category' relation
	        // 'content:html',   // display the 'content' attribute as purified HTML
	        // array(            // display 'create_time' using an expression
	        //     'name'=>'create_time',
	        //     'value'=>'date("M j, Y", $data->create_time)',
	        // ),
	        // array(            // display 'author.username' using an expression
	        //     'name'=>'authorName',
	        //     'value'=>'$data->author->username',
	        // ),
	        // array(            // display a column with "view", "update" and "delete" buttons
	        //     'class'=>'CButtonColumn',
	        // ),
	    ),
		'summaryText' => 'Mostrando {start} - {end} de {count} resultados ',
		'pager' => array(
			'header'=> '',
	        'firstPageLabel' => 'Primera &lt;&lt;',
			'prevPageLabel' => '&lt;',
			'nextPageLabel' => '&gt;',
			'lastPageLabel' => 'Última &gt;&gt;',
			'htmlOptions'=>array('class'=>'pagination')
		),
		'pagerCssClass' => 'a', 
		//'template' =>array('summary'=> 'ggg')
	)); ?>