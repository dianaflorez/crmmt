<?php
/* @var $this CampanaController */
/* @var $dataProvider CActiveDataProvider */

// $this->breadcrumbs=array(
// 	'Campanas',
// );

// $this->menu=array(
// 	array('label'=>'Create Campana', 'url'=>array('create')),
// 	array('label'=>'Manage Campana', 'url'=>array('admin')),
// );
?>
<div class="row">
	<div class="container">
	<?php echo CHtml::link('<i class="fa fa-plus-circle"></i> Crear campaña', Yii::app()->createUrl('campana/create'), array('class'=>"btn btn-primary pull-right",'role'=>"button"));  ?>
	</div>
</div>

<div class="page-header">
	<h2>Campañas <small>Ver todas</small></h2>
</div>


<div class="table-responsive">
	<table id='publico_objetivo' class="table table-bordered table-striped">
		<thead>
			<th>Asunto</th>
			<th>Tipo</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($campanas as $campana): ?>
			<tr class="<?php if($campana->estado) echo 'success'; ?>">
				<td><?php  echo $campana->asunto; ?></td>
				<td><?php  echo ucfirst($campana->tipoCampana->nombre); ?></td>
				<td>
					<p class="text-center">
					   	<?php if(!$campana->estado) echo CHtml::link('<i class="fa fa-edit fa-border fa-lg"></i>', Yii::app()->createUrl('campana/update/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
						<?php 
							if($campana->tipoCampana->nombre === 'email'):
								echo CHtml::link('<i class="fa fa-copy fa-border fa-lg"></i>', Yii::app()->createUrl('campana/duplicar/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Duplicar")); ?>
						<?php	  	if(!$campana->estado)
							  			echo CHtml::link('<i class="fa fa-rocket fa-border fa-lg"></i>', Yii::app()->createUrl('campana/enviar/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Enviar"));  

							endif;	?>
					</p>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<ul class="list-group">
	<li class="list-group-item">
		<div class="row">
    	<div class="col-md-4">
    	<strong>Asunto</strong>
    	</div>
    	<div class="col-md-1">
		<strong>Tipo</strong>
    	</div>
    	<div class="col-md-offset-4 col-md-3">
		</div>
  		</div>
	</li>
	<?php foreach ($campanas as $campana): ?>
  	<li class="list-group-item">
  		<div class="row">
    	<div class="col-xs-5 col-md-4">
    	<?php  echo $campana->asunto; ?>
    	</div>
    	<div class="col-xs-1 col-md-1">
			<?php  echo ucfirst($campana->tipoCampana->nombre); ?>
    	</div>
    	<div class="col-xs-6 col-md-offset-4 col-md-3">
		<?php echo CHtml::link('<i class="fa fa-edit fa-lg fa-border"></i>', Yii::app()->createUrl('campana/update/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
		<?php echo CHtml::link('<i class="fa fa-plus-square fa-lg fa-border"></i>', Yii::app()->createUrl('campana/usuarios/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Duplicar"));  ?>
		<?php echo CHtml::link('<i class="fa fa-share-square fa-lg fa-border"></i>', Yii::app()->createUrl('campana/usuarios/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Enviar prueba"));  ?>
		<?php echo CHtml::link('<i class="fa fa-mail-forward fa-lg fa-border"></i>', Yii::app()->createUrl('campana/usuarios/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Enviar"));  ?>
  		</div>
  		</div>
  	</li>
  	<?php endforeach; ?>
</ul>


	<?php foreach ($campanas as $campana): ?>
  	<div class="row">
  		<div class="col-md-6"><?php  echo $campana->asunto; ?></div>
    	<div class="col-md-6">
			<div class="pull-right">
    		<?php echo CHtml::link('<i class="fa fa-edit fa-lg fa-border"></i>', Yii::app()->createUrl('campana/update/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
			<?php echo CHtml::link('<i class="fa fa-plus-square fa-lg fa-border"></i>', Yii::app()->createUrl('campana/usuarios/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Duplicar"));  ?>
			<?php echo CHtml::link('<i class="fa fa-share-square fa-lg fa-border"></i>', Yii::app()->createUrl('campana/usuarios/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Enviar prueba"));  ?>
			<?php echo CHtml::link('<i class="fa fa-mail-forward fa-lg fa-border"></i>', Yii::app()->createUrl('campana/usuarios/', array('id'=>$campana->id_cam)), array('data-toggle'=>'tooltip', 'title'=>"Enviar"));  ?></div>
			</div>
  	</div>
  	<?php endforeach; ?>
