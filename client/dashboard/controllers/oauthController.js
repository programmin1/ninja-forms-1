define([ 'models/oauthModel' ], function( OAuthModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.oauth = new OAuthModel();

      nfRadio.channel( 'dashboard' ).reply( 'get:oauth', this.getOAuth, this );
			nfRadio.channel( 'dashboard' ).reply( 'disconnect:oauth', this.disconnect, this );

			this.initOAuth();
		},

		getOAuth: function() {
			return this.oauth;
		},

		initOAuth: function() {
			this.oauth.fetch({
				success: function( model ){
						nfRadio.channel( 'dashboard' ).trigger( 'fetch:oauth' );
				}
			});
		},

		disconnect: function() {
			var that = this;
      jQuery.ajax({
        type: "POST",
        url: ajaxurl + '?action=nf_oauth_disconnect',
        success: function( response ){
					that.initOAuth();
        }
      });
		}
	});

	return controller;
} );
