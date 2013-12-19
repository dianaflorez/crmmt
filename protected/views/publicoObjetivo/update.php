<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */

// $this->breadcrumbs=array(
// 	'Publico Objetivos'=>array('index'),
// 	$model->id_po=>array('view','id'=>$model->id_po),
// 	'Update',
// );

// $this->menu=array(
// 	array('label'=>'List PublicoObjetivo', 'url'=>array('index')),
// 	array('label'=>'Create PublicoObjetivo', 'url'=>array('create')),
// 	array('label'=>'View PublicoObjetivo', 'url'=>array('view', 'id'=>$model->id_po)),
// 	array('label'=>'Manage PublicoObjetivo', 'url'=>array('admin')),
// );
?>

<?php $this->renderPartial('_irPublico'); ?>

<div class="page-header">
	<h2>Editar <small>Público Objetivo</small></h2>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>