<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'publico-objetivo-form',
	'htmlOptions' => array('role'=>'form'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				<?php echo $form->labelEx($model,'nombre'); ?>
				<?php echo $form->textField($model,'nombre', array('class'=>'form-control', 'maxlength'=>128, 'placeholder'=>'Nombre')); ?>
				<?php if($form->error($model,'nombre')!=''): ?>
						<p class="text-danger">					
							<?php echo $model->getError('nombre'); ?>			
						</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<?php echo $form->labelEx($model,'descripcion'); ?>
				<?php echo $form->textArea($model,'descripcion', array('class'=>'form-control', 'rows'=>6, 'cols'=>50, 'placeholder'=>'Descripción')); ?>
				<?php if($form->error($model,'descripcion')!=''): ?>
						<p class="text-danger">					
							<?php echo $model->getError('descripcion'); ?>			
						</p>
				<?php endif; ?>
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
					<?php echo CHtml::link('Cancelar', Yii::app()->createUrl('publicoobjetivo/'), array('class'=>'btn btn-default btn-block','role'=>'button'));  ?>
				</div>
			</div>
		</div>
	</div>
	
<?php $this->endWidget(); ?>
