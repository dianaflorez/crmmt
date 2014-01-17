<div class="page-header">
	<h2>Revisar <small>Encuesta</small></h2>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<?php if($error != null): ?>
				<p class="text-danger">
					<?php echo $error; ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>


<?php $this->renderPartial('encuesta', array('model'=>$model, 'activa'=>$activa)); ?>
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