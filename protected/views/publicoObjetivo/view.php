<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */

$this->breadcrumbs=array(
	'Publico Objetivos'=>array('index'),
	$model->id_po,
);

$this->menu=array(
	array('label'=>'List PublicoObjetivo', 'url'=>array('index')),
	array('label'=>'Create PublicoObjetivo', 'url'=>array('create')),
	array('label'=>'Update PublicoObjetivo', 'url'=>array('update', 'id'=>$model->id_po)),
	array('label'=>'Delete PublicoObjetivo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_po),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>View PublicoObjetivo #<?php echo $model->id_po; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_po',
		'nombre',
		'descripcion',
		'feccre',
		'fecmod',
		'id_usu',
	),
)); ?>
