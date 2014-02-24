<div class="col-md-offset-3 col-md-6">
	<div class="row">
		<p class="text-<?php echo $tipo; ?> text-center" style="font-size: 3em;"><?php echo $titulo; ?></p>
	</div>
	<div class="row">
	<p class="text-<?php echo $tipo; ?> text-center" style="font-size: 3em;">
		<?php if($icono): ?>
			<i class="fa <?php echo $icono; ?> fa-5x"></i>
	  	<?php endif; ?> 
	</p>
	</div>
	<div class="row">
		<div class="alert alert-<?php echo $tipo; ?>">
			<?php echo $mensaje; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-offset-4 col-md-4">
			<?php echo CHtml::link('Continuar <i class="fa fa-arrow-right"></i>', $url, array('class'=>'btn btn-'.$tipo.' form-control','role'=>"button"));  ?>
		</div>
	</div>

</div>

