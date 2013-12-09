<?php
/* @var $this FormularioController */
/* @var $data Formulario */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_for')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_for), array('view', 'id'=>$data->id_for)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('titulo')); ?>:</b>
	<?php echo CHtml::encode($data->titulo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contenido')); ?>:</b>
	<?php echo CHtml::encode($data->contenido); ?>
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

	<b><?php echo CHtml::link('Agregar pregunta', Yii::app()->createUrl('pregunta/create/', array('idfor'=>$data->id_for)));  ?>:</b>
	<br />

</div>