<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */
/* @var $form CActiveForm */
?>


	
<div class="col-md-6">
    <?php $form=$this->beginWidget('CActiveForm', array(
      'id'=>'sesion-form',
      'htmlOptions' => array('enctype'=>'multipart/form-data', 'role'=>'form'),
      // Please note: When you enable ajax validation, make sure the corresponding
      // controller action is handling ajax validation correctly.
      // There is a call to performAjaxValidation() commented in generated controller code.
      // See class documentation of CActiveForm for details on this.
      'enableAjaxValidation'=>false,
    )); ?>

 
 	<div class="row">
      <p>Los campos con <span class="text-danger">*</span> son obligatorios.</p>
    </div>
    <div class="row">
        <div class="form-group">
        <?php echo $form->labelEx($model,'nombre_usuario'); ?>
        <?php echo $form->textField($model,'nombre_usuario', array('class' => 'input-lg form-control')); ?>
        <?php echo $form->error($model,'nombre_usuario'); ?>
        </div>
    </div>

    <div class="row">
      <div class="col-md-offset-8 col-md-4">
        <div class="form-group">
          <div class="row">
          <?php echo CHtml::button('Enviar', array('id' => 'crear_sesion','class' => 'btn btn-primary btn-block')); ?>
          </div>
        </div>
      </div>
    </div>
	</div>
  <?php $this->endWidget(); ?>
  <script>
    $('#crear_sesion').on('click', crearSesion);

    function crearSesion(e){
        console.log('clic');

        var peticion = $.ajax({
                url: "<?php echo Yii::app()->createUrl('sesionchat/create'); ?>",
                type: 'POST',
                data: $("#sesion-form").serialize(),
                //dataType: 'html'
        });
               
        peticion.done(function( msg ) {
            console.log('exito '+msg);
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
