<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */

$this->breadcrumbs=array(
	'Sesion Chats'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SesionChat', 'url'=>array('index')),
	array('label'=>'Create SesionChat', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sesion-chat-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
	<div class="container">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			    'dataProvider'  => $model->search(),
				'filter'        => $model,
				'itemsCssClass' => 'table table-condensed table-hover',
				'htmlOptions'   => array('class' => 'table-responsive'),
				'columns'       => array(
			        'nombre_usuario',
			        array(            
			        	'name'   => 'contestada',
			        	'filter' => array(0 => 'No', 1 => 'Sí'),
			        	'value'  => '$data->contestada ? "Sí" : "No"',
			        ),
					array(            
			        	'name'   => 'terminada',
			        	'filter' => array(0 => 'No', 1 => 'Sí'),
			        	'value'  => '$data->terminada ? "Sí" : "No"',
			        ),

			        array(
			        	'header' => 'Responder',
			        	'value'  => '$data->terminada ? "" : CHtml::link("<i class=\"fa fa-phone\"></i>", Yii::app()->createUrl("sesionchat/responder/", array("id"=>$data->id)) ,array("class"=>"btn btn-primary activacion", "id"=>"btn_".$data->id, "data-toggle"=>"tooltip", "title"=>"Responder"))',
			        	'type'   => 'raw'
			        ),

			        array(
			        	'header' => 'Ver conversación',
			        	'value'  => '!$data->terminada ? "" : CHtml::link("<i class=\"fa fa-search\"></i>", Yii::app()->createUrl("sesionchat/view/", array("id"=>$data->id)) ,array("class"=>"btn btn-primary activacion", "id"=>"btn_".$data->id, "data-toggle"=>"tooltip", "title"=>"Ver"))',
			        	'type'   => 'raw'
			        ),
			        // array(
			        // 	'header' => 'Terminar',
			        // 	'value'  => '$data->terminada ? "" : CHtml::link("<i class=\"fa fa-phone\"></i>", Yii::app()->createUrl("sesionchat/terminarsesion/", array("id"=>$data->id)) ,array("class"=>"btn btn-primary activacion", "id"=>"btn_".$data->id, "data-toggle"=>"tooltip", "title"=>"Finalizar"))',
			        // 	'type'   => 'raw'
			        // ),       
			    ),
				'summaryText'   => 'Mostrando {start} - {end} de {count} resultados',
				'emptyText'     => 'No se encontraron registros.',
				'pager'         => array(
					'header'               => '',
					'firstPageLabel'       => 'Primera &lt;&lt;',
					'prevPageLabel'        => '&lt;',
					'nextPageLabel'        => '&gt;',
					'lastPageLabel'        => 'Última &gt;&gt;',
					'selectedPageCssClass' => 'active',
					'htmlOptions'          => array('class' => 'pagination')
				),
				'pagerCssClass' => 'paginacion',
		)); ?>
	</div>
</div>