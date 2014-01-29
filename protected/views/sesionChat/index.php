<?php
/* @var $this SesionChatController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sesion Chats',
);

$this->menu=array(
	array('label'=>'Create SesionChat', 'url'=>array('create')),
	array('label'=>'Manage SesionChat', 'url'=>array('admin')),
);
?>

<h1>Sesion Chats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
