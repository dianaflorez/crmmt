<?php
/* @var $this PublicoObjetivoController */
/* @var $data PublicoObjetivo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_po')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_po), array('view', 'id'=>$data->id_po)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('feccre')); ?>:</b>
	<?php echo CHtml::encode($data->feccre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecmod')); ?>:</b>
	<?php echo CHtml::encode($data->fecmod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usu')); ?>:</b>
	<?php echo CHtml::encode($data->id_usu); ?>
	<br />


</div>