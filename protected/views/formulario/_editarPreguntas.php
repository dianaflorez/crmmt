<?php foreach ($model->preguntas as $pregunta): ?>
	<div class="row" id="<?php echo $pregunta->id_pre; ?>">
		<div class="col-md-12">
			<div class="form-group pull-right">
				<?php echo CHtml::link('<i class="fa fa-trash-o"></i>', Yii::app()->createUrl('pregunta/delete', array('id'=>$pregunta->id_pre)), array('class'=>"btn btn-primary eliminar",'role'=>"button"));  ?>
			</div>
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
<script type="text/javascript">	
	$('.eliminar').on('click', clicUsuario);
	
	function clicUsuario(e){
		e.preventDefault();	
		var respuesta = confirm("¿Está seguro? No puede deshacerse.");
		if (respuesta){
			var target = $(e.target);
		   	var fila = target.parent().closest('div.row');
		  	var link = target.closest('a');
		   	var url = $(link).attr("href");
		   	eliminar(fila, url);
		}
	}

	function eliminar(fila, url){
		var peticion = $.ajax({
			url: url,
			type: "POST",
			dataType: 'html'
		});
		 
		peticion.done(function( msg ) {
			fila.fadeOut('slow');
		});
		 
		peticion.fail(function( jqXHR, textStatus ) {
			fila.addClass('warning');
			var quitarFila = function (){
				fila.removeClass('warning');
			};
			setTimeout(quitarFila, 1500);
		});
	}

</script>	