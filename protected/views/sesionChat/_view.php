<?php
/* @var $this SesionChatController */
/* @var $data SesionChat */
?>
<li class="list-group-item">
 	
	    <label class="text-primary">
	    	<strong><?php echo CHtml::encode($data->nombre_usuario); ?></strong>
	    		<em> (<?php echo date('H:i A', strtotime($data->fecha)); ?>):</em>
	    </label>
	   
	<div class="pull-right">
    	<?php echo CHtml::encode($data->mensaje); ?>
    </div>
 </li>
								