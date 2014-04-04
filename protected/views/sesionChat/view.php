<?php
/* @var $this SesionChatController */
/* @var $model SesionChat */
?>

<style>
    .resumen_chat {
      /*height: 475px;
      max-width: 325px;*/
      padding: 10px;
      border: 1px solid #ccc;
      background-color: #fff;
     /* margin: 50px auto;*/
      /*text-align: center;*/
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      /*-webkit-box-shadow: 0 5px 25px #666;
      -moz-box-shadow: 0 5px 25px #666;
      box-shadow: 0 5px 25px #666;*/
    }
</style>

<div class="page-header">
    <h2>Chat <small>Usuario atendido: <?php echo $model->nombre_usuario; ?></small></h2>
</div>
<div id="contenedor_chat" class="col-md-6">
    <ul class="resumen_chat list-group">
    <?php foreach ($model->mensajes as $mensaje) {
    		 $this->renderPartial('_view', array('data'=>$mensaje));
    	}
    ?>
    </div>
</ul>