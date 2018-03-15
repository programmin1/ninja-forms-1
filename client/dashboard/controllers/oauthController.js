define([ 'models/oauthModel' ], function( OAuthModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.oauth = new OAuthModel();

      nfRadio.channel( 'dashboard' ).reply( 'get:oauth', this.getOAuth, this );

			this.oauth.fetch({
				success: function( model ){
            nfRadio.channel( 'dashboard' ).trigger( 'fetch:oauth' );
				}
			});
		},

		getOAuth: function() {
			return this.oauth;
		},
	});

	return controller;
} );
