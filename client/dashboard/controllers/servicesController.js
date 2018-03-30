define([ 'models/serviceCollection' ], function( ServiceCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.services = new ServiceCollection();

			nfRadio.channel( 'dashboard' ).reply( 'install:service', this.installService, this );
      nfRadio.channel( 'dashboard' ).reply( 'get:services', this.getServices, this );
      this.fetchServices();
		},

		getServices: function() {
			return this.services;
		},

		fetchServices: function() {
			this.services.fetch({
				success: function( model ){
						nfRadio.channel( 'dashboard' ).trigger( 'fetch:services' );
				}
			});
		},

		installService: function( slug, installPath ) {
			var that = this;
			jQuery.post( ajaxurl, { action: 'nf_services_install', plugin: slug, install_path: installPath }, function( response ){
				that.fetchServices();
			} );
		}
	});

	return controller;
} );
