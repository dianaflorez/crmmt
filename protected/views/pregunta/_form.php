<?php
/* @var $this PreguntaController */
/* @var $model Pregunta */
/* @var $form CActiveForm */

	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile($baseUrl.'/lib/backbone/underscore-min.js', CClientScript::POS_END);
	$cs->registerScriptFile($baseUrl.'/lib/backbone/backbone-min.js', CClientScript::POS_END);
	$cs->registerScriptFile($baseUrl.'/js/pagina.js', CClientScript::POS_END);
?>

<div class="row">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pregunta-form',
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
		<?php if($model->hasErrors()):	?>
			<p class="text-danger">
				Hay campos mal diligenciados. Por favor revise.
			</p>
		<?php endif; ?>
		<?php if($error != null):	?>
			<p class="text-danger">
				<?php echo $error; ?>
			</p>		
		<?php endif; ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'txtpre'); ?>
		<?php echo $form->textField($model,'txtpre', array('class'=>'form-control', 'maxlength'=>64, 'placeholder'=>'Pregunta')); ?>
		<?php if($form->error($model,'txtpre')!=''): ?>
				<p class="text-danger">					
					<?php echo $model->getError('txtpre'); ?>			
				</p>
		<?php endif; ?>
	</div>

	<?php if($model->isNewRecord): ?>
	<div class="form-group">
		<?php echo CHtml::label('Respuesta', 'pregunta_tipo'); ?>
		<div class="form-group">
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-primary radio_tipo active">
					<input type="radio" name="Tipo" class="form-control" value="unica" id="pregunta_tipo" checked> Única
				</label>
				<label class="btn btn-primary radio_tipo">
					<input type="radio" name="Tipo" class="form-control" value="multiple" id="pregunta_tipo"> Multiple
				</label>
				<label class="btn btn-primary radio_tipo">
					<input type="radio" name="Tipo" class="form-control" value="abierta" id="pregunta_tipo"> Abierta
				</label>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div id="tipo_abierta_opciones" class="form-group" style="display: none;">
		<?php echo CHtml::label('Respuesta abierta tipo', 'pregunta_tipo'); ?>
		<div class="form-group">
		 <div class="btn-group" data-toggle="buttons">
				<label class="btn btn-primary active">
					<input type="radio" name="Opciones_abierta" class="form-control" value="texto" id="opcion_abierta" checked> Texto
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="Opciones_abierta" class="form-control" value="numero" id="opcion_abierta"> Número
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="Opciones_abierta" class="form-control" value="fecha" id="opcion_abierta"> Fecha
				</label>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div id="panel_opciones">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
					<p>
						<div class="col-md-4">
							<span class="hidden-xs hidden-sm"><strong>Opciones de respuesta</strong></span> 
						</div>
						<div class="col-md-offset-6 col-md-2">
							<button class="btn btn-primary form-control" id="agregar_opcion">
								<span class="glyphicon glyphicon-plus-sign"></span> Opción
							</button>
						</div>
					</p>
					</div>
				</div>
				<div id="pregunta_panel" class="panel-body">
					<fieldset id="opciones">
					</fieldset>
				</div>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-primary btn-block')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script id="opcion_template" type="text/template">
	<div class="col-xs-1 col-sm-1 col-md-1">
		<button type="button" class="close eliminar_opcion <% if(!cerrar) print('hidden'); %>" aria-hidden="true">&times;</button>
	</div>
	<div class="col-xs-10 col-sm-11 col-md-11">
		<div class="form-group">
			<input class="form-control" maxlength="70" placeholder="Opción" name="<% if(id_op) print('Opcion[Existentes]['+id_op+']'); else print('Opcion[Nuevas][]'); %>" type="text" value="<%= texto %>">
		</div>
	</div>
</script>
<script type="text/javascript">
	var opcionesExistentes = <?php echo  CJSON::encode($opciones).';'; ?> 
</script>

