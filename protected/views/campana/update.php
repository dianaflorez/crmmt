<?php
/* @var $this CampanaController */
/* @var $model Campana */

$this->breadcrumbs=array(
	'Campanas'=>array('index'),
	$model->id_camp=>array('view','id'=>$model->id_camp),
	'Update',
);

$this->menu=array(
	array('label'=>'List Campana', 'url'=>array('index')),
	array('label'=>'Create Campana', 'url'=>array('create')),
	array('label'=>'View Campana', 'url'=>array('view', 'id'=>$model->id_camp)),
	array('label'=>'Manage Campana', 'url'=>array('admin')),
);
?>

<h1>Update Campana <?php echo $model->id_camp; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>