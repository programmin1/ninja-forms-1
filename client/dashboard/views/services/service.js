define( [], function() {
    var view = Marionette.View.extend( {

      template: '#tmpl-nf-service',

      className: 'nf-extend nf-box',

      ui: {
          enabled: '.nf-toggle.setting',
          toggleEnable: '.nf-toggle + label',
      },

      events: {
          'click @ui.toggleEnable': function() {
              if( null == this.model.get( 'enabled' ) ){
                if( this.model.get( 'link' ) ){
                  window.location = this.model.get( 'link' );
                  return this.render();
                }
              }
              this.model.set( 'enabled', ! this.model.get( 'enabled' ) );
              this.model.save("enabled");
              this.render();
          },
      },

      initialize: function( oauthModel ) {
        this.updateOAuth();
        this.listenTo( nfRadio.channel( 'dashboard' ), 'fetch:oauth', this.updateOAuth );
        this.listenTo( nfRadio.channel( 'dashboard' ), 'save:service-' + this.model.get( 'slug' ), this.render );
      },

      updateOAuth: function() {
        var oauth = nfRadio.channel( 'dashboard' ).request( 'get:oauth' );
        this.connected = oauth.get( 'connected' );
        this.render();
      },

      templateContext: function() {
        return {
          is_connected: this.connected,
        }
      }

    } );
    return view;
} );
