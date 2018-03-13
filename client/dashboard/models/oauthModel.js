define( [], function() {
  var model = Backbone.Model.extend( {
    defaults: {
      connected: true,
      connect_url: '',
    },

    url: function() {
      return ajaxurl + "?action=nf_oauth";
    },

    initialize: function() {
      /* ... */
    },

    parse: function( response, options ){
        return response.data;
    },

  } );

  return model;
} );
