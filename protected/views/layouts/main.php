<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="es" />
		<?php

			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerCoreScript('bootstrap');
			
			$baseUrl = Yii::app()->baseUrl; 
			$cs = Yii::app()->getClientScript();
			$cs->registerCssFile($baseUrl.'/css/main.css');
			$cs->registerCssFile($baseUrl.'/lib/jquery-te/jquery-te-1.4.0.css');
	   		$cs->registerCssFile($baseUrl.'/lib/font-awesome/css/font-awesome.min.css');
		?>

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>
	<body>
	  	<?php echo $content; ?>
	</body>
</html>
