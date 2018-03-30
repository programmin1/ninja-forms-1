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
