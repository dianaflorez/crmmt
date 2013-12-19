<?php
/* @var $this CampanaController */
/* @var $model Campana */

// $this->breadcrumbs=array(
// 	'Campanas'=>array('index'),
// 	'Create',
// );

// $this->menu=array(
// 	array('label'=>'List Campana', 'url'=>array('index')),
// 	array('label'=>'Manage Campana', 'url'=>array('admin')),
// );
?>

<div class="page-header">
	<h2>Enviar <small>Campana</small></h2>
</div>

<?php $this->renderPartial('_previewEnviar', array('model'=>$model, 'publicos'=>$publicos, 'error'=>$error, 'errorPublicoOjetivo'=>$errorPublicoOjetivo)); ?>
