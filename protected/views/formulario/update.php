<?php
/* @var $this FormularioController */
/* @var $model Formulario */

// $this->breadcrumbs=array(
// 	'Formularios'=>array('index'),
// 	$model->id_for=>array('view','id'=>$model->id_for),
// 	'Update',
// );

// $this->menu=array(
// 	array('label'=>'List Formulario', 'url'=>array('index')),
// 	array('label'=>'Create Formulario', 'url'=>array('create')),
// 	array('label'=>'View Formulario', 'url'=>array('view', 'id'=>$model->id_for)),
// 	array('label'=>'Manage Formulario', 'url'=>array('admin')),
// );
?>

<div class="page-header">
	<h2>Editar <small>Encuesta</small></h2>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>