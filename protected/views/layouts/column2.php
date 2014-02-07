<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

 	<?php if (Yii::app()->user->checkAccess("SuperAdmin")) {  ?>
       
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
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/admin'); ?>">Datos Personales</a></li>              
      			  <li><a href="#">Datos Consumo</a></li>
                <li class="divider"></li>
                <li><a href="#">Reportes Clientes</a></li>
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Marketing <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('campana/admin'); ?>">Lista Campañas</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('campana/create'); ?>">Nueva Campaña</a></li>                
      			   <li><a href="#">Enviar Email Campania</a></li>
                <li class="divider"></li>
                <li><?php echo CHtml::link('Lista Público Objetivo', Yii::app()->createUrl('publicoObjetivo/')); ?></li>
                <li><?php echo CHtml::link('Nuevo Público Objetivo', Yii::app()->createUrl('publicoOjetivo/')); ?></li>
                <li class="divider"></li>
                <li><?php echo CHtml::link('Lista Encuesta', Yii::app()->createUrl('formulario/index')); ?></li>
                <li><?php echo CHtml::link('Nueva Encuesta', Yii::app()->createUrl('formulario/create')); ?></li>
				  <li><a href="#">Enviar Email Encuesta</a></li>
                <li><a href="#">Reportes Encuestas</a></li>
				</ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Atencion Cliente<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('blog/admin'); ?>">Lista Blog</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('blog/create'); ?>">Nuevo Blog</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipoblog/admin'); ?>">Lista Categoria Blogs</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipoblog/create'); ?>">Nuevo Categoria Blogs</a></li>              
             
                <li><a href="<?php echo Yii::app()->createUrl('faq/admin'); ?>">Lista Faqs</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('faq/create'); ?>">Nueva Faq</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipofaq/admin'); ?>">Lista Categoria Faqs</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipofaq/create'); ?>">Nueva Categoria Faqs</a></li>              
             
                <li><a href="<?php echo Yii::app()->createUrl('almacen/admin'); ?>">Lista Almacen</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('almacen/create'); ?>">Nuevo Almacen</a></li>         
             
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tareas<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('tarea/admin'); ?>">Lista Tareas</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tarea/create'); ?>">Nueva Tarea</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipotarea/admin'); ?>">Lista Tipo Tarea</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipotarea/create'); ?>">Nuevo Tipo Tarea</a></li>              
              </ul>
            </li>
           
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios CRM<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/update',array( 'id'=>Yii::app()->user->getState('usuid'))); ?>">Mis Datos</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/admin', array( 'rol'=>1)); ?>">Usuario CRM</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/admin', array( 'rol'=>2)); ?>">Usuario Admin</a></li>              
              </ul>
            </li>
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


<!--Menu Admin -->    
    <?php }elseif (Yii::app()->user->checkAccess("Admin")) {  ?>
<!-- Menu Inicio -->
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
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/admin'); ?>">Datos Personales</a></li>              
      			  <li><a href="#">Datos Consumo</a></li>
                <li class="divider"></li>
                <li><a href="#">Reportes Clientes</a></li>
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Marketing <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('campana/admin'); ?>">Lista Campañas</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('campana/create'); ?>">Nueva Campaña</a></li>                
      			   <li><a href="#">Enviar Email Campania</a></li>
                <li class="divider"></li>
                <li><?php echo CHtml::link('Lista Público Objetivo', Yii::app()->createUrl('publicoobjetivo/')); ?></li>
                <li><?php echo CHtml::link('Nuevo Público Objetivo', Yii::app()->createUrl('publicoobjetivo/')); ?></li>
                <li class="divider"></li>
                <li><?php echo CHtml::link('Lista Encuesta', Yii::app()->createUrl('formulario/index')); ?></li>
                <li><?php echo CHtml::link('Nueva Encuesta', Yii::app()->createUrl('formulario/create')); ?></li>
				  <li><a href="#">Enviar Email Encuesta</a></li>
                <li><a href="#">Reportes Encuestas</a></li>
				</ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Atencion Cliente<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('blog/admin'); ?>">Lista Blog</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('blog/create'); ?>">Nuevo Blog</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipoblog/admin'); ?>">Lista Categoria Blogs</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipoblog/create'); ?>">Nuevo Categoria Blogs</a></li>              
             
                <li><a href="<?php echo Yii::app()->createUrl('faq/admin'); ?>">Lista Faqs</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('faq/create'); ?>">Nueva Faq</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipofaq/admin'); ?>">Lista Categoria Faqs</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipofaq/create'); ?>">Nueva Categoria Faqs</a></li>              
             
                <li><a href="<?php echo Yii::app()->createUrl('almacen/admin'); ?>">Lista Almacen</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('almacen/create'); ?>">Nuevo Almacen</a></li>         
             
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tareas<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('tarea/admin'); ?>">Lista Tareas</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tarea/create'); ?>">Nueva Tarea</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipotarea/admin'); ?>">Lista Tipo Tarea</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('tipotarea/create'); ?>">Nuevo Tipo Tarea</a></li>              
              </ul>
            </li>
           
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios CRM<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/update',array( 'id'=>Yii::app()->user->getState('usuid'))); ?>">Mis Datos</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/admin', array( 'rol'=>1)); ?>">Usuario CRM</a></li>              
                <li><a href="<?php echo Yii::app()->createUrl('usucrm/admin', array( 'rol'=>2)); ?>">Usuario Admin</a></li>              
              </ul>
            </li>
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
	
<!-- Fin Menu -->
    <?php }elseif (Yii::app()->user->checkAccess("CRMAdminEncargado")) {  ?>
    
       
        ...
        
   <?php }elseif (Yii::app()->user->checkAccess("CRMEmpleado")) {  ?>
        ....
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