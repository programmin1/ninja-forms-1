define( ['models/serviceModel'], function( ServiceModel ) {
	var collection = Backbone.Collection.extend( {
		model: ServiceModel,
		comparator: 'name',

    url: function() {
        return ajaxurl + "?action=nf_services";
    },

		initialize: function() {
      /* ... */
		},

    parse: function( response, options ){
        return response.data;
    },

	} );

	return collection;
} );
