<?php
/* @var $this CampanaController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row">
	<!-- <div class="container"> -->
	<?php echo CHtml::link('<i class="fa fa-plus-circle"></i> Crear campaña', Yii::app()->createUrl('campana/create'), array('class'=>"btn btn-primary pull-right",'role'=>"button"));  ?>
	<!-- </div> -->
</div>

<div class="page-header">
	<h2>Campañas <small>Ver todas</small></h2>
</div>


<div class="table-responsive">
	<table id="publico_objetivo" class="table table-condensed table-hover">
		<thead>
			<th class="col-md-1">Enviada</th>
			<th>Asunto</th>
			<!-- <th>Fecha de envio</th> -->
			<th class="col-md-1">Tipo</th>
			<!-- <th class="col-md-1"></th> -->
			<th class="col-md-2"></th>
		</thead>
		<tbody>
			<?php foreach ($campanas as $campana): ?>
			<tr class="<?php if($campana->estado) echo 'info'; ?>">
				<td  style="text-align: center; vertical-align: middle;">
					<?php  if($campana->estado): ?>
						<i class="fa fa-check-circle fa-lg"></i>
					<?php else: ?>
					<!-- <i class="fa fa-circle-o fa-lg"></i> -->
					<?php endif; ?>
				</td>
				<td><?php  echo $campana->asunto; ?></td>
				<td><?php  echo ucfirst($campana->tipoCampana->nombre); ?></td>
				<td>
					<p class="text-center">
					   	<?php if(!$campana->estado) echo CHtml::link('<i class="fa fa-edit fa-lg"></i>', Yii::app()->createUrl('campana/update/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
						<?php if($campana->tipoCampana->nombre === 'email'): 
								echo CHtml::link('<i class="fa fa-copy fa-lg"></i>', Yii::app()->createUrl('campana/duplicar/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Duplicar")); ?>
						<?php	if(!$campana->estado): 
							  		echo CHtml::link('<i class="fa fa-rocket fa-lg"></i>', Yii::app()->createUrl('campana/enviar/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Enviar"));  
								else:
									echo CHtml::link('<i class="fa fa-users fa-lg"></i>', Yii::app()->createUrl('campana/usuariosCampana/', array('id_cam'=>$campana->id_cam)), array('data-idcam'=>$campana->id_cam, 'class'=>'usuarios_campana', 'data-toggle'=>'tooltip', 'title'=>"A quienes se envió"));  

							  	endif;
							endif;	?>
						<?php echo CHtml::link('<i class="fa fa-trash-o fa-lg"></i>', Yii::app()->createUrl('campana/delete/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Eliminar", 'class'=>'eliminar'));  ?>	
					</p>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>


<!-- Modal -->
<div class="modal fade" id="usuariosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        	<h4 class="modal-title" id="myModalLabel">Respondieron la encuesta</h4>
	      	</div>
	      	<div id="grilla_usuarios"class="modal-body">
	      		<?php 
	      			// Solo para que cargue el plugin de búsqueda de las CGridView.
	      			$dummy = new General;
	      			$this->widget('zii.widgets.grid.CGridView', array('dataProvider'  => $dummy->search(), 'filter' => $dummy)); 
	      		?>
	        </div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
	    </div><!-- /.modal-content -->
	 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	$(document).on('ready', inicio);

	function inicio(){
		$('.usuarios_campana').on('click', consultarUsuarios);
		$('.eliminar').on('click', clicUsuario);
	}

	function eliminar(e){
		var respuesta = confirm("¿Está seguro? No puede deshacerse.");
		if (respuesta)
		    return true;
		else
		   	return false;
	}

	function clicUsuario(e){
		e.preventDefault();	
		var respuesta = confirm("¿Está seguro? No puede deshacerse.");
		if (respuesta){
			var target = $(e.target);
		   	var fila = target.parent().closest('tr');
		  	var link = target.closest('a');
		   	var url = $(link).attr("href");
		   	eliminarCampana(fila, url);
		}
	}

	function eliminarCampana(fila, url){
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

	function consultarUsuarios(e){
		e.preventDefault();
		
		var vinculo = $(e.target).parent().closest('a');
		var url = vinculo.attr('href');
		
		var peticion = $.ajax({
			url: url,
			type: 'GET',
			dataType: 'html'
		});
		 
		peticion.done(function( msg ) {
			$('#grilla_usuarios').html(msg);
			$('#usuariosModal').modal();
		});
		 
		peticion.fail(function( jqXHR, textStatus ) {
			// TODO
		});
	}
</script>