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
	<h2>Crear <small>Campana</small></h2>
</div>


<?php $this->renderPartial('_form', array('model'=>$model, 'tiposCampana'=>$tiposCampana, 'error'=>$error)); ?>
