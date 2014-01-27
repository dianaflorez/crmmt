<div>
	<h4><?php echo $model->titulo; ?></h4>
	<p><?php echo $model->contenido; ?></p>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'encuesta-form',
	'htmlOptions' => array('role'=>'form'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php foreach ($model->preguntas as $pregunta): ?>
		<div class="row">
			<div class="col-md-12">
				<div class="well well-sm">
				<?php echo $pregunta->txtpre; ?>
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
								   			echo CHtml::radioButton('Pregunta['.$pregunta->id_pre.']', $porDefecto, array('value'=>$opcion->id_op, 'disabled'=>$activa ? '' : 'disabled'));
								   		elseif($pregunta->id_tp === 2)
								   			echo CHtml::checkBox('Pregunta['.$pregunta->id_pre.'][]', $porDefecto, array('value'=>$opcion->id_op, 'disabled'=>$activa ? '' : 'disabled'));
								   		$porDefecto = false;
								   		echo $opcion->txtop; ?>
								  </label>
								</div>
						<?php 
							endforeach; 
						elseif($pregunta->id_tpr === 1):
							echo CHtml::textField('Pregunta['.$pregunta->id_pre.']', null, array('class'=>"form-control texto", 'name'=> 'pregunta_'.$pregunta->id_pre, 'placeholder'=>"Respuesta", 'disabled'=>$activa ? '' : 'disabled'));
						elseif($pregunta->id_tpr === 2):
							echo CHtml::numberField('Pregunta['.$pregunta->id_pre.']', null, array('class'=>"form-control numero", 'min'=>0, 'name'=> 'pregunta_'.$pregunta->id_pre, 'placeholder'=>"Número", 'disabled'=>$activa ? '' : 'disabled'));
						elseif($pregunta->id_tpr === 3):
							echo CHtml::dateField('Pregunta['.$pregunta->id_pre.']', date('Y-m-d'), array('class'=>"form-control fecha", 'name'=> 'pregunta_'.$pregunta->id_pre, 'disabled'=>$activa ? '' : 'disabled'));
						endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<?php if($activa): ?>
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="form-group">
				<?php echo CHtml::submitButton('Enviar', array('class'=>'btn btn-primary btn-block')); ?> 
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php $this->endWidget(); ?>

		