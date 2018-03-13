define( [], function() {
  var model = Backbone.Model.extend( {
    defaults: {
      objectType: 'service',
      name: '',
      enabled: false,
    },

    url: function() {
      return ajaxurl + "?action=nf_services&nf_service_name=" + this.get( 'name' );
    },

    initialize: function() {
    /* ... */
    },

  } );

  return model;
} );
