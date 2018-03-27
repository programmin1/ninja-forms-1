define( [], function() {
  var model = Backbone.Model.extend( {
    defaults: {
      objectType: 'service',
      name: '',
      slug: '',
      description: '',
      enabled: null,
      infoLink: null,
      serviceLink: null
    },

    url: function() {
      return ajaxurl + "?action=nf_service_" + this.get( 'slug' );
    },

    initialize: function() {
    /* ... */
    },

    save: function() {
      var that = this;
      jQuery.ajax({
          type: "POST",
          url: this.url(),
          data: this.toJSON()
      }).done( function( response ){
        if( '200' !== response ) {
          alert( 'Unable to update the service.' );
          that.set( 'enabled', ! that.get( 'enabled' ) );
        }
        nfRadio.channel( 'dashboard').trigger( 'save:service-' + that.get( 'slug' )  );
      });
    }

  } );

  return model;
} );
