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
<?php $id_sesion = Yii::app()->request->cookies->contains('id_sesion') ? Yii::app()->request->cookies['id_sesion']->value : ''; ?>

<div id="chat" class="col-xs-offset-1 col-xs-11 col-sm-offset-2 col-sm-6 col-md-4">
    <div class="cabecera">
        <p>Chat<i id="desplegar" class="fa fa-plus-square white pull-right"></i></p>
    </div>
    <?php if($id_sesion): ?>   
        <div class="pull-right" style="padding: 0.2em 0 0.2em 0;">
        <?php echo CHtml::link("<i class=\"fa fa-times fa-lg fa-fw\"></i>", Yii::app()->createUrl('sesionchat/salir')); //,array("class"=>"btn btn-default activacion", "id"=>"btn_", "data-toggle"=>"tooltip", "title"=>"Activar")); ?>
        </div>
    <?php endif; ?>
    <div id="firechat-contenedor">   	
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