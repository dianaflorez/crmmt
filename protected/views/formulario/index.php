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
			<th>Título</th>
			<th>Han respondido</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($formularios as $formulario): ?>
			<tr class="<?php if($formulario->estado) echo 'info'; ?>">
				<td><?php  echo $formulario->titulo; ?></td>
				<td><?php $numUsuRespondieron = count($formulario->usuariosRespondidaFormulario()); ?> 
					<?php echo $numUsuRespondieron; ?></td>
				<td>
					<p class="text-center">						
					   	<?php if($numUsuRespondieron === 0) echo CHtml::link('<i class="fa fa-edit fa-lg"></i>', Yii::app()->createUrl('formulario/update/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
						<?php if($numUsuRespondieron === 0) echo CHtml::link('<i class="fa fa-plus-circle fa-lg"></i>', Yii::app()->createUrl('pregunta/create/', array('id_for'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Agregar pregunta"));  ?>
						<?php /*if($numUsuRespondieron === 0)*/ //echo CHtml::link('<i class="fa fa-plus fa-lg"></i>', Yii::app()->createUrl('formulario/encuesta/', array('id'=>$formulario->id_for, 'username'=> 'john')), array('data-toggle'=>'tooltip', 'title'=>"Ver encuesta"));  ?>
						<?php if($numUsuRespondieron === 0) echo CHtml::link('<i class="fa fa-rocket fa-lg"></i>', Yii::app()->createUrl('formulario/enviar/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Revisar y enviar"));  ?>
						<?php echo CHtml::link('<i class="fa fa-book fa-lg"></i>', Yii::app()->createUrl('formulario/resultado/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Reporte resultados"));  ?>
						<?php echo CHtml::link('<i class="fa fa-ban fa-lg"></i>', Yii::app()->createUrl('formulario/desactivar/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Desactivar"));  ?>
					</p>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

