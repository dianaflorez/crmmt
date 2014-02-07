<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Iniciar sesión';

?>

<div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8 col-md-offset-4 col-md-4">
 	<div class="row">
		<div class="page-header">
			<h2>Iniciar sesión</h2>
		</div>
	</div>
	

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'htmlOptions' => array('role' => 'form'),
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
		<div class="row">
			<p>Los campos con <span class="text-danger">*</span> son obligatorios.</p>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="input-group margin-bottom-sm <?php if($model->getErrors('username')) echo 'has-error'; ?>">
              		<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
              		<?php echo $form->textField($model, 'username', array('class'=>'form-control', 'placeholder'=>'Nombre de usuario')); ?> 
          		</div>
          		<?php echo $form->error($model,'username', array('class' => 'text-danger')); ?>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="input-group margin-bottom-sm <?php if($model->getErrors('password')) echo 'has-error'; ?>">
	                <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
	                <?php echo $form->passwordField($model, 'password', array('class'=>'form-control', 'placeholder'=>'Contraseña', 'maxlength'=>40)); ?> 
	            </div>
        		<?php echo $form->error($model,'password', array('class' => 'text-danger')); ?>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe'); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-offset-6 col-md-6">
				<div class="form-group">
					<div class="row">
					<?php echo CHtml::submitButton('Iniciar sesión', array('class' => 'btn btn-primary btn-block')); ?>
					</div>
				</div>
			</div>
		</div>

	<?php $this->endWidget(); ?>

</div>

