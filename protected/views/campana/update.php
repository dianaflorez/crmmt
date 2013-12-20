<?php
/* @var $this CampanaController */
/* @var $model Campana */

// $this->breadcrumbs=array(
// 	'Campanas'=>array('index'),
// 	$model->id_camp=>array('view','id'=>$model->id_camp),
// 	'Update',
// );

// $this->menu=array(
// 	array('label'=>'List Campana', 'url'=>array('index')),
// 	array('label'=>'Create Campana', 'url'=>array('create')),
// 	array('label'=>'View Campana', 'url'=>array('view', 'id'=>$model->id_camp)),
// 	array('label'=>'Manage Campana', 'url'=>array('admin')),
// );
?>

<div class="page-header">
	<h2>Editar <small>Campana</small></h2>
</div>


<?php $this->renderPartial('_form', array('model'=>$model, 'tiposCampana'=>$tiposCampana, 'error'=>$error)); ?>