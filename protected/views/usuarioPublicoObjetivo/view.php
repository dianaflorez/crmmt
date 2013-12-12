<?php
/* @var $this UsuarioPublicoObjetivoController */
/* @var $model UsuarioPublicoObjetivo */

$this->breadcrumbs=array(
	'Usuario Publico Objetivos'=>array('index'),
	$model->id_upo,
);

$this->menu=array(
	array('label'=>'List UsuarioPublicoObjetivo', 'url'=>array('index')),
	array('label'=>'Create UsuarioPublicoObjetivo', 'url'=>array('create')),
	array('label'=>'Update UsuarioPublicoObjetivo', 'url'=>array('update', 'id'=>$model->id_upo)),
	array('label'=>'Delete UsuarioPublicoObjetivo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_upo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UsuarioPublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>View UsuarioPublicoObjetivo #<?php echo $model->id_upo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_upo',
		'id_po',
		'id_usupo',
		'estado',
		'feccre',
		'fecmod',
		'id_usu',
	),
)); ?>
