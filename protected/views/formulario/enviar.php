<?php
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.min.js');
?>
<div class="page-header">
	<h2>Enviar <small>Encuesta</small></h2>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-info">
		  	<div class="panel-heading">
		  		<div class="row">
		  		<p>
			  		<div class="col-md-6">
						<span class="hidden-xs hidden-sm"><strong>Vista previa</strong></span> 
					</div>
					<div class="col-md-6">
						<button class="btn btn-primary form-control" id="mostrar_preview">
							<i class="fa fa-arrow-down"></i> Mostrar
						</button>
					</div>
				</p>
				</div>
		  	</div>
		  	<div id="preview_encuesta" class="panel-body" style='display:none;'>
		  		<?php $this->renderPartial('_encuesta', array('model'=>$model, 'activa'=>$activa)); ?>
		  	</div>
		</div>
	</div>
</div>

<h4>Datos para envio.</h4>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<?php if($error != null): ?>
				<div class="alert alert-danger">
					<?php echo $error; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'formulario-form',
		'htmlOptions' => array('enctype'=>'multipart/form-data', 'role'=>'form'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group <?php if($form->error($campana,'asunto')){ echo 'has-error'; } ?>">
				<?php echo $form->labelEx($campana,'asunto'); ?>
				<?php echo $form->textField($campana,'asunto', array('class'=>'form-control','maxlength'=>128, 'placeholder'=>'Asunto')); ?>
				<?php if($form->error($campana,'asunto') != ''): ?>
					<p class="text-danger">					
						<?php echo $campana->getError('asunto'); ?>		
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group>">
				<?php echo $form->labelEx($campana,'contenido'); ?>
				<?php echo $form->textArea($campana,'contenido', array('class'=>'form-control','rows'=>6, 'cols'=>50, 'placeholder'=>'Mensaje de la campaña')); ?>
				<?php if($form->error($campana,'asunto') != ''): ?>
					<p class="text-danger">					
						<?php echo $campana->getError('asunto'); ?>		
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Público objetivo', 'Publico_objetivo'); ?>
				<div class="form-group">
					<?php echo CHtml::dropDownList('Campana[PublicoObjetivo]', null, CHtml::ListData($publicos, 'id_po', 'nombre'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
					<?php if($errorPublicoObjetivo != null): ?>
					<p class="text-danger">					
						<?php echo $errorPublicoObjetivo; ?>		
					</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="col-md-8">
				<div class="form-group">
					<?php echo CHtml::submitButton('Enviar', array('class'=>'btn btn-warning btn-block')); ?> 
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<?php echo CHtml::link('Volver', Yii::app()->createUrl('formulario/'), array('class'=>'btn btn-default  btn-block','role'=>'button'));  ?>
				</div>
			</div>
		</div>
	</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
	
	$(document).on('ready', inicio);

	function inicio(){
		$('#Campana_contenido').jqte();
		$('#mostrar_preview').on('click', mostrar);
	}

	function mostrar(e){
		var icono = $(e.target).children(":first");
		icono.toggleClass('fa-arrow-down');
		icono.toggleClass('fa-arrow-up');
		$('#preview_encuesta').slideToggle();
	}

</script>