<?php
/* @var $this FormularioController */
/* @var $model Formulario */

// $this->breadcrumbs=array(
// 	'Formularios'=>array('index'),
// 	'Create',
// );

// $this->menu=array(
// 	array('label'=>'List Formulario', 'url'=>array('index')),
// 	array('label'=>'Manage Formulario', 'url'=>array('admin')),
// );
?>


<div class="page-header">
	<h2>Crear <small>Encuesta</small></h2>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>