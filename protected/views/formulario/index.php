<?php
/* @var $this FormularioController */
/* @var $dataProvider CActiveDataProvider */


?>

<div class="row">
	<!-- <div class="container"> -->
	<?php echo CHtml::link('<i class="fa fa-plus-circle"></i> Crear encuesta', Yii::app()->createUrl('formulario/create'), array('class'=>"btn btn-primary pull-right",'role'=>"button"));  ?>
	<!-- </div> -->
</div>

<div class="page-header">
	<h2>Encuestas <small>Ver todas</small></h2>
</div>


<div class="table-responsive">
	<table id='publico_objetivo' class="table table-condensed table-hover">
		<thead>
			<th class="col-md-1">Activa</th>
			<th class="col-md-1">Título</th>
			<th class="col-md-1">No. de preguntas</th>
			<th class="col-md-1">Han respondido</th>
			<!-- <th></th> -->
			<th class="col-md-1"></th>
		</thead>
		<tbody>
			<?php foreach ($formularios as $formulario): ?>
			<tr class="<?php //if(!$formulario->estado) echo 'info'; ?>">
				<td  style="text-align: center; vertical-align: middle;">
					<?php  if(!$formulario->estado): ?>
						<i class="fa fa-ban fa-lg"></i>
					<?php else: ?>
						<i class="fa fa-check-circle fa-lg"></i>
					<?php endif; ?>
				</td>
				<td><?php  echo $formulario->titulo; ?></td>
				<?php $numPreguntas = count($formulario->preguntas); ?>
				<td><?php echo $numPreguntas; ?></td>
				<?php $numUsuRespondieron = count($formulario->usuariosRespondidaFormulario()); ?> 
				<td><?php echo $numUsuRespondieron; ?></td>
				<td>
					<div class="btn-group">
						<?php //echo CHtml::link('<i class="fa fa-gear fa-fw"></i>', '', array('class'=>"btn btn-primary dropdown-toggle", 'data-toggle'=>"dropdown")); ?>
						<!-- <a class="btn btn-primary" href="#"><i class="fa fa-user fa-fw"></i> User</a> -->
						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
						   <span class="fa fa-caret-down"></span>
						</a>
						<ul class="dropdown-menu">
						  	<?php if($numUsuRespondieron === 0 && $formulario->estado): ?>
							    <li><?php echo CHtml::link('<i class="fa fa-edit fa-fw"></i> Editar', Yii::app()->createUrl('formulario/update/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?></li>
							    <li><?php echo CHtml::link('<i class="fa fa-plus-circle fa-fw"></i> Agregar pregunta', Yii::app()->createUrl('pregunta/create/', array('id_for'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Agregar pregunta"));  ?></li>   
							    <li class="divider"></li>
							    <?php if($numPreguntas > 0 && $formulario->estado): ?>
									<li><?php echo CHtml::link('<i class="fa fa-rocket fa-fw"></i> Enviar encuesta', Yii::app()->createUrl('formulario/enviar/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Revisar y enviar"));  ?></li>
						    	<?php endif; ?>	
						    <?php endif; ?>
						    <li><?php echo CHtml::link('<i class="fa fa-book fa-fw"></i> Reporte de resultados', Yii::app()->createUrl('formulario/resultado/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Reporte resultados"));  ?></li>
						   	<?php if($formulario->estado): ?>
							   	<li class="divider"></li>
							  	<li><?php echo CHtml::link('<i class="fa fa-ban fa-fw"></i> Desactivar encuesta', Yii::app()->createUrl('formulario/desactivar/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Desactivar", 'class'=>'desactivar'));  ?></li>
						  	<?php endif; ?>
						  	<li><?php echo CHtml::link('<i class="fa fa-plus fa-lg"></i>', Yii::app()->createUrl('formulario/encuesta/', array('id'=>$formulario->id_for, 'username'=> 'john')), array('data-toggle'=>'tooltip', 'title'=>"Ver encuesta"));  ?></li>
						</ul>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<script>
	$(document).on('ready', inicio);

	function inicio(){
		$('.desactivar').on('click', desactivar);
	}

	function desactivar(e){
		var respuesta = confirm("¿Está seguro? No puede deshacerse.");
		if (respuesta)
		    return true;
		else
		   	return false;
	}
</script>