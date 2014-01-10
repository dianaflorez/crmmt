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
    $cs->registerCssFile($baseUrl.'/lib/font-awesome/css/font-awesome.min.css');
		//$cs->registerScriptFile($baseUrl.'/lib/jquery/jquery.min.js');
		$cs->registerScriptFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.min.js');
		
		//$cs->registerScriptFile($baseUrl.'/lib/handlebars/handlebars-v1.1.2.js');
		//$cs->registerScriptFile($baseUrl.'/lib/bootstrap/js/bootstrap.min.js', CClientScript::POS_END); 	


	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
  	<?php echo $content; ?>
</body>
</html>
