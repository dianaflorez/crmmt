<?php
/* @var $this PreguntaController */
/* @var $model Pregunta */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_pre'); ?>
		<?php echo $form->textField($model,'id_pre'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'txtpre'); ?>
		<?php echo $form->textField($model,'txtpre',array('size'=>60,'maxlength'=>70)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'despre'); ?>
		<?php echo $form->textArea($model,'despre',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_tp'); ?>
		<?php echo $form->textField($model,'id_tp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_tpr'); ?>
		<?php echo $form->textField($model,'id_tpr'); ?>
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