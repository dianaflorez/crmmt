<?php
/* @var $this UsuarioPublicoObjetivoController */
/* @var $model UsuarioPublicoObjetivo */

$this->breadcrumbs=array(
	'Usuario Publico Objetivos'=>array('index'),
	$model->id_upo=>array('view','id'=>$model->id_upo),
	'Update',
);

$this->menu=array(
	array('label'=>'List UsuarioPublicoObjetivo', 'url'=>array('index')),
	array('label'=>'Create UsuarioPublicoObjetivo', 'url'=>array('create')),
	array('label'=>'View UsuarioPublicoObjetivo', 'url'=>array('view', 'id'=>$model->id_upo)),
	array('label'=>'Manage UsuarioPublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>Update UsuarioPublicoObjetivo <?php echo $model->id_upo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>