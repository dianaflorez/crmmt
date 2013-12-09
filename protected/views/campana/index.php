<?php
/* @var $this CampanaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Campanas',
);

$this->menu=array(
	array('label'=>'Create Campana', 'url'=>array('create')),
	array('label'=>'Manage Campana', 'url'=>array('admin')),
);
?>

<h1>Campanas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>