<?php
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
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
			<div class="row form-inline">
				<fieldset>
				 	<div class="col-sm-8 col-md-8">
						<div class="form-group">
							Usuarios que respondieron
						</div>
					</div>
					<div class="col-md-4">
						<a class="btn btn-default btn-block"  data-toggle="modal" data-target="#usuariosModal"><i class="fa fa-eye fa-fw"></i> Ver usuarios</a>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="panel-body">
			<p>
				<?php echo count($usuariosId); ?>
			</p>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="usuariosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        	<h4 class="modal-title" id="myModalLabel">Respondieron la encuesta</h4>
		      	</div>
		      	<div class="modal-body">
		      		<?php $this->renderPartial('_usuariosEncuesta', array('model'=>$usuarios,'usuariosId'=>$usuariosId, 'ajaxUrl'=>$this->createUrl('/formulario/usuariosencuesta', array('id_for' => $model->id_for)))); ?>
		        </div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
		    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="page-header">
		<h4>Preguntas</h4>
	</div>
	<?php foreach ($preguntas as $pregunta): ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<?php echo $pregunta->txtpre; ?>
				<?php 
					$tipo = '';
					if($pregunta->tipo->nombre === 'unica'):
						$tipo = $tipo.'(Única)';
					elseif($pregunta->tipo->nombre === 'multiple'):
						$tipo = $tipo.'(Múltiple)';
					elseif($pregunta->tipo->nombre === 'abierta'):
						$tipo = $tipo.'(Abierta - ';
						if($pregunta->tipoPreRes->nombre === 'texto'):
							$tipo = $tipo.'Texto)';
						elseif($pregunta->tipoPreRes->nombre === 'numero'):
							$tipo = $tipo.'Número)';
						elseif($pregunta->tipoPreRes->nombre === 'fecha'):
							$tipo = $tipo.'Fecha)';
						endif;
					endif;
					echo $tipo;
				?>
			</div>
				
			<?php if($pregunta->tipo->nombre === 'abierta'): ?>
				<?php $respuestas = $pregunta->formularioPregunta->respuestas; ?>
				<?php if(count($respuestas) > 0): ?>
					<ul class="list-group">
						<?php foreach ($respuestas as $respuesta): ?>
							<li class="list-group-item"><?php echo $respuesta->txtres ? $respuesta->txtres : 'No respondió'; ?> 
								<div class="pull-right">
									<?php echo ucfirst(strtolower($respuesta->usuario->nombre1)).' ('.$respuesta->usuario->usuarioWeb->login.')'; ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<div class="panel-body">
						<p>No hay respuestas.</p>
					</div>
				<?php endif; ?>
			<?php else: ?>
				<div class="panel-body">
					<div id="grafico_<?php echo $pregunta->id_pre; ?>"></div>
				</div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="form-group">
			<?php echo CHtml::link('Volver', Yii::app()->createUrl('formulario/'), array('class'=>'btn btn-default  btn-block','role'=>'button'));  ?>
			</div>
		</div>
	</div>
</div>

<script>
	var datos = <?php echo  CJSON::encode($datosReportes).';'; ?> 
	$(document).on('ready', inicio);

	function inicio(){
		$.each( datos, function( key, pregunta ) {
			if(pregunta.tipo === 'unica'){
				var valores = $.map( pregunta.respuestas, function( n ) {
			    	if(n.porcentaje != 0)
			    		return n.porcentaje;
				});
				var etiquetas = $.map( pregunta.respuestas, function( n ) {
				    return n.txtop+' ('+n.cantidad+')'+' '+n.porcentaje+'%';
				});
				//console.log(valores);
				if(valores.length > 0){
					var entorno = Raphael('grafico_'+pregunta.id_pre, 350, 200);
					entorno.piechart(
						100, // centro x de la gráfica.
					   	100, // centro y de la gráfica.
					   	90,  // radio
					    valores, // Vector de valores
					    {
					    	legend: etiquetas
					    }
				  	);
				}else{
	            	$('#grafico_'+pregunta.id_pre).append('<p>No hay respuestas</p>');
	            } 
			}else if(pregunta.tipo === 'multiple'){

				var valores = $.map(pregunta.respuestas, function( n ) {
		    			return parseInt(n.cantidad);
				});
				var etiquetas = $.map(pregunta.respuestas, function( n ) {
				    	return n.txtop+' ('+n.cantidad+')';
				});
				//console.log(valores);
				if(valores.length > 0){
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
	                
	                //entorno.text(160, 10, "Single Series Chart").attr(txtattr);
	                entorno.barchart(10, 10, 300, 220, [valores]).hover(fin, fout).label([etiquetas]);
	            }
	            else{
	            	$('#grafico_'+pregunta.id_pre).append('<p>No hay respuestas</p>');
	            } 
			}
		});		
	}

</script>


		