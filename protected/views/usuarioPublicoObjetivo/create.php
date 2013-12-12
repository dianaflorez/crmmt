<?php
/* @var $this UsuarioPublicoObjetivoController */
/* @var $model UsuarioPublicoObjetivo */

$this->breadcrumbs=array(
	'Usuario Publico Objetivos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UsuarioPublicoObjetivo', 'url'=>array('index')),
	array('label'=>'Manage UsuarioPublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>Create UsuarioPublicoObjetivo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>