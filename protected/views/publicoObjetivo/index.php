<?php
/* @var $this PublicoObjetivoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Publico Objetivos',
);

$this->menu=array(
	array('label'=>'Create PublicoObjetivo', 'url'=>array('create')),
	array('label'=>'Manage PublicoObjetivo', 'url'=>array('admin')),
);
?>

<h1>Publico Objetivos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
