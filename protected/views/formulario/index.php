<?php
/* @var $this FormularioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Formularios',
);

$this->menu=array(
	array('label'=>'Create Formulario', 'url'=>array('create')),
	array('label'=>'Manage Formulario', 'url'=>array('admin')),
);
?>

<h1>Formularios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
