<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */

$this->breadcrumbs=array(
	'Publico Objetivos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PublicoObjetivo', 'url'=>array('index')),
	array('label'=>'Manage PublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>Create PublicoObjetivo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); 
		$this->renderPartial('_pub_obj', array('publicos'=>$publicos)); ?>