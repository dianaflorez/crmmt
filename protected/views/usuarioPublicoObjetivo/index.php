<?php
/* @var $this UsuarioPublicoObjetivoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuario Publico Objetivos',
);

$this->menu=array(
	array('label'=>'Create UsuarioPublicoObjetivo', 'url'=>array('create')),
	array('label'=>'Manage UsuarioPublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>Usuario Publico Objetivos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
