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
		<div class="col-md-6">
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
					<?php if($model->urlimage): ?>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6">
						    <div class="thumbnail">
						      <img src="<?php echo $model->urlimage; ?>" alt="..." class="img-responsive">
						    </div>
					  	</div>
					</div>
					<?php endif; ?>
				<?php echo $model->contenido; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-info">
			  	<div class="panel-heading">Prueba la campaña antes de enviarla.</div>
			  	<div class="panel-body">
			  		<div class="row form-inline">
			  			
			  			<fieldset>
					   <?php //echo CHtml::label('Correo', 'correo_prueba'); ?>
					   <div class="col-sm-8 col-md-8">
							<div class="form-group">
								<div class="input-group margin-bottom-sm">
		  							<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
									<?php echo CHtml::emailField('correo_prueba', '', array('class'=>'form-control', 'placeholder'=>'Correo')); ?> 
								</div>
							</div>
						</div>
						<div class="col-sm-4 col-md-4">
						<div class="form-group">
						<?php echo CHtml::button('Enviar Prueba', array('class'=>'btn btn-primary form-control', 'id'=> 'enviarPrueba'));  ?>
						</div>
						</div>
						</fieldset>
						
					</div>
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
				<?php echo CHtml::link('Cancelar', Yii::app()->createUrl('campana/'), array('class'=>'btn btn-default  btn-block','role'=>'button'));  ?>
				</div>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	
	$(document).on('ready', inicio);

	function inicio(){
		//$('#Campana_contenido').jqte();
		$('#enviarPrueba').on('click', enviarPrueba);
		$('#correo_prueba').on('click', restablecer);
	}

	function restablecer(e){
		$('#correo_prueba').parent().removeClass('has-error');
	}

	function enviarPrueba(e)
	{
		console.log('click');
		id_cam = $('#Campana_id_cam').val();
		correo_prueba = $('#correo_prueba').val();
		console.log(id_cam);
		console.log(correo_prueba);

		if(esEmail(correo_prueba)){
			var peticion = $.ajax({
				url: "<?php echo Yii::app()->createUrl('campana/enviarPrueba'); ?>",
				type: "POST",
				data: 
				{ 
					id : id_cam,
					correoPrueba: correo_prueba,
				},
				dataType: 'html'
			});
			 
			peticion.done(function( msg ) {
				console.log('exito '+msg);
				// fila.addClass('success');
				// $('#btn_'+id_usupo).hide();
				// $('#chk_'+id_usupo).hide();
			});
			 
			peticion.fail(function( jqXHR, textStatus ) {
				console.log('fallo '+textStatus);
				// fila.addClass('warning');
				// var quitarFila = function (){
				// 	fila.removeClass('warning');
				// };
				// setTimeout(quitarFila, 1500);
			});
		}else{
			//alert('El correo no es válido');
			$('#correo_prueba').parent().toggleClass('has-error');
		}
	
	}

	function esEmail(email) {
	  	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  	return regex.test(email);
	}
	
</script>