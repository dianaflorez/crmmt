<?php
/* @var $this PreguntaController */
/* @var $model Pregunta */

// $this->breadcrumbs=array(
// 	'Preguntas'=>array('index'),
// 	'Create',
// );

// $this->menu=array(
// 	array('label'=>'List Pregunta', 'url'=>array('index')),
// 	array('label'=>'Manage Pregunta', 'url'=>array('admin')),
// );
?>

<div class="page-header">
	<h2>Crear <small>Pregunta</small></h2>
</div>

<?php $this->renderPartial('_form', array('model'=>$model, 'error'=>$error, 'opciones'=>$opciones)); ?>