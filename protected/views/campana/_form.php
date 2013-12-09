<?php
/* @var $this CampanaController */
/* @var $model Campana */
/* @var $form CActiveForm */

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile($baseUrl.'/lib/wysihtml5/parser_rules/advanced.js'); 
//$cs->registerScriptFile($baseUrl.'/lib/wysihtml5/wysihtml5-0.3.0.min.js');
//$cs->registerScriptFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.min.js');
?>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'campana-form',
		'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data', 'role'=>'form'),
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

		<!--  Mostrar los errores que se han generado.
		 El primer segmento muestra errores de validación. El segundo bloquer muestra errores generados en el envio
		 de la campaña o excepción en el servidor. -->
		<?php if($model->hasErrors()) {	?>
		<div class="col-md-offset-1 col-md-10">
			<p class="text-danger">
				Hay campos mal diligenciados. Por favor revise.
			</p>
		</div>
		<?php } ?>
		<?php if($error != null) {	?>
			<div class="col-md-offset-1 col-md-10">
			<p class="text-danger">
				<?php echo $error; ?>
			</p>
		</div>
		<?php } ?>
	</div>
		
	<div class="form-group <?php if($form->error($model,'asunto') != ''){ echo 'has-error'; } ?>">
		<?php echo $form->labelEx($model,'asunto', array('class'=>'col-md-1')); ?>
		<div class="col-md-6">
			<?php echo $form->textField($model,'asunto', array('class'=>'form-control','maxlength'=>128, 'placeholder'=>'Asunto')); ?>
			<?php if($form->error($model,'asunto', array('class'=>'col-md-1'))!='') { ?>
				<p class="text-danger">					
					<?php echo $model->getError('asunto'); ?>		
				</p>
			<?php } ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'contenido', array('class'=>'col-md-1')); ?>
		<div class="col-md-10">
			<?php echo $form->textArea($model,'contenido', array('class'=>'form-control','rows'=>6, 'cols'=>50, 'placeholder'=>'Mensaje de la campaña')); ?>
		</div>
		<?php echo $form->error($model,'contenido'); ?>
	</div>

	<div class="form-group <?php if($form->error($model,'urlimage') != ''){ echo 'has-error'; } ?>">
		<?php echo $form->labelEx($model, 'image', array('class'=>'col-md-1')); ?>
		<div class="col-md-6">
			<?php echo $form->fileField($model, 'image', array('class'=>'form-control')); ?>
			<?php if($form->error($model,'urlimage', array('class'=>'col-md-2'))!='') { ?>
				<p class="text-danger">					
					<?php echo $model->getError('urlimage'); ?>		
				</p>
			<?php } ?>
		</div>
		
	</div>

	<div class="form-group">
		<div class="col-md-offset-1 col-md-10">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-default')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	
	$(document).on('ready', inicio);

	function inicio(){
		$('#Campana_contenido').jqte();
	}

</script>