/* 
==========================================================================================================
*
*	Aplicación BackboneJS para la generar dinamicamente opcions y sus respectivas opciones de respuesta.
*
*	Creada              : 04 de diciembre de 2013.
*	Última modificación : 05 de diciembre de 2013.
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
			tipo: 'unica'
		},

	});


	/**
	 *	Declaración colección.
	 **/
	 app.Modules.Collections.Opciones = Backbone.Collection.extend({
		model: app.Modules.Models.Opcion,

	});


	/**
	 *	Vista del modelo.
	**/
	app.Modules.Views.OpcionView = Backbone.View.extend({
		//tagName: 'form-group',
		//className: 'col-md-12',
		template: _.template($('#opcion_template').html()),

		events: {
			'click .close': 'eliminarOpcion',
			'click .abierta': 'quitarOpciones'
		},

		eliminarOpcion: function(){
			this.model.destroy();
			this.remove();
		},

		render: function (){
			this.$el.html(this.template(this.model.toJSON()));
			return this;
		},

	});


	/**
	 *	Vista de la colección.
	 **/
	app.Modules.Views.OpcionesView = Backbone.View.extend({
		el: '#opciones',

		initialize: function() {
			this.listenTo(this.collection, 'add', this.nuevaOpcion);
			this.listenTo(this.collection, 'reset', this.agregarTodas);
			this.listenTo(this.collection, 'all', this.render);
			this.agregarTodas();
		},

		nuevaOpcion: function(opcion) {
			var opcionView = new app.Modules.Views.OpcionView({
				model: opcion
			});
			this.$el.append(opcionView.render().el);
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



	/**
	 * 	Generación de una instancia inicial de la colección de opciones. Para que minimo tenga una opción
	 * 	presente.
	 **/ 
	app.Collections.Opciones = new app.Modules.Collections.Opciones([new app.Modules.Models.Opcion()]);

	/**
	 * 	Instancia de la aplicación. Se inyecta la colección inicial. 	
	 **/ 

	app.Views.AppView = new app.Modules.Views.AppView({
		collection: app.Collections.Opciones
	});

}());