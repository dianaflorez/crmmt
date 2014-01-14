<?php

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile($baseUrl.'/lib/wysihtml5/parser_rules/advanced.js'); 
//$cs->registerScriptFile($baseUrl.'/lib/wysihtml5/wysihtml5-0.3.0.min.js');
$cs->registerScriptFile($baseUrl.'/lib/raphaeljs/raphael-min.js');
$cs->registerScriptFile($baseUrl.'/lib/raphaeljs/g.raphael-min.js');
$cs->registerScriptFile($baseUrl.'/lib/raphaeljs/g.pie-min.js');
$cs->registerScriptFile($baseUrl.'/lib/raphaeljs/g.bar-min.js');
?>
<div class="page-header">
	<h2>Resultados <small>Encuesta</small></h2>
</div>

<div class="col-md-6">
	<div class="panel panel-info">
		<div class="panel-heading">
			Título de la encuesta
		</div>
		<div class="panel-body">
			<?php echo $model->titulo; ?>
		</div>
		<div class="panel-heading">
			Descripción de la encuesta
		</div>
		<div class="panel-body">
			<?php echo $model->contenido; ?>
		</div>
		<div class="panel-heading">
			Usuarios que respondieron
		</div>
		<div class="panel-body">
			<?php echo $usuariosRespondieron; ?>
		</div>
	</div>


	 <?php //$form=$this->beginWidget('CActiveForm', array(
	// 	'id'=>'encuesta-form',
	// 	'htmlOptions' => array('role'=>'form'),
	// 	// Please note: When you enable ajax validation, make sure the corresponding
	// 	// controller action is handling ajax validation correctly.
	// 	// There is a call to performAjaxValidation() commented in generated controller code.
	// 	// See class documentation of CActiveForm for details on this.
	// 	'enableAjaxValidation'=>false,
	// )); ?>

	<div class="page-header">
		<h4>Preguntas</h4>
	</div>
	<?php foreach ($preguntas as $pregunta): ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<?php echo $pregunta->txtpre; ?>
				<?php 
					if($pregunta->tipo->nombre === 'unica')
						echo '(Única)';
					elseif($pregunta->tipo->nombre === 'multiple')
						echo '(Múltiple)';
					elseif($pregunta->tipo->nombre === 'abierta')
						echo '(Abierta)';
				 ?>
			</div>
				
			<?php if($pregunta->tipo->nombre === 'abierta'): ?>
				<ul class="list-group">
					<?php $respuestasAbiertas = array_map(function ($obj) { return $obj->txtres; }, $pregunta->formularioPregunta->respuestas); ?> 
					<?php foreach ($respuestasAbiertas as $texto): ?>
						<li class="list-group-item"><?php echo $texto; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<div class="panel-body">
					<div id="grafico_<?php echo $pregunta->id_pre; ?>"></div>
				</div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
	
	<?php //$this->endWidget(); ?>
</div>
<script>
	var datos = <?php echo  CJSON::encode($datosReportes).';'; ?> 
	$(document).on('ready', inicio);

	function inicio(){
		$.each( datos, function( key, pregunta ) {
			if(pregunta.tipo === 'unica'){
				var valores = $.map( pregunta.respuestas, function( n ) {
			    	return n.porcentaje;
				});
				var etiquetas = $.map( pregunta.respuestas, function( n ) {
				    return n.txtop+' ('+n.cantidad+')'+' '+n.porcentaje+'%';
				});
				console.log(valores);

				var entorno = Raphael('grafico_'+pregunta.id_pre, 350, 200);
				entorno.piechart(
				   100, // pie center x coordinate
				   100, // pie center y coordinate
				   90,  // pie radius
				    valores, // values
				    {
				    	legend: etiquetas
				    }
			  	);
			}else if(pregunta.tipo === 'multiple'){

				var valores = $.map( pregunta.respuestas, function( n ) {
		    		return n.cantidad;
				});
				var etiquetas = $.map( pregunta.respuestas, function( n ) {
				    return n.txtop+' ('+n.cantidad+')';
				});
				console.log(valores);

				var entorno = Raphael('grafico_'+pregunta.id_pre, 300, 200),
                    fin = function () {
                        this.flag = entorno.popup(this.bar.x, this.bar.y, this.bar.value || "0").insertBefore(this);
                    },
                    fout = function () {
                        this.flag.animate({opacity: 0}, 300, function () {this.remove();});
                    },
                    fin2 = function () {
                        var y = [], res = [];
                        for (var i = this.bars.length; i--;) {
                            y.push(this.bars[i].y);
                            res.push(this.bars[i].value || "0");
                        }
                        this.flag = entorno.popup(this.bars[0].x, Math.min.apply(Math, y), res.join(", ")).insertBefore(this);
                    },
                    fout2 = function () {
                        this.flag.animate({opacity: 0}, 300, function () {this.remove();});
                    },
                    txtattr = { font: "12px sans-serif" };
                
                //r.text(160, 10, "Single Series Chart").attr(txtattr);
                entorno.barchart(10, 10, 300, 220, [valores]).hover(fin, fout).label([etiquetas]);
               
			}
			
		});


		
	}

</script>


		