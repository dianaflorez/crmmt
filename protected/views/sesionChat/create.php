<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */

// $this->breadcrumbs=array(
// 	'Sesion Chats'=>array('index'),
// 	'Create',
// );

// $this->menu=array(
// 	array('label'=>'List SesionChat', 'url'=>array('index')),
// 	array('label'=>'Manage SesionChat', 'url'=>array('admin')),
// );
?>

 <script src="https://cdn.firebase.com/v0/firebase.js"></script>
  <script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<!--   Download from https://github.com/firebase/Firechat -->
   <link rel="stylesheet" href="/crmmt/lib/firechat/firechat-default.css" />
  <script src="/crmmt/lib/firechat/firechat-default.js"></script> 

<!-- <h1>Create SesionChat</h1> -->


<div id="chat" class="col-xs-offset-1 col-xs-11 col-sm-offset-2 col-sm-8 col-md-4">
    <div class="cabecera">
        <p>Chat<i id="desplegar" class="fa fa-plus-square white pull-right"></i></p>
    </div>
    <div id="firechat-contenedor">
    	<?php $id_sesion = Yii::app()->request->cookies->contains('id_sesion') ? Yii::app()->request->cookies['id_sesion']->value : ''; ?>
		<?php if(!$id_sesion): ?>
    		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
    	<?php else: ?>
    		<?php $model = SesionChat::model()->findByPk($id_sesion); ?>
			<?php $this->renderPartial('chat', array('model'=>$model)); ?>
    	<?php endif; ?>
    </div>
</div>

<script>
	$('.cabecera').on('click', desplegar);

	<?php if($id_sesion): ?>
		desplegar();
	<?php endif; ?>
    function desplegar(e){
        $('#firechat-contenedor').slideToggle('fast');
        var icono = $('#desplegar');
        icono.toggleClass('fa-plus-square');
        icono.toggleClass('fa-minus-square');
    }
</script>