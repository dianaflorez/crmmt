<?php
/* @var $this CampanaController */
/* @var $model Campana */

$this->breadcrumbs=array(
	'Campanas'=>array('index'),
	$model->id_cam,
);

$this->menu=array(
	array('label'=>'List Campana', 'url'=>array('index')),
	array('label'=>'Create Campana', 'url'=>array('create')),
	array('label'=>'Update Campana', 'url'=>array('update', 'id'=>$model->id_cam)),
	array('label'=>'Delete Campana', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_cam),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Campana', 'url'=>array('admin')),
);
?>

<h1>View Campana #<?php echo $model->id_cam; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_cam',
		'contenido',
		'fechaini',
	),
)); ?>