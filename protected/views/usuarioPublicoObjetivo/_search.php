<?php
/* @var $this UsuarioPublicoObjetivoController */
/* @var $model UsuarioPublicoObjetivo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_upo'); ?>
		<?php echo $form->textField($model,'id_upo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_po'); ?>
		<?php echo $form->textField($model,'id_po'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_usupo'); ?>
		<?php echo $form->textField($model,'id_usupo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->checkBox($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'feccre'); ?>
		<?php echo $form->textField($model,'feccre'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecmod'); ?>
		<?php echo $form->textField($model,'fecmod'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_usu'); ?>
		<?php echo $form->textField($model,'id_usu'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->