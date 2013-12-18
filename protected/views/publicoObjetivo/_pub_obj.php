<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
	$noMostrar = array('id_po', 'feccre', 'fecmod', 'id_usu');
?>
<script>
$('#hola').tooltip();
</script>

<div class="table-responsive">
	<table id='hola' class="table table-bordered table-striped">
		<thead>
		<?php foreach (PublicoObjetivo::model()->getAttributes() as $atributo => $valor): ?>
		<?php	if(!in_array($atributo, $noMostrar)): ?>
			<th><?php echo PublicoObjetivo::model()->getAttributeLabel($atributo); ?></th>
		<?php endif; ?>
		<?php endforeach; ?>
			<th></th>
			
		</thead>
		<tbody>
			<?php foreach ($publicos as $publico): ?>
			<tr>
				<?php foreach ($publico->getAttributes() as $atributo => $valor): ?>
				<?php	if(!in_array($atributo, $noMostrar)): ?>			
				<td>
					<?php echo $valor; ?>
				</td>
				<?php endif; ?>
				<?php endforeach; ?>
				<td>
					

					<!-- <ul class="list-group">
						<li class="list-group-item"> -->
						<p class="text-center">
					   		<?php echo CHtml::link('<i class="fa fa-edit fa-2x fa-border"></i>', Yii::app()->createUrl('publicoobjetivo/update/', array('id'=>$publico->id_po)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
							
						<!-- </p>
					  </li>
					  <li class="list-group-item">
						<p class="text-center"> -->
					   <?php echo CHtml::link('<i class="fa fa-users fa-2x fa-border"></i>', Yii::app()->createUrl('publicoobjetivo/usuarios/', array('id'=>$publico->id_po)), array('data-toggle'=>'tooltip', 'title'=>"Ver usuarios"));  ?>
						
						</p>
					<!--   </li>
					</ul> -->
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>