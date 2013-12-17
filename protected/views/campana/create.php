<?php
/* @var $this CampanaController */
/* @var $model Campana */

$this->breadcrumbs=array(
	'Campanas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Campana', 'url'=>array('index')),
	array('label'=>'Manage Campana', 'url'=>array('admin')),
);
?>

<h1>Create Campana</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'publicos'=>$publicos, 'error'=>$error)); ?>
