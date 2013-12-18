
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
<div class="page-header">
  <h2><?php echo $model->nombre; ?> <small>Público objetivo</small></h2>
</div>

<div class="row">
	<div class="container">
	<?php echo CHtml::link('<i class="fa fa-arrow-circle-up fa-lg"> Públicos objetivo</i>', Yii::app()->createUrl('publicoobjetivo/'), array('class'=>"btn btn-primary pull-right",'role'=>"button"));  ?>
	</div>
</div>

<ul class="nav nav-tabs nav-justified navegacion">
  <li class="active"><?php echo CHtml::link('<i class="fa fa-eye fa-lg"> Ver usuarios</i>', Yii::app()->createUrl('publicoobjetivo/usuarios/', array('id'=>$model->id_po))); ?>
</li>
  <li><?php echo CHtml::link('<i class="fa fa-plus-circle fa-lg"> Agregar usuarios</i>', Yii::app()->createUrl('publicoobjetivo/agregarUsuarios/', array('id'=>$model->id_po))); ?></li>
</ul>

<div class="table-responsive">
	<table id='hola' class="table table-bordered table-striped">
		<thead>
			<th>Identificación</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th class="hidden-xs">Fecha de nacimiento</th>
			<th>Género</th>
			<th>Ocupación</th>
			<th>Estado civil</th>
			<th>Dirección</th>
			<th>País</th>
			<th>Estado</th>
			<th></th>
			</thead>
		<tbody>
			<?php foreach ($model->usuarios as $usuario): ?>
			<tr>
				<td><?php echo $usuario->general->id_char; ?></td>
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
				<td><?php foreach ($usuario->general->direcciones as $direccion) {	echo $direccion->direccion;	}  ?></td>
				<td><?php foreach ($usuario->general->direcciones as $direccion) {	echo $direccion->pais->nombre; }  ?></td>
				<td><?php if($usuario->estado) echo 'Activo'; else echo 'Desactivado'; ?></td>
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