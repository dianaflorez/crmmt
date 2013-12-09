<?php
/* @var $this FormularioController */
/* @var $model Formulario */
/* @var $form CActiveForm */

	//$baseUrl = Yii::app()->baseUrl; 
	//$cs = Yii::app()->getClientScript();
	//$cs->registerScriptFile($baseUrl.'/lib/backbone/underscore-min.js', CClientScript::POS_END);
	//$cs->registerScriptFile($baseUrl.'/lib/backbone/backbone-min.js', CClientScript::POS_END);
	//$cs->registerScriptFile($baseUrl.'/js/pagina.js', CClientScript::POS_END);
?>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'formulario-form',
		'htmlOptions' => array('class'=>'form-horizontal', 'role'=>'form'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

		<div class="form-group">
			<div class="col-md-offset-1 col-md-10">
				<p>Los campos con <strong>*</strong> son obligatorios.</p>
			</div>

			<?php if($model->hasErrors()) {	?>
			<div class="col-md-offset-1 col-md-10">
				<p class="text-danger">
					Hay campos mal diligenciados. Por favor revise.
				</p>
			</div>
			<?php } ?>
		</div>

		<div class="form-group <?php if($form->error($model,'titulo') != ''){ echo 'has-error'; } ?>">
			<?php echo $form->labelEx($model,'titulo', array('class'=>' col-md-1')); ?>
			<div class="col-md-6">
			<?php echo $form->textField($model,'titulo', array('class'=>'form-control', 'maxlength'=>64, 'placeholder'=>'Título')); ?>
			<?php if($form->error($model,'titulo', array('class'=>'col-md-1'))!='') { ?>
					<p class="text-danger">					
						<?php echo $model->getError('titulo'); ?>			
					</p>
			<?php } ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'contenido', array('class'=>' col-md-1')); ?>
			<div class="col-md-10">
				<?php echo $form->textArea($model,'contenido', array('class'=>'form-control','rows'=>6, 'cols'=>50, 'placeholder'=>'Mensaje de su encuesta')); ?>
			</div>
			<?php echo $form->error($model,'contenido', array('class'=>'col-md-1')); ?>
		</div>

		<div class="form-group">
			<div class="col-md-offset-1 col-md-10">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-default')); ?>
			</div>
		</div>
		


	<?php $this->endWidget(); ?>
</div><!-- form -->
