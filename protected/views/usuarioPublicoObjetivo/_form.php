<?php
/* @var $this UsuarioPublicoObjetivoController */
/* @var $model UsuarioPublicoObjetivo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-publico-objetivo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_po'); ?>
		<?php echo $form->textField($model,'id_po'); ?>
		<?php echo $form->error($model,'id_po'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_usupo'); ?>
		<?php echo $form->textField($model,'id_usupo'); ?>
		<?php echo $form->error($model,'id_usupo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->checkBox($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'feccre'); ?>
		<?php echo $form->textField($model,'feccre'); ?>
		<?php echo $form->error($model,'feccre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecmod'); ?>
		<?php echo $form->textField($model,'fecmod'); ?>
		<?php echo $form->error($model,'fecmod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_usu'); ?>
		<?php echo $form->textField($model,'id_usu'); ?>
		<?php echo $form->error($model,'id_usu'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->