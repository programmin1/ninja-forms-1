define([ 'models/oauthModel' ], function( OAuthModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.oauth = new OAuthModel();

      nfRadio.channel( 'dashboard' ).reply( 'get:oauth', this.getOAuth, this );
			nfRadio.channel( 'dashboard' ).reply( 'disconnect:oauth', this.disconnect, this );

			nfRadio.channel( 'dashboard' ).reply( 'oauth:learn-more', this.learnMoreModal, this );

			this.initOAuth();
		},

		getOAuth: function() {
			return this.oauth;
		},

		/*
		 * Fetch the OAuth Model add and notify via nfRadio.
		 */
		initOAuth: function() {
			this.oauth.fetch({
				success: function( model ){
						nfRadio.channel( 'dashboard' ).trigger( 'fetch:oauth' );
				}
			});
		},

		/**
		 * Confirm disconnecting services, then POST to the server to to disconnect.
		 */
		disconnect: function() {

			var that = this;

			new jBox('Confirm', {
				width: 750,
				content: 'Disconnecting from my.ninjaforms.com will disrupt the functionality of all services.',
				confirmButton: 'Disconnect',
				cancelButton: 'Stay Connected',
				closeOnConfirm: true,
				confirm: function(){
					jQuery.ajax({
						type: "POST",
						url: ajaxurl + '?action=nf_oauth_disconnect',
						success: function( response ){
							console.log( response );
							that.initOAuth();
						}
					});
				}
			}).open();
		},

		/**
		 * Show a Learn More modal.
		 */
		learnMoreModal: function() {
			var that = this;

			new jBox('Modal', {
				width: 500,
				content: '<p>Since you’re using one of our Ninja Forms services, like Ninja Mail or our Add-on Manager, your site is connected to my.ninjaforms.com. This allows us to send data between your site and my.ninjaforms.com. For details about what is being shared, you can see our <a href="https://ninjaforms.com/privacy-policy/">Privacy Policy</a>.</p>',
			}).open();
		}
	});

	return controller;
} );
