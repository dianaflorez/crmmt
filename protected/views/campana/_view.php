<?php
/* @var $this CampanaController */
/* @var $data Campana */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cam')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_cam), array('view', 'id'=>$data->id_cam)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contenido')); ?>:</b>
	<?php echo CHtml::encode($data->contenido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecini')); ?>:</b>
	<?php echo CHtml::encode($data->fecini); ?>
	<br />


</div>