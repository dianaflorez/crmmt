<?php
	/* @var $this FormularioController */
	/* @var $model Formulario */
	/* @var $form CActiveForm */
	
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.css');
	$cs->registerScriptFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.min.js');
?>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'formulario-form',
		'htmlOptions' => array('role'=>'form'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

		<div class="form-group">
			<p>Los campos con <strong>*</strong> son obligatorios.</p>
			<!--  Mostrar los errores que se han generado.
			 El primer segmento muestra errores de validación. El segundo bloquer muestra errores generados en el envio
			 de la campaña o excepción en el servidor. -->
			<?php if($model->hasErrors()) {	?>
				<p class="text-danger">
					Hay campos mal diligenciados. Por favor revise.
				</p>
			<?php } ?>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group <?php if($form->error($model,'titulo') != ''){ echo 'has-error'; } ?>">
					<?php echo $form->labelEx($model,'titulo'); ?>
					<?php echo $form->textField($model,'titulo', array('class'=>'form-control', 'maxlength'=>64, 'placeholder'=>'Título')); ?>
					<?php if($form->error($model,'titulo') != ''):?>
						<p class="text-danger">					
							<?php echo $model->getError('titulo'); ?>			
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?php echo $form->labelEx($model,'contenido');//echo CHtml::label('Contenido', null); ?>
					<?php echo $form->textArea($model,'contenido', array('class'=>'form-control','rows'=>6, 'cols'=>50, 'placeholder'=>'Mensaje de su encuesta')); ?>
					<?php echo $form->error($model,'contenido', array('class'=>'col-md-1')); ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="col-md-8">
					<div class="form-group">
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-primary btn-block')); ?> 
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					<?php echo CHtml::link('Cancelar', Yii::app()->createUrl('formulario/'), array('class'=>'btn btn-default  btn-block','role'=>'button'));  ?>
					</div>
				</div>
			</div>
		</div>
		


	<?php $this->endWidget(); ?>
<!-- form -->
<script type="text/javascript">
	
	$(document).on('ready', inicio);

	function inicio(){
		$('#Formulario_contenido').jqte();
	}

</script>