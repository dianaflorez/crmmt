<?php
/* @var $this PreguntaController */
/* @var $model Pregunta */

$this->breadcrumbs=array(
	'Preguntas'=>array('index'),
	$model->id_pre,
);

$this->menu=array(
	array('label'=>'List Pregunta', 'url'=>array('index')),
	array('label'=>'Create Pregunta', 'url'=>array('create')),
	array('label'=>'Update Pregunta', 'url'=>array('update', 'id'=>$model->id_pre)),
	array('label'=>'Delete Pregunta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_pre),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pregunta', 'url'=>array('admin')),
);
?>

<h1>View Pregunta #<?php echo $model->id_pre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_pre',
		'txtpre',
		'despre',
		'id_tp',
		'id_tpr',
		'feccre',
		'fecmod',
		'id_usu',
	),
)); ?>
