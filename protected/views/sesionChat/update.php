<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */

$this->breadcrumbs=array(
	'Sesion Chats'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SesionChat', 'url'=>array('index')),
	array('label'=>'Create SesionChat', 'url'=>array('create')),
	array('label'=>'View SesionChat', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SesionChat', 'url'=>array('admin')),
);
?>

<h1>Update SesionChat <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>