<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */

$this->breadcrumbs=array(
	'Publico Objetivos'=>array('index'),
	$model->id_po=>array('view','id'=>$model->id_po),
	'Update',
);

$this->menu=array(
	array('label'=>'List PublicoObjetivo', 'url'=>array('index')),
	array('label'=>'Create PublicoObjetivo', 'url'=>array('create')),
	array('label'=>'View PublicoObjetivo', 'url'=>array('view', 'id'=>$model->id_po)),
	array('label'=>'Manage PublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>Update PublicoObjetivo <?php echo $model->id_po; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>