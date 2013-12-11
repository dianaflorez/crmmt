<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
	$noMostrar = array('feccre', 'fecmod', 'id_usu');
?>


<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
		<?php foreach (PublicoObjetivo::model()->getAttributes() as $atributo => $valor): ?>
			<th><?php echo PublicoObjetivo::model()->getAttributeLabel($atributo); ?></th>
		
		<?php endforeach; ?>
		</thead>
		<tbody>
			<?php foreach ($publicos as $publico): ?>
			<tr>
				<?php foreach ($publico->getAttributes() as $atributo => $valor): ?>
				<td>
					<?php echo $valor; ?>
				</td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>