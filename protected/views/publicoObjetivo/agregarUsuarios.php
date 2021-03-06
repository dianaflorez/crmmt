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
		$anhos[$year] = $year;
		$year++;
	}

?>

<?php $this->renderPartial('_irPublico'); ?>

<style type="text/css">
	@media (max-width: 2048px) {
		  .table-responsive {
		    width: 100%;
		    margin-bottom: 15px;
		    overflow-x: scroll;
		    overflow-y: hidden;
		    -webkit-overflow-scrolling: touch;
		    -ms-overflow-style: -ms-autohiding-scrollbar;
		    border: 1px solid #ddd;
		  }
		  .table-responsive > .table {
		    margin-bottom: 0;
		  }
		  .table-responsive > .table > thead > tr > th,
		  .table-responsive > .table > tbody > tr > th,
		  .table-responsive > .table > tfoot > tr > th,
		  .table-responsive > .table > thead > tr > td,
		  .table-responsive > .table > tbody > tr > td,
		  .table-responsive > .table > tfoot > tr > td {
		    white-space: nowrap;
		  }
		  .table-responsive > .table-bordered {
		    border: 0;
		  }
		  .table-responsive > .table-bordered > thead > tr > th:first-child,
		  .table-responsive > .table-bordered > tbody > tr > th:first-child,
		  .table-responsive > .table-bordered > tfoot > tr > th:first-child,
		  .table-responsive > .table-bordered > thead > tr > td:first-child,
		  .table-responsive > .table-bordered > tbody > tr > td:first-child,
		  .table-responsive > .table-bordered > tfoot > tr > td:first-child {
		    border-left: 0;
		  }
		  .table-responsive > .table-bordered > thead > tr > th:last-child,
		  .table-responsive > .table-bordered > tbody > tr > th:last-child,
		  .table-responsive > .table-bordered > tfoot > tr > th:last-child,
		  .table-responsive > .table-bordered > thead > tr > td:last-child,
		  .table-responsive > .table-bordered > tbody > tr > td:last-child,
		  .table-responsive > .table-bordered > tfoot > tr > td:last-child {
		    border-right: 0;
		  }
		  .table-responsive > .table-bordered > tbody > tr:last-child > th,
		  .table-responsive > .table-bordered > tfoot > tr:last-child > th,
		  .table-responsive > .table-bordered > tbody > tr:last-child > td,
		  .table-responsive > .table-bordered > tfoot > tr:last-child > td {
		    border-bottom: 0;
	}
}
</style>
<div class="page-header">
  	<h2><?php echo $model->nombre; ?> <small>Público objetivo</small></h2>
</div>

<ul class="nav nav-tabs nav-justified navegacion">
  	<li><?php echo CHtml::link('<i class="fa fa-users"></i> Ver usuarios', Yii::app()->createUrl('publicoObjetivo/usuarios/', array('id'=>$model->id_po))); ?></li>
  	<li class="active"><?php echo CHtml::link('<i class="fa fa-plus-circle"></i> Agregar usuarios', Yii::app()->createUrl('publicoObjetivo/agregarUsuarios/', array('id'=>$model->id_po))); ?></li>
