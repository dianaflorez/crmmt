<?php
/* @var $this CampanaController */
/* @var $data Campana */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_camp')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_camp), array('view', 'id'=>$data->id_camp)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contenido')); ?>:</b>
	<?php echo CHtml::encode($data->contenido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaini')); ?>:</b>
	<?php echo CHtml::encode($data->fechaini); ?>
	<br />


</div>