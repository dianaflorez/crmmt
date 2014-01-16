<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
// $this->breadcrumbs=array(
// 	'Login',
// );
?>
<div class="col-md-offset-3 col-md-6">
	<div class="page-header">
		<h2>Iniciar sesión</h2>
	</div>

	<div class="container">

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
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model,'username', array('class' => 'input-lg form-control')); ?>
				<?php echo $form->error($model,'username'); ?>
				</div>

		</div>

		<div class="row">
				<div class="form-group">
				<?php echo $form->labelEx($model,'password'); ?>
				<?php echo $form->passwordField($model,'password', array('class' => 'input-lg form-control')); ?>
				<?php echo $form->error($model,'password'); ?>
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
			<div class="col-md-offset-8 col-md-4">
				<div class="form-group">
					<div class="row">
					<?php echo CHtml::submitButton('Iniciar sesión', array('class' => 'btn btn-primary btn-block')); ?>
					</div>
				</div>
			</div>
		</div>

	<?php $this->endWidget(); ?>

	</div>
</div>
