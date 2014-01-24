
<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
	$noExiste = 'No registra';
	$noMostrar = array('id_po', 'feccre', 'fecmod', 'id_usu');
?>
<script>
//$('#hola').tooltip();
</script>
<?php $this->renderPartial('_irPublico'); ?>

<div class="page-header">
  <h2><?php echo $model->nombre; ?> <small>Público objetivo</small></h2>
</div>

<ul class="nav nav-tabs nav-justified navegacion">
  <li class="active"><?php echo CHtml::link('<i class="fa fa-users fa-lg"> Ver usuarios</i>', Yii::app()->createUrl('publicoobjetivo/usuarios/', array('id'=>$model->id_po))); ?>
</li>
  <li><?php echo CHtml::link('<i class="fa fa-plus-circle fa-lg"> Agregar usuarios</i>', Yii::app()->createUrl('publicoobjetivo/agregarUsuarios/', array('id'=>$model->id_po))); ?></li>
</ul>
<div class="row">
	<div class="container">
		<?php $this->renderPartial('_usuariosPublico', array('model'=>$usuarios,'usuariosId'=>$usuariosId, 'ajaxUrl'=>$this->createUrl('/publicoobjetivo/usuarios', array('id' => $model->id_po)), 'id_po'=>$model->id_po)); ?>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
			<th class="hidden-xs">Identificación</th>
			<th>email</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th class="hidden-xs">Fecha de nacimiento</th>
			<th>Género</th>
			<th>Ocupación</th>
			<th>Estado civil</th>
			<th>Dirección</th>
			<th>País</th>
			<th>Activo</th>
			<th></th>
			</thead>
		<tbody>
			<?php foreach ($model->usuarios as $usuario): ?>
			<tr>
				<td class="hidden-xs"><?php echo $usuario->general->id_char; ?></td>
				<td>
					<?php
						$cantidadEmails = count($usuario->general->emails);
						if($cantidadEmails > 0):
							echo $usuario->general->emails[0]->direccion;
							if($cantidadEmails > 1): 
					?>
							<span class="badge pull-right">
								<?php echo $cantidadEmails; ?>
							</span>
					<?php
							endif;			
						else:
							echo $noExiste;
						endif;
					?>
					<?php //foreach ($usuario->general->emails as $email): ?>
				 	<?php //echo $usuario->general->emails[0]->direccion; ?>
				  	<?php //endforeach; ?>
				</td>
				<td><?php echo $usuario->general->nombre1.' '.$usuario->general->nombre2; ?></td>
				<td><?php echo $usuario->general->apellido1.' '.$usuario->general->apellido2; ?></td>
				<td class="hidden-xs">
					<?php 
						if($usuario->general->informacionPersonal) 
							echo $usuario->general->informacionPersonal->fecha_nacimiento;
						else
							echo $noExiste;
					?>
				</td>
				<td>
					<?php 
						if($usuario->general->informacionPersonal)
						{
							if($usuario->general->informacionPersonal->genero) 
								echo 'Masculino'; 
							else 
								echo 'Femenino'; 
						}
						else{
							echo $noExiste;
						}
					?>
				</td>
				<td>
					<?php 
						if($usuario->general->informacionPersonal) 
							echo $usuario->general->informacionPersonal->ocupacion->nombre;
						else
							echo $noExiste;
					?>
				</td>
				<td>
					<?php 
						if($usuario->general->informacionPersonal) 
							echo $usuario->general->informacionPersonal->estadoCivil->descripcion;
						else
							echo $noExiste;
					?>
				</td>
				<td>
					<?php
						$cantidadDirecciones = count($usuario->general->direcciones);
						if($cantidadDirecciones > 0):
							echo $usuario->general->direcciones[0]->direccion;
							if($cantidadDirecciones > 1): 
					?>
							<span class="badge pull-right">
								<?php echo $cantidadDirecciones; ?>
							</span>
					<?php
							endif;			
						else:
							echo $noExiste;
						endif;
					?>
					<?php //foreach ($usuario->general->direcciones as $direccion) {	echo $direccion->direccion;	}  ?></td>
				<td><?php foreach ($usuario->general->direcciones as $direccion) {	echo $direccion->pais->nombre; }  ?></td>
				<td>
					<p class="text-center">
						<?php if($usuario->estado): ?>
						<i class="fa fa-check-circle-o fa-lg"></i>'
						<?php else: ?>
						<i class="fa fa-circle-o fa-lg"></i>
						<?php endif; ?>
					</p>
				</td>
				<td>
					<p class="text-center">
					<?php //echo CHtml::link('<span class="glyphicon glyphicon-edit"></span>', Yii::app()->createUrl('publicoobjetivo/update/', array('id'=>$usuario->id_po)), array('data-toggle'=>'tooltip', 'title'=>"Activar"));  ?>
					<?php //echo CHtml::link('<span class="glyphicon glyphicon-user"></span>', Yii::app()->createUrl('publicoobjetivo/usuarios/', array('id'=>$usuario->id_po)), array('data-toggle'=>'tooltip', 'title'=>"Desactivar"));  ?>
					</p>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script>
	$(document).on('ready', iniciar());

	function iniciar(){
		//$('#registrosUsuarios .activacion').on('click', activarUsuario);
		//$('.activacion').on('click', activarUsuario);
		$(document).on('click', '.activacion', clicUsuario);
		// $('#Usuario_pais').on('change', consultarDepartamentos);
		// $('#activarEdad').on('click', habilitarFechas);
		// $('#agregarSeleccion').on('click', usuariosSeleccionados);

		// $('#Usuario_departamento').prop('disabled', false);
		// $('#departamentos').hide();
	}


	function clicUsuario(e){
		e.preventDefault();
		//console.log('al menos');
		var fila = $(e.target).parent().closest('tr');
		var id_po = fila.data('idpo');
		var id_usupo = fila.attr('id');
		activarUsuario(fila, id_po, id_usupo);
	}

	function activarUsuario(fila, id_po, id_usupo){
		console.log('inicio activar'+id_po+' '+id_usupo);
	
		var peticion = $.ajax({
			url: "<?php echo Yii::app()->createUrl('usuariopublicoobjetivo/delete'); ?>",
			type: "POST",
			data: 
			{ 
				id_po : id_po,
				id_usupo: id_usupo,
			},
			dataType: 'html'
		});
		 
		peticion.done(function( msg ) {
			//console.log('exito '+msg);
			//fila.addClass('success');
			fila.slideUp('slow');
			//var checkbox = fila.find("input:first");//.prop("disabled", true);
			//checkbox.prop("disabled", true);
			//checkbox.prop("checked", false);
			//fila.children("input").prop("disabled", true);
			//$("input.group1")
			//$('#btn_'+id_usupo).hide();
			//$('#chk_'+id_usupo).hide();
		});
		 
		peticion.fail(function( jqXHR, textStatus ) {
			//console.log('fallo '+textStatus);
			fila.addClass('warning');
			var quitarFila = function (){
				fila.removeClass('warning');
			};
			setTimeout(quitarFila, 1500);
		});

		
		
	}
</script>