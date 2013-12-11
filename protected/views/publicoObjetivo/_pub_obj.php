<?php
/* @var $this PublicoObjetivoController */
/* @var $model PublicoObjetivo */
/* @var $form CActiveForm */
	$noMostrar = array('feccre', 'fecmod', 'id_usu');
?>


<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
		<?php 
		foreach (PublicoObjetivo::model()->getAttributes() as $atributo => $valor):
			if(!in_array($atributo, $noMostrar)): ?>
			<th><?php echo PublicoObjetivo::model()->getAttributeLabel($atributo); ?></th>
		<?php 
			endif;
		endforeach; ?>
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
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>