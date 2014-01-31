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

<!-- <h1>Manage Sesion Chats</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> -->

<?php ///echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!-- <div class="search-form" style="display:none"> -->
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); ?>
</div><!-- search-form -->

<?php //$this->widget('zii.widgets.grid.CGridView', array(
// 	'id'=>'sesion-chat-grid',
// 	'dataProvider'=>$model->search(),
// 	'filter'=>$model,
// 	'columns'=>array(
// 		'id',
// 		'nombreusuario',
// 		'atendida',
// 		array(
// 			'class'=>'CButtonColumn',
// 		),
// 	),
// )); ?>
<div class="row">
	<div class="container">

<?php $this->widget('zii.widgets.grid.CGridView', array(
	    //'dataProvider'=>$usuarios->anotherDataProvider($usuariosRespondieronId),
		'dataProvider'  => $model->search(),
		'filter'        => $model,
		//'ajaxUrl'       => $ajaxUrl,
		'itemsCssClass' => 'table table-condensed table-hover',
		'htmlOptions'   => array('class' => 'table-responsive'),
		//'rowHtmlOptionsExpression' => '["id" => $data->id, "data-idpo"=>"'.$id_po.'"]',
		'columns'       => array(
	        'nombre_usuario',
	        //'atendida',        
	        array(            
	        	'name'   => 'atendida',
	        	'filter' => array(0 => 'No', 1 => 'Sí'),
	        	'value'  => '$data->atendida ? "Sí" : "No"',
	        ),

	        array(
	        	'header' => 'Atender',
	        	'value'  => 'CHtml::link("<i class=\"fa fa-phone\"></i>", Yii::app()->createUrl("sesionchat/responder/", array("id"=>$data->id)) ,array("class"=>"btn btn-primary activacion", "id"=>"btn_".$data->id, "data-toggle"=>"tooltip", "title"=>"Activar"))',
	        	'type'   => 'raw'
	        ),

	        // array(            
	        // 	'name'   => 'apellidos',
	        // 	'value'  => '$data->apellidosUnidos' ,
	        // ),
	        // array(            
	        // 	'name'   => 'correo',
	        // 	'value'  => '$data->mail' ,
	        // ),
	        // array(            
	        // 	'name'   => 'genero',
	        // 	'filter' => array(0 => 'Femenino', 1 => 'Masculino'),
	        // 	'value'  => '$data->generoformateado' ,
	        // ),
	        // // array(            
	        // //     'name'  => 'ocupacion',
	        // //     'value' => '$data->ocupacionformateado' ,
	        // // ),
	        // array(            
	        // 	'name'   => 'pais',
	        // 	'value'  => '$data->paisformateado' ,
	        // ),
	        // array(
	        // 	'header' => 'Quitar',
	        // 	'value'  => 'CHtml::link("<i class=\"fa fa-times\"></i>", null ,array("class"=>"btn btn-primary activacion", "id"=>"btn_".$data->id, "data-toggle"=>"tooltip", "title"=>"Activar"))',
	        // 	'type'   => 'raw'
	        // ),

	        // array(          
	        //     'name'  => 'estadoCivil',
	        //     'filter'=> CHtml::listData(EstadoCivil::model()->findAll(),'id_estado_civil','descripcion'),
	        //     'headerHtmlOptions'=>array('class'=>'hidden-xs'),
	        //    	'htmlOptions'=>array('class'=>'hidden-xs'),
	        //    	'filterHtmlOptions' => array('class'=>'hidden-xs'),
	        //     'value' => '$data->estadocivilformateado' ,
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