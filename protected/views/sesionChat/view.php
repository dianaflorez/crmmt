<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */



// $this->breadcrumbs=array(
// 	'Sesion Chats'=>array('index'),
// 	$model->id,
// );

// $this->menu=array(
// 	array('label'=>'List SesionChat', 'url'=>array('index')),
// 	array('label'=>'Create SesionChat', 'url'=>array('create')),
// 	array('label'=>'Update SesionChat', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete SesionChat', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage SesionChat', 'url'=>array('admin')),
// );
?>

 <style>
    .resumen_chat {
      height: 475px;
      max-width: 325px;
      padding: 10px;
      border: 1px solid #ccc;
      background-color: #fff;
      margin: 50px auto;
      text-align: center;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      -webkit-box-shadow: 0 5px 25px #666;
      -moz-box-shadow: 0 5px 25px #666;
      box-shadow: 0 5px 25px #666;
    }
  </style>

<h1>View SesionChat #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombreusuario',
		'atendida',
	),
)); ?>

<?php //$this->widget('zii.widgets.CListView', array(
	//'dataProvider'=>$dataProvider,
	//'itemView'=>'_view',
//)); ?>
<?php //$this->widget('zii.widgets.grid.CGridView', array(
	//'dataProvider'=>$dataProvider,
//)); ?>

 <?php //$this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); ?>
<div id="contenedor_chat">
<ul class="resumen_chat list-group">
<?php foreach ($model->mensajes as $mensaje) {
		 $this->renderPartial('_view', array('data'=>$mensaje));
	}
	# code...

?>
</div>
</ul>