<?php
/* @var $this PreguntaController */
/* @var $data Pregunta */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pre')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_pre), array('view', 'id'=>$data->id_pre)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('txtpre')); ?>:</b>
	<?php echo CHtml::encode($data->txtpre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('despre')); ?>:</b>
	<?php echo CHtml::encode($data->despre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tp')); ?>:</b>
	<?php echo CHtml::encode($data->id_tp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tpr')); ?>:</b>
	<?php echo CHtml::encode($data->id_tpr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('feccre')); ?>:</b>
	<?php echo CHtml::encode($data->feccre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecmod')); ?>:</b>
	<?php echo CHtml::encode($data->fecmod); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usu')); ?>:</b>
	<?php echo CHtml::encode($data->id_usu); ?>
	<br />

	*/ ?>

</div>