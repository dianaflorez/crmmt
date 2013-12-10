<div class="well well-sm">
	<p>
	Encabezado de la encuesta
	<p class="text-right">
		<?php echo CHtml::link('<span class="glyphicon glyphicon-edit"></span> Editar', Yii::app()->createUrl('formulario/update/', array('id'=>$model->id_for)), array('class'=>'btn btn-primary', 'role'=>'button'));  ?>
	</p>
</p>
	<div class="well well-sm">
		<h2><?php echo $model->titulo; ?></h2>
	</div>
	<div class="well well-sm">
		<p><?php echo $model->contenido; ?></p>
	</div>
</div>

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
	<?php foreach ($model->preguntas as $pregunta): ?>
		<div class="well well-sm">
			<p class="text-right">
				<?php echo CHtml::link('<span class="glyphicon glyphicon-edit"></span> Editar', Yii::app()->createUrl('pregunta/update/', array('id'=>$pregunta->id_pre)), array('class'=>'btn btn-primary', 'role'=>'button'));  ?>
			</p>
			<h3><?php echo $pregunta->txtpre; ?></h3>
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
	<?php endforeach; ?>

	<div class="form-group">
		<div class="col-md-2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-primary btn-block')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
		