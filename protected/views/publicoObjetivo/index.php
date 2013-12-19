<?php
/* @var $this PublicoObjetivoController */
/* @var $dataProvider CActiveDataProvider */

?>


<?php //$this->widget('zii.widgets.CListView', array(
	//'dataProvider'=>$dataProvider,
	//'itemView'=>'_view',
//)); ?>

<div class="row">
	<div class="container">
	<?php echo CHtml::link('<i class="fa fa-plus-circle"></i> Crear público', Yii::app()->createUrl('publicoobjetivo/create'), array('class'=>"btn btn-primary pull-right",'role'=>"button"));  ?>
	</div>
</div>

<div class="page-header">
	<h2>Público Objetivo <small>Ver todos</small></h2>
</div>

<?php $this->renderPartial('_pub_obj', array('publicos'=>$publicos)); ?>

