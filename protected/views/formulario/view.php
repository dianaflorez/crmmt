<?php
/* @var $this FormularioController */
/* @var $model Formulario */

$this->breadcrumbs=array(
	'Formularios'=>array('index'),
	$model->id_for,
);

$this->menu=array(
	array('label'=>'List Formulario', 'url'=>array('index')),
	array('label'=>'Create Formulario', 'url'=>array('create')),
	array('label'=>'Update Formulario', 'url'=>array('update', 'id'=>$model->id_for)),
	array('label'=>'Delete Formulario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_for),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Formulario', 'url'=>array('admin')),
);
?>

<h1>View Formulario #<?php echo $model->id_for; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_for',
		'titulo',
		'contenido',
		'feccre',
		'fecmod',
		'id_usu',
	),
)); ?>
