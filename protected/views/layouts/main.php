<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/bootstrap/css/bootstrap.min.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/bootstrap/css/bootstrap-theme.min.css" media="screen, projection" />
 -->
	<?php

		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerCoreScript('bootstrap');
		
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		//$cs->registerCssFile($baseUrl.'/lib/bootstrap/css/bootstrap.min.css');
		$cs->registerCssFile($baseUrl.'/css/main.css');
		$cs->registerCssFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.css');
		//$cs->registerScriptFile($baseUrl.'/lib/jquery/jquery.min.js');
		$cs->registerScriptFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.min.js');
		
		//$cs->registerScriptFile($baseUrl.'/lib/handlebars/handlebars-v1.1.2.js');
		//$cs->registerScriptFile($baseUrl.'/lib/bootstrap/js/bootstrap.min.js', CClientScript::POS_END); 
	

		

	?>
	<!-- blueprint CSS framework -->
	<!-- -<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" /> -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" /> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" /> -->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo CHtml::encode(Yii::app()->name); ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
             <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Clientes <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Datos Personales</a></li>              
                <li><a href="#">Datos Consumo</a></li>
                <li class="divider"></li>
                <li><a href="#">Reportes Clientes</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Campanias <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Nueva Campania</a></li>              
                <li><a href="#">Lista Campanias</a></li>
                <li><a href="#">Enviar Email Campania</a></li>
              </ul>
            </li>
            <li><a href="#contact">Publico Objetivo</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Encuesta <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Nueva Encuesta</a></li>
                <li><a href="#">Enviar Email Encuesta</a></li>
            	  <li class="divider"></li>
                <li><a href="#">Reportes Encuestas</a></li>
              </ul>
            </li>
            <li><a href="#contact">Promociones</a></li>
            <li><a href="#contact">Soporte</a></li>
            <li><a href="#contact">Tareas</a></li>
            <li><a href="#contact">Usuarios CRM</a></li>
           
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div class="row mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<div class="row">
	<?php echo $content; ?>
	</div>
	<footer id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</footer><!-- footer -->

</div><!-- page -->
	
</body>
</html>
