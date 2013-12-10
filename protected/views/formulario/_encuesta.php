<div class="form col-md-6">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'encuesta-form',
		'htmlOptions' => array('role'=>'form'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<div class="form-group <?php if($form->error($model,'titulo') != ''){ echo 'has-error'; } ?>">
		<?php echo $form->labelEx($model,'titulo'); ?>
		<?php echo $form->textField($model,'titulo', array('class'=>'form-control', 'maxlength'=>64, 'placeholder'=>'Título')); ?>
		<?php if($form->error($model,'titulo')!='') { ?>
				<p class="text-danger">					
					<?php echo $model->getError('titulo'); ?>			
				</p>
		<?php } ?>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'contenido'); ?>
			<?php echo $form->textArea($model,'contenido', array('class'=>'form-control','rows'=>6, 'cols'=>50, 'placeholder'=>'Mensaje de su encuesta')); ?>
		<?php echo $form->error($model,'contenido'); ?>
	</div>

	<?php foreach ($model->preguntas as $pregunta): ?>
		<div class="well well-sm">
			<div class="form-group">
			<?php 
					echo $form->labelEx($pregunta,'txtpre');
					//echo $pregunta->txtpre; 
					echo CHtml::textField('Pregunta['.$pregunta->id_pre.']', $pregunta->txtpre, array('class'=>"form-control texto", 'name'=> 'pregunta_'.$pregunta->id_pre, 'placeholder'=>"Respuesta"));
			?>
			</div>
			<div class="form-group">
				<?php 
				if($pregunta->id_tpr === null): 
					$porDefecto = true;
					$tipo_opcion = $pregunta->id_tp === 1 ? 'radio' : 'checkbox';
					foreach ($pregunta->opciones as $opcion): ?>
						<div class="<?php echo $tipo_opcion; ?>">
						  <label>
						    <?php
						   		if($pregunta->id_tp === 1)
						   			echo CHtml::radioButton('', $porDefecto, array('value'=>$opcion->id_op, 'disabled'=>$activa ? '' : 'disabled'));
						   		elseif($pregunta->id_tp === 2)
						   			echo CHtml::checkBox('', $porDefecto, array('value'=>$opcion->id_op, 'disabled'=>$activa ? '' : 'disabled'));
						   		$porDefecto = false;
						   		echo CHtml::textField('Opcion['.$opcion->id_op.']', $opcion->txtop, array('class'=>"form-control texto", 'name'=> 'pregunta_'.$pregunta->id_pre, 'placeholder'=>"Respuesta"));//$opcion->txtop; ?>
						  </label>
						</div>
				<?php 
					endforeach; 
				elseif($pregunta->id_tpr === 1):
					echo CHtml::textField('', null, array('class'=>"form-control texto", 'name'=> 'pregunta_'.$pregunta->id_pre, 'placeholder'=>"Respuesta", 'disabled'=>$activa ? '' : 'disabled'));
				elseif($pregunta->id_tpr === 2):
					echo CHtml::numberField('', null, array('class'=>"form-control numero", 'min'=>0, 'name'=> 'pregunta_'.$pregunta->id_pre, 'placeholder'=>"Número", 'disabled'=>$activa ? '' : 'disabled'));
				elseif($pregunta->id_tpr === 3):
					echo CHtml::dateField('', date('Y-m-d'), array('class'=>"form-control fecha", 'name'=> 'pregunta_'.$pregunta->id_pre, 'disabled'=>$activa ? '' : 'disabled'));
				endif; ?>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="form-group">
		<div class="col-md-2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-primary btn-block')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
	
	$(document).on('ready', inicio);

	function inicio(){
		$('#Formulario_contenido').jqte();
	}

</script>
		