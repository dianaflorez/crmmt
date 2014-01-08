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
				<p>Los campos con <strong>*</strong> son obligatorios.</p>
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
				<?php echo CHtml::label('Tipo campaña', 'Campana_id_tc'); ?>
				<div class="form-group">
				<?php echo CHtml::dropDownList('Campana[id_tc]', null, CHtml::ListData($tiposCampana, 'id_tc', 'nombre'), array('prompt' => 'Seleccione', 'class'=>'form-control', 'options' => array($model->id_tc => array('selected' => true)))); ?>
				<?php if($form->error($model,'id_tc') != ''): ?>
					<p class="text-danger">					
						<?php echo $model->getError('id_tc'); ?>		
					</p>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group <?php if($form->error($model,'asunto') != ''){ echo 'has-error'; } ?>">
				<?php echo $form->labelEx($model,'asunto'); ?>
				<?php echo $form->textField($model,'asunto', array('class'=>'form-control','maxlength'=>128, 'placeholder'=>'Asunto')); ?>
				<?php if($form->error($model,'asunto') != ''): ?>
					<p class="text-danger">					
						<?php echo $model->getError('asunto'); ?>		
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 no-email">
			<div id="duracion" class="form-group">
				<?php echo CHtml::label('Duración', ''); ?>
				<div class="form-group">
				<?php echo CHtml::label('Fecha inicio', 'Campana_fecini'); ?>
				<?php echo $form->dateField($model, 'fecini', array('class'=>'', 'value'=>date('Y-m-d'))); ?>
				<?php echo CHtml::label('Hasta', 'Campana_fecfin'); ?>
				<?php echo $form->dateField($model, 'fecfin', array('class'=>'', 'value'=>date('Y-m-d'))); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 no-email">
			<div id="precio" class="form-group <?php if($form->error($model,'precio') != ''){ echo 'has-error'; } ?>">
				<?php echo $form->labelEx($model,'precio'); ?>
				<?php echo $form->numberField($model,'precio', array('class'=>'form-control','maxlength'=>128, 'placeholder'=>'Precio')); ?>
				<?php if($form->error($model,'precio') != ''): ?>
					<p class="text-danger">					
						<?php echo $model->getError('precio'); ?>		
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div id="personalizada no-email" class="col-md-4">
			<div class="form-group <?php if($form->error($model,'personalizada') != ''){ echo 'has-error'; } ?>">
				<?php echo $form->labelEx($model,'personalizada'); ?>
				<?php echo  $form->checkBox($model,'personalizada',array('separator'=>'')); ?>
				<?php if($form->error($model,'personalizada') != ''): ?>
					<p class="text-danger">					 
						<?php echo $model->getError('personalizada'); ?>		
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 no-email">
			<div id="almacen" class="form-group <?php if($form->error($model,'almacen') != ''){ echo 'has-error'; } ?>">
				<?php echo $form->labelEx($model,'almacen'); ?>
				<div class="form-group">
				<?php echo  $form->radioButtonList($model,'almacen',array('MTA'=>'MT','MTO'=>'MTOrange'),array('separator'=>' ')); ?>
				<?php if($form->error($model,'almacen') != ''): ?>
					<p class="text-danger">					
						<?php echo $model->getError('almacen'); ?>		
					</p>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group <?php if($form->error($model,'urlimage') != ''){ echo 'has-error'; } ?>">
				<?php echo $form->labelEx($model, 'image'); ?>
				<?php echo $form->fileField($model, 'image', array('class'=>'form-control')); ?>
				<?php if($form->error($model,'urlimage') != ''): ?>
						<p class="text-danger">					
							<?php echo $model->getError('urlimage'); ?>		
						</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<?php echo $form->labelEx($model,'contenido'); ?>
				<?php echo $form->textArea($model,'contenido', array('class'=>'form-control','rows'=>6, 'cols'=>50, 'placeholder'=>'Mensaje de la campaña')); ?>
				<?php echo $form->error($model,'contenido'); ?>
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
				<?php echo CHtml::link('Cancelar', Yii::app()->createUrl('campana/'), array('class'=>'btn btn-default  btn-block','role'=>'button'));  ?>
				</div>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>



<script type="text/javascript">
	
	$(document).on('ready', inicio);

	function inicio(){
		$('#Campana_contenido').jqte();
		$('#Campana_id_tc').on('change', visibilidadElementos);
		$('#personalizada').slideUp();
	}

	function visibilidadElementos(e){
		var opcionSeleccionada = $('option:selected', this);
		var valorSeleccionado = opcionSeleccionada.val();
		console.log(opcionSeleccionada.text()+' '+valorSeleccionado);
		if(opcionSeleccionada.text() === 'email'){
			// $('#duracion').slideUp();
			// $('#precio').slideUp();
			// $('#almacen').slideUp();
			// $('#personalizada').slideDown();
			// $('#Campana_fecini').prop('disabled', true);
			// $('#Campana_fecfin').prop('disabled', true);
			$('.no-email').each(function(){
				$(this).slideUp();
			});
			
		}else{
			// $('#duracion').slideDown();
			// $('#precio').slideDown();
			// $('#personalizada').slideUp();
			// $('#Campana_fecini').prop('disabled', false);
			// $('#Campana_fecfin').prop('disabled', false);
			$('.no-email').each(function(){
				$(this).slideDown();
			});


		}
	}

</script>