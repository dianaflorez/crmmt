<div class="page-header">
	<h2>Revisar <small>Encuesta</small></h2>
</div>

<?php $this->renderPartial('encuesta', array('model'=>$model, 'activa'=>$activa)); ?>
<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<?php echo CHtml::link('Volver', Yii::app()->createUrl('formulario/'), array('class'=>'btn btn-default  btn-block','role'=>'button'));  ?>
			</div>
		</div>
	</div>