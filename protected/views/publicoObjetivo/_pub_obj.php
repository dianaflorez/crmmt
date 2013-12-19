<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
?>
<script>
$('#publico_objetivo').tooltip();
</script>

<div class="table-responsive">
	<table id='publico_objetivo' class="table table-bordered table-striped">
		<thead>
			<th>Nombre</th>
			<th class="hidden-xs">Descripción</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($publicos as $publico): ?>
			<tr>
				<td><?php echo $publico->nombre; ?></td>
				<td class="hidden-xs"><?php echo $publico->descripcion; ?></td>
				<td>
					<p class="text-center">
					   	<?php echo CHtml::link('<i class="fa fa-edit fa-2x fa-border"></i>', Yii::app()->createUrl('publicoobjetivo/update/', array('id'=>$publico->id_po)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
						<?php echo CHtml::link('<i class="fa fa-users fa-2x fa-border"></i>', Yii::app()->createUrl('publicoobjetivo/usuarios/', array('id'=>$publico->id_po)), array('data-toggle'=>'tooltip', 'title'=>"Ver usuarios"));  ?>
					</p>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>