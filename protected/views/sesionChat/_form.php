<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */
/* @var $form CActiveForm */
?>

<div class="container">
	
		<div class="col-md-6">
<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'campana-form',
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
        <?php echo $form->labelEx($model,'nombreusuario'); ?>
        <?php echo $form->textField($model,'nombreusuario', array('class' => 'input-lg form-control')); ?>
        <?php echo $form->error($model,'nombreusuario'); ?>
        </div>

    </div>

    <div class="row">
      <div class="col-md-offset-8 col-md-4">
        <div class="form-group">
          <div class="row">
          <?php echo CHtml::submitButton('Enviar', array('class' => 'btn btn-primary btn-block')); ?>
          </div>
        </div>
      </div>
    </div>
	</div>
  <?php $this->endWidget(); ?>