</ul>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'usuarios-form',
		'htmlOptions' => array('role'=>'form'),
		'method'=>'POST',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<?php echo $form->hiddenField($model,'id_po', array('class'=>'form-control', 'type'=>'hidden')); ?>
	<!-- <div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Identificación', 'usuario_identificacion'); ?>
				<?php //echo Chtml::textField('Usuario[identificacion]', null, array('class'=>'form-control', 'placeholder'=>'Identificación', 'id'=>'usuario_identificacion')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Nombres', 'Usuario_nombres'); ?>
				<?php //echo Chtml::textField('Usuario[nombre]', null, array('class'=>'form-control', 'placeholder'=>'Nombre', 'id'=>'Usuario_nombres')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Apellidos', 'Usuario_apellidos'); ?>
				<?php //echo Chtml::textField('Usuario[apellido]', null, array('class'=>'form-control', 'placeholder'=>'Apellidos', 'id'=>'Usuario_apellidos')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Género', 'Usuario_genero'); ?>
				<div class="form-group">
					<?php //echo CHtml::dropDownList('Usuario[genero]', null, $genero, array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div> -->

	<!-- <div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Fecha nacimiento', ''); ?>
				<div class="form-group">
				<?php //echo CHtml::label('Mes', 'Usuario_mes_nacimiento]'); ?>
				<?php //echo CHtml::dropDownList('Usuario[mes_nacimiento]', '1', $meses, array('disabled'=>'disabled')); ?>
				<?php //echo CHtml::label('Año', 'Usuario_anho_nacimiento]'); ?>
				<?php //echo CHtml::dropDownList('Usuario[anho_nacimiento]', 2013, $anhos, array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
	</div> -->

	<div class="row">
		<div class="col-md-offset-1 col-md-11">
			<div class="form-group">
				<?php echo CHtml::label('Edad', ''); ?>
				<?php echo CHtml::checkBox('', false, array('id' => 'activarEdad')); ?>
				<div class="form-inline">
					<div class="form-group">
					<?php echo CHtml::label('Desde', 'Usuario_fecha_inicio'); ?>
					<?php echo CHtml::dateField('Usuario[fecha_inicio]', $fechaInicio ? $fechaInicio : date('Y-m-d'), array('class'=>"", 'name'=> 'fecha_inicio', 'disabled'=>'disabled')); ?>
					</div>
					<div class="form-group">
					<?php echo CHtml::label('Hasta', 'Usuario_fecha_fin'); ?>
					<?php echo CHtml::dateField('Usuario[fecha_fin]', $fechaFin ? $fechaFin : date('Y-m-d'), array('class'=>"", 'name'=> 'fecha_fin', 'disabled'=>'disabled')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- 	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Ocupación', 'Usuario_ocupacion'); ?>
				<div class="form-group">
				<?php //echo CHtml::dropDownList('Usuario[ocupacion]', null, CHtml::ListData($ocupacion, 'id_ocu', 'nombre'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Estado civil', 'Usuario_estado_civil'); ?>
				<div class="form-group">
					<?php //echo CHtml::dropDownList('Usuario[estado_civil]', null, CHtml::ListData($estadoCivil, 'id_estado_civil', 'descripcion'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php //echo CHtml::label('Lugar donde vive', ''); ?>
				<div id= "departamentos" class="form-group">
				<?php //echo CHtml::label('Departamento', 'Usuario_departamento'); ?>
				<?php //echo CHtml::dropDownList('Usuario[departamento]', null, array(), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
				<div class="form-group">
				<?php //echo CHtml::label('Pais', 'Usuario_pais'); ?>
				<?php //echo CHtml::dropDownList('Usuario[pais]', null, CHtml::ListData($pais, 'id_pais', 'nombre'), array('prompt' => 'Seleccione', 'class'=> 'form-control')); ?>
				</div>
			</div>
		</div>
	</div> -->

	<div class="row">
		<div class="col-sm-offset-3 col-sm-6 col-md-offset-1 col-md-3">
			<div class="form-group">
				<?php echo Chtml::submitButton('Filtrar', array('class'=>'btn btn-primary btn-block')); ?>
			</div>
		</div>
	</div>


<?php $this->endWidget(); ?>

<div class="row">
	<div class="col-sm-offset-3 col-sm-6 col-md-offset-1 col-md-3">
		<!-- <div class="col-md-offset-6 col-md-6"> -->
			<div class="form-group">
			<?php echo CHtml::button('Agregar selección', array('id'=>'agregarSeleccion', 'class'=>'btn btn-default  btn-block'));  ?>
			</div>
		<!-- </div> -->
	</div>
</div>
<div class="row">
	<div class="container">
		<div class="alert alert-warning fade in" style="display: none;">
        	Selecciones un usuario como mínimo.
      </div>
	</div>
	<div class="container">
	<?php $this->renderPartial('_usuariosAgregar', array('proveedorDatos'=>$proveedorDatos, 'model'=>General::model(), 'ajaxUrl'=>$this->createUrl('/publicoObjetivo/admin', array('id_po'=>$model->id_po)), 'id_po'=>$model->id_po)); ?>
	</div>
</div>


<script>
	$(document).on('ready', iniciar());

	function iniciar(){
		//$('#registrosUsuarios .activacion').on('click', activarUsuario);
		//$('.activacion').on('click', activarUsuario);
		$(document).on('click', '.activacion', clicUsuario);
		$('#Usuario_pais').on('change', consultarDepartamentos);
		$('#activarEdad').on('click', habilitarFechas);
		$('#agregarSeleccion').on('click', usuariosSeleccionados);

		$('#Usuario_departamento').prop('disabled', false);
		$('#departamentos').hide();
	}

	function habilitarFechas(){
		//console.log('habilitar');
		if($('#activarEdad').prop('checked')){
			$('#Usuario_fecha_inicio').prop('disabled', false);
			$('#Usuario_fecha_fin').prop('disabled', false);
		}else{
			$('#Usuario_fecha_inicio').prop('disabled', true);
			$('#Usuario_fecha_fin').prop('disabled', true);
		}
	}
	

	function consultarDepartamentos(e){
		//console.log('Cambio '+e.target.value);

		var peticion = $.ajax({
			url: "<?php echo Yii::app()->createUrl('publicoObjetivo/departamentos'); ?>",
			type: "GET",
			data: 
			{ 
				id : e.target.value,
			},
			dataType: 'json'
		});
		 
		peticion.done(function( msg ) {
			console.log('exito '+msg);
			agregarDepartamentos(msg);
		});
		 
		peticion.fail(function( jqXHR, textStatus ) {
			console.log('fallo '+textStatus);
		});
	}

	function agregarDepartamentos(datos){
		var departamentos = $('#Usuario_departamento');
		departamentos.empty();
		if(datos.length === 0){
			$('#Usuario_departamento').prop('disabled', true);
			$('#departamentos').hide();
			return 0;
		}
		$('#Usuario_departamento').prop('disabled', false);
		$('#departamentos').show();
		
		departamentos.prepend($('<option />').val('').text('Seleccione'));
		$.each(datos, function() {
		    departamentos.append($('<option />').val(this.id_dep).text(this.nombre));
		});
	}

	function usuariosSeleccionados(){
		var checkboxes = $("input[name='usuarios[]']:checked");
		if(checkboxes.length === 0 ){
			//$(".alert").alert();
			$(".alert").slideDown();
			var quitarAlerta = function (){
				$(".alert").slideUp();
			};
			setTimeout(quitarAlerta, 2000);
			return false;
		}
		$.each(checkboxes, function(index, checkbox) {
		   console.log(checkbox);
		    var fila = $(checkbox).parent().closest('tr');
			var id_po = $('#PublicoObjetivo_id_po').val();
			var id_usupo = fila.attr('id');
			activarUsuario(fila, id_po, id_usupo);
			console.log(id_po+' '+id_usupo);
		});
		
		//return checkboxes;
	}

	function clicUsuario(e){
		e.preventDefault();
		//console.log('al menos');
		var fila = $(e.target).parent().closest('tr');
		var id_po = $('#PublicoObjetivo_id_po').val();
		var id_usupo = fila.attr('id');
		activarUsuario(fila, id_po, id_usupo);
	}

	function activarUsuario(fila, id_po, id_usupo){
		console.log('inicio activar');
		// var fila = $(e.target).parent().closest('tr');
		// var id_po = $('#PublicoObjetivo_id_po').val();
		// var id_usupo = fila.attr('id');
		
		var peticion = $.ajax({
			url: "<?php echo Yii::app()->createUrl('publicoObjetivo/agregar'); ?>",
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
			fila.addClass('success');
			var checkbox = fila.find("input:first");//.prop("disabled", true);
			checkbox.prop("disabled", true);
			checkbox.prop("checked", false);
			//fila.children("input").prop("disabled", true);
			//$("input.group1")
			$('#btn_'+id_usupo).hide();
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

		
		console.log('El turbo activado');
	}
</script>
