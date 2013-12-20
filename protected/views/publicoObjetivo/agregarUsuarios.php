
<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
	//$noMostrar = array('id_po', 'feccre', 'fecmod', 'id_usu');
	$noExiste = 'No registra';
	$meses    = array(
		'1'  => 'Enero',
		'2'  => 'Febrero',
		'3'  => 'Marzo',
		'4'  => 'Abril',
		'5'  => 'Mayo',
		'6'  => 'Junio',
		'7'  => 'Julio',
		'8'  => 'Agosto',
		'9'  => 'Septiembre',
		'10' => 'Octubre',
		'11' => 'Noviembre',
		'12' => 'Diciembre'
	);

	$genero = array();
	//array_push($genero['id'], 
	$genero[1] = 'Masculino';
	$genero[0] = 'Femenino';

	$anhos = array();
	$year = date("Y") - 100; 
	//var_dump($year);
	for ($i = 0; $i <= 100; $i++) 
	{
		//echo "<option>$year</option>"; 
		//array_push($anhos, ''.$year);
		$anhos[$year] = $year;
		$year++;
	}
	//$anhos = array();
	//var_dump($anhos)
;	//for($i=0; $i < 1000)
?>
<script>
//$('#hola').tooltip();
</script>

<?php $this->renderPartial('_irPublico'); ?>

<div class="page-header">
  <h2><?php echo $model->nombre; ?> <small>Público objetivo</small></h2>
</div>

<ul class="nav nav-tabs nav-justified navegacion">
  <li><?php echo CHtml::link('<i class="fa fa-eye fa-lg"> Ver usuarios</i>', Yii::app()->createUrl('publicoobjetivo/usuarios/', array('id'=>$model->id_po))); ?></li>
  <li class="active"><?php echo CHtml::link('<i class="fa fa-plus-circle fa-lg"> Agregar usuarios</i>', Yii::app()->createUrl('publicoobjetivo/agregarUsuarios/', array('id'=>$model->id_po))); ?></li>
</ul>

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
				<?php echo CHtml::label('Nombres', 'Usuario_nombres'); ?>
				<?php echo Chtml::textField('Usuario[nombre]', null, array('class'=>'form-control', 'placeholder'=>'Nombre', 'id'=>'Usuario_nombres')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Apellidos', 'Usuario_apellidos'); ?>
				<?php echo Chtml::textField('Usuario[apellido]', null, array('class'=>'form-control', 'placeholder'=>'Apellidos', 'id'=>'Usuario_apellidos')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Género', 'Usuario_genero'); ?>
				<div class="form-group">
					<?php echo CHtml::dropDownList('Usuario[genero]', null, $genero, array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Fecha nacimiento', ''); ?>
				<div class="form-group">
				<?php echo CHtml::label('Mes', 'Usuario_mes_nacimiento]'); ?>
				<?php echo CHtml::dropDownList('Usuario[mes_nacimiento]', '1', $meses, array('disabled'=>'disabled')); ?>
				<?php echo CHtml::label('Año', 'Usuario_anho_nacimiento]'); ?>
				<?php echo CHtml::dropDownList('Usuario[anho_nacimiento]', 2013, $anhos, array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<?php echo CHtml::label('Edad', ''); ?>
				<div class="form-group">
				<?php echo CHtml::label('Desde', 'Usuario_fecha_inicio'); ?>
				<?php echo CHtml::dateField('Usuario[fecha_inicio]', date('Y-m-d'), array('class'=>"", 'name'=> 'fecha_inicio', 'disabled'=>'disabled')); ?>
				<?php echo CHtml::label('Hasta', 'Usuario_fecha_fin'); ?>
				<?php echo CHtml::dateField('Usuario[fecha_fin]', date('Y-m-d'), array('class'=>"", 'name'=> 'fecha_fin', 'disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Ocupación', 'Usuario_ocupacion'); ?>
				<div class="form-group">
				<?php echo CHtml::dropDownList('Usuario[ocupacion]', null, CHtml::ListData($ocupacion, 'id_ocu', 'nombre'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Estado civil', 'Usuario_estado_civil'); ?>
				<div class="form-group">
					<?php echo CHtml::dropDownList('Usuario[estado_civil]', null, CHtml::ListData($estadoCivil, 'id_estado_civil', 'descripcion'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo CHtml::label('Lugar donde vive', ''); ?>
				<div class="form-group">
				<?php echo CHtml::label('Departamento', 'Usuario_departamento'); ?>
				<?php echo CHtml::dropDownList('Usuario[departamento]', null, CHtml::ListData($departamento, 'id_dep', 'nombre'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
				<div class="form-group">
				<?php echo CHtml::label('Pais', 'Usuario_pais'); ?>
				<?php echo CHtml::dropDownList('Usuario[pais]', null, CHtml::ListData($pais, 'id_pais', 'nombre'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
			<?php echo Chtml::submitButton('Filtrar', array('class'=>'btn btn-primary')); //$form->textField(General::model(),'nombre', array('class'=>'form-control', 'placeholder'=>'Nombre')); ?>
			</div>
		</div>
	</div>
	
<div class="pull-right">Resultados <?php echo $total; ?></div>	

<div class="table-responsive">
	<table id='registrosUsuarios' class="table table-bordered table-striped">
		<thead>
			<th></th>
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
			<?php 
					$activo = false;
					foreach ($model->usuarios as $value)
					{
						if($value->id_usupo == $usuario->id)
						{
							$activo = true;
							break;
						}
					}
			?> 
			<tr <?php echo 'id="'.$usuario->id.'"'; echo 'data-idpo="'.$model->id_po.'" '; if($activo){ echo 'class="success"'; } ?> >
				<td>
					<?php if(!$activo): ?>
					<?php echo CHtml::checkBox('Usuarios[agregar]', $activo, array('class'=>'','data-idpo'=>$model->id_po, 'id'=>'chk_'.$usuario->id, 'value'=>$usuario->id)); ?>
					<?php endif; ?>
				</td>
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
				<td><?php foreach ($usuario->direcciones as $direccion) {	echo $direccion->pais->nombre; }  ?></td>
				<td>
					<p class="text-center">
					<?php if(!$activo && $cantidadEmails > 0): ?>
					<?php echo CHtml::link('<i class="fa fa-plus fa-lg"></i>', null ,array('class'=>'btn btn-primary activacion', 'id'=>'btn_'.$usuario->id, 'data-toggle'=>'tooltip', 'title'=>"Activar"));  ?>
					 <?php endif; ?>
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


<script>
	$(document).on('ready', iniciar());

	function iniciar(){
		$('#registrosUsuarios .activacion').on('click', activar);
	}

	function activar(e){
		var fila = $(e.target).parent().closest('tr');
		//debugger;
		var id_po = fila.data('idpo');
		var id_usupo = fila.attr("id");
		
		var peticion = $.ajax({
			url: "<?php echo Yii::app()->createUrl('publicoobjetivo/agregar'); ?>",
			type: "POST",
			data: 
			{ 
				id_po : id_po,
				id_usupo: id_usupo,
			},
			dataType: "html"
		});
		 
		peticion.done(function( msg ) {
			console.log('exito '+msg);
			fila.addClass('success');
			$('#btn_'+id_usupo).hide();
			$('#chk_'+id_usupo).hide();
		});
		 
		peticion.fail(function( jqXHR, textStatus ) {
			console.log('fallo '+textStatus);
			fila.addClass('warning');
			var foo = function (){
				fila.removeClass('warning');
			};
			setTimeout(foo, 1500);
		});

		e.preventDefault();
		console.log('El turbo activado');
	}
</script>
