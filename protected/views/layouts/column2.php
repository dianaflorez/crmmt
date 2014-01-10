<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

 	<?php if (Yii::app()->user->checkAccess("SuperAdmin")) {  ?>
       
        <?php	if(Yii::app()->user->name=="Guest") { ?>
            <a href="index.php?r=site/login">Login</a>	
        <?php	}else{ ?>
            <a href="index.php?r=site/logout">Logout <?php echo Yii::app()->user->name;  ?></a>	
    <?php	} ?>


<!--Menu Admin -->    
    <?php }elseif (Yii::app()->user->checkAccess("Admin")) {  ?>

       
        <?php	if(Yii::app()->user->name=="Guest") { ?>
            <a href="index.php?r=site/login">Login</a>	
        <?php	}else{ ?>
            <a href="index.php?r=site/logout">Logout <?php echo Yii::app()->user->name;  ?></a>	
        <?php	} ?>

    <?php }elseif (Yii::app()->user->checkAccess("usuario")) {  ?>
    
       
        <?php	if(Yii::app()->user->name=="Guest") { ?>
            <a href="index.php?r=site/login">Login</a>	
        <?php	}else{ ?>
            <a style="text-decoration:underline" href="index.php?r=site/logout">Logout </a>	
        <?php	} ?>
        
    <?php }else { ?>

    
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
              <?php echo CHtml::link('Campaña', Yii::app()->createUrl('campana/')); ?>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('campana/create'); ?>">Nueva Campaña</a></li>              
                <li><a href="campana/admin">Lista Campaña</a></li>
                <li><a href="#">Enviar Email Campania</a></li>
              </ul>
            </li>
            <li><?php echo CHtml::link('Público Objetivo', Yii::app()->createUrl('publicoobjetivo/')); ?></li>
            <li class="dropdown">
              <a href="formulario" class="dropdown-toggle" data-toggle="dropdown">Encuesta <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><?php echo CHtml::link('Nueva encuesta', Yii::app()->createUrl('formulario/create')); ?></li>
                <li><?php echo CHtml::link('Ver todas', Yii::app()->createUrl('formulario/index')); ?></li>
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
          <ul class="nav navbar-nav navbar-right">
            <li>
              <?php if(Yii::app()->user->name=="Guest"): ?>
             
                <?php echo CHtml::link('<i class="fa fa-sign-in"></i> Iniciar sesión', Yii::app()->createUrl('site/login')); ?>
              <?php else: ?>
              <?php echo CHtml::link(Yii::app()->user->name.' <i class="fa fa-sign-out"></i>', Yii::app()->createUrl('site/logout')); ?>
              <?php endif; ?>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
        
    
    <?php	} ?>   


  <div id="principal" class="container">
  	<?php echo $content; ?>
  </div>	


<?php $this->endContent(); ?>