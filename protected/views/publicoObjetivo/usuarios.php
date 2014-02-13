
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
  <li class="active"><?php echo CHtml::link('<i class="fa fa-users"></i>  Ver usuarios', Yii::app()->createUrl('publicoObjetivo/usuarios/', array('id'=>$model->id_po))); ?>
</li>
  <li><?php echo CHtml::link('<i class="fa fa-plus-circle"></i> Agregar usuarios', Yii::app()->createUrl('publicoObjetivo/agregarUsuarios/', array('id'=>$model->id_po))); ?></li>
</ul>
<div class="row">
	<div class="container">
		<?php $this->renderPartial('_usuariosPublico', array('model'=>$usuarios,'usuariosId'=>$usuariosId, 'ajaxUrl'=>$this->createUrl('/publicoObjetivo/usuarios', array('id' => $model->id_po)), 'id_po'=>$model->id_po)); ?>
	</div>
</div>


<script>
	$(document).on('ready', iniciar());

	function iniciar(){
		$(document).on('click', '.activacion', clicUsuario);
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
			url: "<?php echo Yii::app()->createUrl('usuarioPublicoObjetivo/delete'); ?>",
			type: "POST",
			data: 
			{ 
				id_po : id_po,
				id_usupo: id_usupo,
			},
			dataType: 'html'
		});
		 
		peticion.done(function( msg ) {
			fila.slideUp('slow');
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