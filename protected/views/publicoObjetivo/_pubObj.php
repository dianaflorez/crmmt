<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
?>
<script>
$('#publico_objetivo').tooltip();
</script>

<div class="table-responsive">
	<table id='publico_objetivo' class="table table-condensed table-hover">
		<thead>
			<th>Nombre</th>
			<th class="hidden-xs">Descripción</th>
			<th class="col-md-1"></th>
		</thead>
		<tbody>
			<?php foreach ($publicos as $publico): ?>
			<tr>
				<td><?php echo $publico->nombre; ?></td>
				<td class="hidden-xs"><?php echo $publico->descripcion; ?></td>
				<td>
					<div class="btn-group">
						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
						   <span class="fa fa-caret-down"></span>
						</a>
						<ul class="dropdown-menu">
							<li><?php echo CHtml::link('<i class="fa fa-edit fa-fw"></i> Editar', Yii::app()->createUrl('publicoObjetivo/update/', array('id'=>$publico->id_po)));  ?></li>
						  	<li><?php echo CHtml::link('<i class="fa fa-users fa-fw"></i> Ver usuarios', Yii::app()->createUrl('publicoObjetivo/usuarios/', array('id'=>$publico->id_po)));  ?></li>
						</ul>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>