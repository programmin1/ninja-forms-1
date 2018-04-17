define( [], function() {
  var model = Backbone.Model.extend( {
    defaults: {
      objectType: 'service',
      name: '',
      slug: '',
      installPath: '',
      description: '',
      enabled: null,
      infoLink: null,
      serviceLink: null,
      is_installing: false,
      classes: ''
    },

    url: function() {
      return ajaxurl + "?action=nf_service_" + this.get( 'slug' );
    },

    initialize: function() {
      var that = this;

      // Auto-redirect to the serviceLink on install.
      nfRadio.channel( 'dashboard' ).reply( 'install:service:' + this.get( 'slug' ), function(){
        if( ! that.get( 'serviceLink' ) ) return;
        if( ! that.get( 'serviceLink' ).href ) return;

        var redirect = that.get( 'serviceLink' ).href;

        var oauth = nfRadio.channel( 'dashboard' ).request( 'get:oauth' );
        if( ! oauth.get( 'connected' ) ){
          window.location = oauth.get( 'connect_url' ) + '&redirect=' + redirect;
        } else {
          window.location = redirect;
        }
      } );
    },

    save: function() {
      var that = this;
      jQuery.ajax({
          type: "POST",
          url: this.url(),
          data: this.toJSON()
      }).done( function( response ){
        var data = JSON.parse( response );
        if( 'undefined' !== typeof data.error ) {
          alert( 'Unable to update the service. ' + data.error );
          that.set( 'enabled', ! that.get( 'enabled' ) );
        }
        nfRadio.channel( 'dashboard').trigger( 'save:service-' + that.get( 'slug' )  );
      });
    }

  } );

  return model;
} );
