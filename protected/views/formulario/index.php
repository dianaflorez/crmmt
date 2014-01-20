<?php
/* @var $this FormularioController */
/* @var $dataProvider CActiveDataProvider */

// $this->breadcrumbs=array(
// 	'Formularios',
// );

// $this->menu=array(
// 	array('label'=>'Create Formulario', 'url'=>array('create')),
// 	array('label'=>'Manage Formulario', 'url'=>array('admin')),
// );
?>
<?php //$this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); ?>


<div class="row">
	<div class="container">
	<?php echo CHtml::link('<i class="fa fa-plus-circle"></i> Crear encuesta', Yii::app()->createUrl('formulario/create'), array('class'=>"btn btn-primary pull-right",'role'=>"button"));  ?>
	</div>
</div>

<div class="page-header">
	<h2>Encuestas <small>Ver todas</small></h2>
</div>


<div class="table-responsive">
	<table id='publico_objetivo' class="table table-bordered table-striped">
		<thead>
			<th>Título</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($formularios as $formulario): ?>
			<tr class="<?php if(!$formulario->estado) echo 'success'; ?>">
				<td><?php  echo $formulario->titulo; ?></td>
				<td>
					<p class="text-center">
					   	<?php if($formulario->estado) echo CHtml::link('<i class="fa fa-edit fa-lg fa-border"></i>', Yii::app()->createUrl('formulario/update/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Editar"));  ?>
						<?php if($formulario->estado) echo CHtml::link('<i class="fa fa-plus-circle fa-lg fa-border"></i>', Yii::app()->createUrl('pregunta/create/', array('id_for'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Agregar pregunta"));  ?>
						<?php if($formulario->estado) echo CHtml::link('<i class="fa fa-plus-circle-o fa-lg fa-border"></i>', Yii::app()->createUrl('formulario/encuesta/', array('id'=>$formulario->id_for, 'id_usur'=> 1)), array('data-toggle'=>'tooltip', 'title'=>"Ver encuesta"));  ?>
						<?php if($formulario->estado) echo CHtml::link('<i class="fa fa-rocket fa-lg fa-border"></i>', Yii::app()->createUrl('formulario/enviar/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Revisar y enviar"));  ?>
						<?php if($formulario->estado) echo CHtml::link('<i class="fa fa-book fa-lg fa-border"></i>', Yii::app()->createUrl('formulario/resultado/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Reporte resultados"));  ?>
						
						<?php 
							//if($formulario->tipoformulario->nombre === 'email'):
								//echo CHtml::link('<i class="fa fa-plus-square fa-lg fa-border"></i>', Yii::app()->createUrl('formulario/duplicar/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Duplicar")); 
							  	//echo CHtml::link('<i class="fa fa-share-square fa-lg fa-border"></i>', Yii::app()->createUrl('formulario/usuarios/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Enviar prueba")); 
							  	//if($formulario->estado)
							  	//	echo CHtml::link('<i class="fa fa-mail-forward fa-lg fa-border"></i>', Yii::app()->createUrl('campana/enviar/', array('id'=>$formulario->id_for)), array('data-toggle'=>'tooltip', 'title'=>"Enviar"));  

							//endif;	?>
					</p>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
