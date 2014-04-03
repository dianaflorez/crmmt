<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */
/* @var $form CActiveForm */
?>


<div id="contenedor-form-ingreso">	
    <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8 col-md-offset-2 col-md-8">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'sesion-chat-form',
            'htmlOptions' => array('enctype'=>'multipart/form-data', 'role'=>'form'),
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
        )); ?>
        <div class="row">
            <div class="form-group">
                <?php //echo $form->labelEx($model,'nombre_usuario'); ?>
                <?php //echo $form->textField($model,'nombre_usuario', array('class' => 'input-lg form-control')); ?>
                <div class="input-group margin-bottom-sm <?php if($model->getErrors('nombre_usuario')) echo 'has-error'; ?>">
                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                    <?php echo $form->textField($model, 'nombre_usuario', array('class'=>'form-control', 'placeholder'=>'Nombres')); ?> 
                </div>
                <?php echo $form->error($model,'nombre_usuario', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="input-group margin-bottom-sm <?php if($model->getErrors('correo')) echo 'has-error'; ?>">
                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                    <?php echo $form->emailField($model, 'correo', array('class'=>'form-control', 'placeholder'=>'Correo')); ?> 
                </div>
                <?php echo $form->error($model,'correo', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo CHtml::button('Entrar', array('id' => 'crear_sesion','class' => 'btn btn-primary btn-block')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>   
</div>

  <script>
    $('#crear_sesion').on('click', crearSesion);

    function crearSesion(e){

        var datos = $("#sesion-chat-form").serializeArray();
        datos.push({name: 'peticion', value: 'sesion-chat-form'});
        var peticion = $.ajax({
                url: "<?php echo Yii::app()->createUrl('sesionchat/create'); ?>",
                type: 'POST',
                data: datos
        });
               
        peticion.done(function( msg ) {
            $('#firechat-contenedor').empty();
            $('#firechat-contenedor').html(msg);
        });
           
        peticion.fail(function( jqXHR, textStatus ) {
            console.log('fallo ' + textStatus);
        });

    }
  </script>
