<?php
/* @var $this UsuarioPublicoObjetivoController */
/* @var $data UsuarioPublicoObjetivo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_upo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_upo), array('view', 'id'=>$data->id_upo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_po')); ?>:</b>
	<?php echo CHtml::encode($data->id_po); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usupo')); ?>:</b>
	<?php echo CHtml::encode($data->id_usupo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
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