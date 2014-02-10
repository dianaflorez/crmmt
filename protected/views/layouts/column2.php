<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
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
                    <?php if(Yii::app()->user->checkAccess("CRMAdminEncargado")):  ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Clientes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo CHtml::link('Datos personales', Yii::app()->createUrl('usucrm/admin')); ?></li>
                            <li><a href="#">Datos de consumo</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Reportes de clientes</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Marketing <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo CHtml::link('<i class="fa fa-eye fa-fw"></i> Ver campañas', Yii::app()->createUrl('campana/')); ?></li>
                            <li><?php echo CHtml::link('<i class="fa fa-plus-circle fa-fw"></i> Nueva campana', Yii::app()->createUrl('campana/create')); ?></li>
                            <li class="divider"></li>
                            <li><?php echo CHtml::link('<i class="fa fa-eye fa-fw"></i> Ver públicos objetivo', Yii::app()->createUrl('publicoObjetivo/')); ?></li>
                            <li><?php echo CHtml::link('<i class="fa fa-plus-circle fa-fw"></i> Nuevo público objetivo', Yii::app()->createUrl('publicoObjetivo/create')); ?></li>
                            <li class="divider"></li>
                            <li><?php echo CHtml::link('<i class="fa fa-eye fa-fw"></i> Ver encuestas', Yii::app()->createUrl('formulario/')); ?></li>
                            <li><?php echo CHtml::link('<i class="fa fa-plus-circle fa-fw"></i> Nueva encuesta', Yii::app()->createUrl('formulario/create')); ?></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Atencion Cliente<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><?php echo CHtml::link('Ver blogs', Yii::app()->createUrl('blog/admin')); ?></li>
                        <li><?php echo CHtml::link('Nuevo blog', Yii::app()->createUrl('blog/create')); ?></li>
                        <li class="divider"></li>
                        <li><?php echo CHtml::link('Ver categorias de blog', Yii::app()->createUrl('tipoBlog/admin')); ?></li>
                        <li><?php echo CHtml::link('Nueva categoria de blog', Yii::app()->createUrl('tipoBlog/create')); ?></li>
                        <li class="divider"></li>
                        <li><?php echo CHtml::link('Ver FAQs', Yii::app()->createUrl('faq/admin')); ?></li>
                        <li><?php echo CHtml::link('Nuevo FAQ', Yii::app()->createUrl('faq/create')); ?></li>
                        <li class="divider"></li>
                        <li><?php echo CHtml::link('Ver tipos de FAQ', Yii::app()->createUrl('tipoFaq/admin')); ?></li>
                        <li><?php echo CHtml::link('Nuevo tipo de FAQ', Yii::app()->createUrl('tipoFaq/create')); ?></li>
                        <li class="divider"></li>
                        <li><?php echo CHtml::link('Ver almacenes', Yii::app()->createUrl('almacen/admin')); ?></li>
                        <li><?php echo CHtml::link('Nuevo almacén', Yii::app()->createUrl('almace/create')); ?></li>
                      </ul>
                    </li>
                    
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tareas<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><?php echo CHtml::link('Ver tareas', Yii::app()->createUrl('tarea/admin')); ?></li>
                        <li><?php echo CHtml::link('Nueva tarea', Yii::app()->createUrl('tarea/create')); ?></li>
                        <li class="divider"></li>
                        <li><?php echo CHtml::link('Ver tipos de tarea', Yii::app()->createUrl('tipoTarea/admin')); ?></li>
                        <li><?php echo CHtml::link('Nuevo tipo de tarea', Yii::app()->createUrl('tipoTarea/create')); ?></li>             
                      </ul>
                    </li>
                   
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios CRM<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><?php echo CHtml::link('Mis datos', Yii::app()->createUrl('usucrm/update'),array( 'id'=>Yii::app()->user->getState('usuid'))); ?></li>
                        <li><?php echo CHtml::link('Usuario CRM', Yii::app()->createUrl('usucrm/admin'), array( 'rol'=>1)); ?></li>
                        <li><?php echo CHtml::link('Usuario Admin', Yii::app()->createUrl('usucrm/admin'), array( 'rol'=>2)); ?></li>
                      </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(Yii::app()->user->name=="Guest"): ?>
                         <li>
                            <?php echo CHtml::link('<i class="fa fa-sign-in"></i> Iniciar sesión', Yii::app()->createUrl('site/login')); ?>
                        </li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear fa-2x"></i></a>
                            <ul class="dropdown-menu">
                                <li><?php echo CHtml::link('Mis datos ('.Yii::app()->user->name.')', Yii::app()->createUrl('usucrm/update'),array( 'id'=>Yii::app()->user->getState('usuid'))); ?></li>
                                 <li class="divider"></li>
                                <li><?php echo CHtml::link('Salir', Yii::app()->createUrl('site/logout')); ?></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <div id="principal" class="container">
        <?php echo $content; ?>
    </div>	
<?php $this->endContent(); ?>