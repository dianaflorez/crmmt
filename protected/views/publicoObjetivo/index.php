<?php
/* @var $this PublicoObjetivoController */
/* @var $dataProvider CActiveDataProvider */

?>


<?php //$this->widget('zii.widgets.CListView', array(
	//'dataProvider'=>$dataProvider,
	//'itemView'=>'_view',
//)); ?>


<div class="page-header">
	<h2>Público Objetivo <small>Ver todos</small></h2>
</div>

	<?php $this->renderPartial('_pub_obj', array('publicos'=>$publicos)); ?>

