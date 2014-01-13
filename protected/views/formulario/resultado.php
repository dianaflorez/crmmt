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

<div>
	<h3><?php echo $model->titulo; ?></h3>
	<p><?php echo $model->contenido; ?></p>
</div>


	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'encuesta-form',
		'htmlOptions' => array('role'=>'form'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>
	<?php foreach ($preguntas as $pregunta): ?>
	<div class="row">
			<div class="col-md-6">
		<div class="well well-sm">
			<?php echo $pregunta->txtpre; ?>
			
			<div class="form-group">
				<div id="pie_<?php echo $pregunta->id_pre; ?>">
					
				</div>
			</div>
			</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php $this->endWidget(); ?>
<script>
var preguntas = <?php echo  CJSON::encode($datosReportes).';'; ?> 
$(document).on('ready', inicio);

	function inicio(){
		$.each( preguntas, function( key, pregunta ) {
		  	//alert( key + ": " + value );
		  	
			

			if(pregunta.tipo === 'unica'){
				var valores = $.map( pregunta.respuestas, function( n ) {
			    	return n.porcentaje;
				});
				var etiquetas = $.map( pregunta.respuestas, function( n ) {
				    return n.txtop+' ('+n.cantidad+')'+' '+n.porcentaje+'%';
				});
				console.log(valores);

					var paper = Raphael('pie_'+pregunta.id_pre, 300, 200);
					 paper.piechart(
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

				var r = Raphael('pie_'+pregunta.id_pre, 300, 200),
                    fin = function () {
                        this.flag = r.popup(this.bar.x, this.bar.y, this.bar.value || "0").insertBefore(this);
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
                        this.flag = r.popup(this.bars[0].x, Math.min.apply(Math, y), res.join(", ")).insertBefore(this);
                    },
                    fout2 = function () {
                        this.flag.animate({opacity: 0}, 300, function () {this.remove();});
                    },
                    txtattr = { font: "12px sans-serif" };
                
                //r.text(160, 10, "Single Series Chart").attr(txtattr);
                // r.text(480, 10, "Multiline Series Stacked Chart").attr(txtattr);
                // r.text(160, 250, "Multiple Series Chart").attr(txtattr);
                // r.text(480, 250, "Multiline Series Stacked Chart\nColumn Hover").attr(txtattr);
                
                //r.barchart(10, 10, 300, 220, [[55, 20, 13, 32, 5, 1, 2, 10]]).hover(fin, fout);
                r.barchart(10, 10, 300, 220, [valores]).hover(fin, fout).label([etiquetas]);
               // r.label(etiquetas);
			}
			
		});


		
	}

</script>


		