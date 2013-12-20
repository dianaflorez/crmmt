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
		'htmlOptions' => array('enctype'=>'multipart/form-data', 'role'=>'form'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<!--  Mostrar los errores que se han generado.
				 El primer segmento muestra errores de validación. El segundo bloquer muestra errores generados en el envio
				 de la campaña o excepción en el servidor. -->
				<?php if($model->hasErrors()): ?>
					<p class="text-danger">
						Hay campos mal diligenciados. Por favor revise.
					</p>
				<?php endif; ?>
				<?php if($error != null): ?>
					<p class="text-danger">
						<?php echo $error; ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo $form->hiddenField($model,'id_cam', array('class'=>'form-control', 'type'=>'hidden')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo $form->labelEx($model,'asunto'); ?>
				<div class="well well-sm">
					<?php echo $model->asunto; ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<?php echo $form->labelEx($model,'contenido'); ?>
				<div class="well well-sm">
					<div class="row">
						
						<div class="col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6">
						    <div class="thumbnail">
						      <img src="<?php echo $model->urlimage; ?>" alt="..." class="img-responsive">
						    </div>
					  	</div>
					  	
					</div>

				<?php echo $model->contenido; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Público objetivo', 'Publico_objetivo'); ?>
				<div class="form-group">
					<?php echo CHtml::dropDownList('Campana[PublicoObjetivo]', null, CHtml::ListData($publicos, 'id_po', 'nombre'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
					<?php if($errorPublicoOjetivo != null): ?>
					<p class="text-danger">					
						<?php echo $errorPublicoOjetivo; ?>		
					</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::link('Enviar Prueba', Yii::app()->createUrl('campana/'), array('class'=>'btn btn-primary','role'=>'button'));  ?>
				<?php echo CHtml::submitButton('Enviar', array('class'=>'btn btn-warning')); ?> 
				<?php echo CHtml::link('Cancelar', Yii::app()->createUrl('campana/'), array('class'=>'btn btn-default','role'=>'button'));  ?>
			</div>
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