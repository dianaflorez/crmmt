<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */
/* @var $form CActiveForm */
?>


<div id="contenedor-form-ingreso">	
<div class="col-md-offset-2 col-md-8">
    <?php $form=$this->beginWidget('CActiveForm', array(
      'id'=>'sesion-chat-form',
      'htmlOptions' => array('enctype'=>'multipart/form-data', 'role'=>'form'),
      // Please note: When you enable ajax validation, make sure the corresponding
      // controller action is handling ajax validation correctly.
      // There is a call to performAjaxValidation() commented in generated controller code.
      // See class documentation of CActiveForm for details on this.
      'enableAjaxValidation'=>true,
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
      <!-- <div class="col-md-offset-8 col-md-4"> -->
        <div class="form-group">
          <!-- <div class="row">
          --> <?php echo CHtml::button('Entrar', array('id' => 'crear_sesion','class' => 'btn btn-primary btn-block')); ?>
          </div>
        <!-- </div> -->
      <!-- </div> -->
    </div>
</div>
</div>
  <?php $this->endWidget(); ?>
  <script>
    $('#crear_sesion').on('click', crearSesion);

    function crearSesion(e){
        console.log('clic');

        var datos = $("#sesion-chat-form").serializeArray();
        datos.push({name: 'peticion', value: 'sesion-chat-form'});
        //datos['peticion'] = 'sesion-chat-form';
        //debugger;
        console.log(datos);
        var peticion = $.ajax({
                url: "<?php echo Yii::app()->createUrl('sesionchat/create'); ?>",
                type: 'POST',
                data: datos
                //dataType: 'html'
        });
               
        peticion.done(function( msg ) {
            //console.log('exito '+msg);
            $('#firechat-contenedor').empty();
            $('#firechat-contenedor').html(msg);
            //$('#firechat-contenedor').remove();
            //$('#chat').append(msg);
        });
           
        peticion.fail(function( jqXHR, textStatus ) {
            console.log('fallo '+textStatus);
        });

    }
  </script>
