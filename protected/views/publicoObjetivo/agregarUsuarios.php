
<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
	//$noMostrar = array('id_po', 'feccre', 'fecmod', 'id_usu');
	$noExiste = 'No registra';
?>
<script>
//$('#hola').tooltip();
</script>
	<div class="page-header">
	  <h2>Agregar usuarios <small>Público ojetivo (<?php echo $model->nombre; ?>)</small></h2>
	</div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'usuarios-form',
		'htmlOptions' => array('role'=>'form'),
		//'method'=>'GET',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Identificación', 'usuario_identificacion'); ?>
				<?php echo Chtml::textField('Usuario[identificacion]', null, array('class'=>'form-control', 'placeholder'=>'Identificación', 'id'=>'usuario_identificacion')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Nombres', 'usuario_nombres'); ?>
				<?php echo Chtml::textField('Usuario[nombre]', null, array('class'=>'form-control', 'placeholder'=>'Nombre', 'id'=>'usuario_nombres')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Apellidos', 'usuario_apellidos'); ?>
				<?php echo Chtml::textField('Usuario[apellido]', null, array('class'=>'form-control', 'placeholder'=>'Apellidos', 'id'=>'usuario_apellidos')); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<?php echo Chtml::submitButton('Filtrar', array('class'=>'btn btn-primary')); //$form->textField(General::model(),'nombre', array('class'=>'form-control', 'placeholder'=>'Nombre')); ?>
	</div>
	
<div class="pull-right">Resultados <?php echo $total; ?></div>	

<div class="table-responsive">
	<table id='hola' class="table table-bordered table-striped">
		<thead>
			<th>Identificación</th>
			<th>Apellidos</th>
			<th>Nombres</th>
			<th>Email</th>
			<th class="hidden-xs">Fecha de nacimiento</th>
			<th>Género</th>
			<th>Ocupación</th>
			<th>Estado civil</th>
			<th>Dirección</th>
			<th>País</th>
			<th></th>
			</thead>	
		<tbody>
			<?php foreach ($usuariosGeneral as $usuario): ?>
			<tr>
				<td><?php echo $usuario->id_char; ?></td>
				<td><?php echo $usuario->apellido1.' '.$usuario->apellido2; ?></td>
				<td><?php echo $usuario->nombre1.' '.$usuario->nombre2; ?></td>
				<td>
					<?php
						$cantidadEmails = count($usuario->emails);
						if($cantidadEmails > 0):
							echo $usuario->emails[0]->direccion;
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
				</td>
				<td class="hidden-xs">
					<?php 
						//var_dump($usuario->informacionPersonal);
						//if(property_exists('informacionPersonal', 'fecha_nacimiento')) 
						if($usuario->informacionPersonal) 
							echo $usuario->informacionPersonal->fecha_nacimiento; 
						else echo $noExiste; 
					?>
				</td>
				<td>
					<?php 
						if($usuario->informacionPersonal) 
							if($usuario->informacionPersonal->genero) echo 'Masculino'; else echo 'Femenino'; 
						else
							echo $noExiste;
					?>		
				</td>
				<td>
					<?php 
						if($usuario->informacionPersonal) 
							echo $usuario->informacionPersonal->ocupacion->nombre; 
						else echo $noExiste; 
					?>
				</td>
				<td>
					<?php 
						if($usuario->informacionPersonal) 
							echo $usuario->informacionPersonal->estadoCivil->descripcion; 
						else echo $noExiste; 
					?>
				</td>
				<td>
					<?php
						$cantidadDirecciones = count($usuario->direcciones);
						if($cantidadDirecciones > 0):
							echo $usuario->direcciones[0]->direccion;
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
				</td>
				<td><?php foreach ($usuario->direcciones as $direccion) {	echo $direccion->direccion; }  ?></td>
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

<?php
$this->widget('CLinkPager', array(
	'header' => '',
	'firstPageLabel' => '&lt;&lt;',
	'prevPageLabel' => '&lt;',
	'nextPageLabel' => '&gt;',
	'lastPageLabel' => '&gt;&gt;',
	'pages' => $pages,
	'htmlOptions' => array('class'=> 'pagination')
));

?>

<?php $this->endWidget(); ?>