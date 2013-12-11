/* 
==========================================================================================================
*
*	Aplicación BackboneJS para la generar dinamicamente las opciones de respuesta de un pregunta.
*
*	Creada              : 04 de diciembre de 2013.
*	Última modificación : 10 de diciembre de 2013.
==========================================================================================================
*/

// Espacio de nombres.
var app = app || 
	{ 
		// Instancias de "módulos".
		Collections: {},
		Views: {},
		
		// Prototipos. 
		Modules: {
			Models: {},
			Views: {},
			Collections: {}
		}
	};


// Scope de la aplicación.
(function(){
	/**
	 *	Declaración model.
	 **/
	app.Modules.Models.Opcion = Backbone.Model.extend({
		defaults: {
			texto: '',
			tipo: 'unica',
			cerrar: true,
			id_op: '',
		},

		toggle: function() {
			this.set({cerrar : !this.get('cerrar')});
		}


	});


	/**
	 *	Declaración colección.
	 **/
	 app.Modules.Collections.Opciones = Backbone.Collection.extend({
		model: app.Modules.Models.Opcion,
		
		initialize: function() {
			app.vent.on('intento:opcionView', this.verificarMinimo, this);
		},

		verificarMinimo: function(opcionView) {
			if(this.length>=3){
				opcionView.trigger('eliminar');
			}
		}
	});


	/**
	 *	Vista del modelo.
	**/
	app.Modules.Views.OpcionView = Backbone.View.extend({
		//tagName: 'form-group',
		//className: 'col-md-12',
		template: _.template($('#opcion_template').html()),

		events: {
			'click .close': 'intentoEliminar',
			'click .abierta': 'quitarOpciones',
			'focusout :input': 'guardarValorDigitado'
		},

		initialize: function() {
			this.listenTo(this, 'eliminar', this.eliminarOpcion);
			this.listenTo(this.model, 'change', this.render)
		},

		intentoEliminar: function() {
			app.vent.trigger('intento:opcionView', this);
		},

		eliminarOpcion: function() {
			var that = this;
			this.$el.fadeOut(500, function(){
				that.model.destroy();
				that.remove();
			});
		},
 
		render: function () {
			this.$el.html(this.template(this.model.toJSON()));
			return this;
		},

		guardarValorDigitado: function(e){
			console.log('perdio foco');
			console.log($(e.target).val());
			this.model.set('texto', $(e.target).val());
		}

	});


	/**
	 *	Vista de la colección.
	 **/
	app.Modules.Views.OpcionesView = Backbone.View.extend({
		el: '#opciones',

		initialize: function() {
			this.listenTo(this.collection, 'add', this.nuevaOpcion);
			this.listenTo(this.collection, 'reset', this.agregarTodas);
			this.listenTo(this.collection, 'destroy', this.verificarIconoCerrar);
			this.listenTo(this.collection, 'add', this.verificarIconoCerrar);
			this.listenTo(this.collection, 'all', this.render);
			this.agregarTodas();
		},

		// Oculta o muestra el icono de cerrar de cada opción.
		verificarIconoCerrar: function(){
			console.log('aaa');
			console.log(this.collection.length);
			//debugger;
			if(this.collection.length <= 2){
				this.collection.forEach(function(opcion){
					if(opcion.get('cerrar') === true)
						opcion.toggle();
				});
			
			}else{
				//this.collection <= 2){
				this.collection.forEach(function(opcion){
					if(opcion.get('cerrar') === false)
						opcion.toggle();
					//this.i++;
				});
			}
			
		},

		nuevaOpcion: function(opcion) {
			var opcionView = new app.Modules.Views.OpcionView({
				model: opcion
			});
			var nuevo=opcionView.render().el;
			$(nuevo).hide();
			this.$el.append(nuevo);
			$(nuevo).fadeIn('fast');
		},

		agregarTodas: function() {
			this.collection.forEach(this.nuevaOpcion, this);
		}
	});


	/**
	 *	Vista de la aplicación de entrada.
	 **/
	app.Modules.Views.AppView = Backbone.View.extend({
		el: '#pregunta-form',
		
		events: {
			'click #agregar_opcion': 'agregarOpcion',
			'click .radio_tipo': 'cambiarTipo'
		},

		initialize: function() {
			app.Views.OpcionesView = new app.Modules.Views.OpcionesView({
				collection: this.collection
			});
		},

		agregarOpcion: function (e) {
			e.preventDefault();
			this.collection.add(new app.Modules.Models.Opcion());
		},

		cambiarTipo: function(e) {
			e.preventDefault();

			var tipo = $(e.target).children(":first").val();
			console.log(tipo);
			if(tipo === 'abierta'){
				$('#panel_opciones').slideUp('fast', function(){
					$('#tipo_abierta_opciones').slideDown('fast');
				});
			}else if(tipo === 'unica' || tipo === 'multiple'){
				$('#tipo_abierta_opciones').slideUp('fast', function(){
					$('#panel_opciones').slideDown('fast');
				});
			}
		}
	});	

	app.vent = _.extend({}, Backbone.Events);

	/**
	 * 	Generación de una instancia inicial de la colección de opciones. Para que minimo tenga dos opciones si es una pregunta nueva o muestre
	 * 	las opciones existentes si se está editando una pregunta..
	 **/ 
	app.Collections.Opciones = new app.Modules.Collections.Opciones();
	if(opcionesExistentes.length === 0)
	{
		app.Collections.Opciones.add(new app.Modules.Models.Opcion({ cerrar: false }));
		app.Collections.Opciones.add(new app.Modules.Models.Opcion({ cerrar: false }));
	}
	else
	{
		opcionesExistentes.forEach(function(opcion) {
		    app.Collections.Opciones.add(new app.Modules.Models.Opcion({ id_op: opcion.id_op, texto: opcion.txtop}));
		});
	}

	/**
	 * 	Instancia de la aplicación. Se inyecta la colección inicial. 	
	 **/ 

	app.Views.AppView = new app.Modules.Views.AppView({
		collection: app.Collections.Opciones
	});

}());