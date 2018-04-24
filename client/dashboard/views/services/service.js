define( [], function() {
    var view = Marionette.View.extend( {

      template: '#tmpl-nf-service',

      className: function(){
        return 'nf-extend nf-box ' + this.model.get( 'classes' );
      },

      ui: {
          install: '.js--install',
          learnMore: '.js--learn-more',
          enabled: '.nf-toggle.setting',
          toggleEnable: '.nf-toggle + label',
      },

      events: {
          'click @ui.install': function() {
            nfRadio.channel( 'dashboard' ).request( 'install:service', this.model );
          },
          'click @ui.learnMore': function() {
            this.showLearnMore();
          },
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

        this.listenTo( this.model, 'change', this.render );

        nfRadio.channel( 'dashboard' ).reply( 'more:service:' + this.model.get( 'slug' ), this.showLearnMore, this );
        this.listenTo( nfRadio.channel( 'dashboard' ), 'fetch:oauth', this.updateOAuth );
        this.listenTo( nfRadio.channel( 'dashboard' ), 'save:service-' + this.model.get( 'slug' ), this.render );
      },

      showLearnMore: function() {
        var that = this;
        new jBox( 'Confirm', {
                        width: 300,
                        addClass: 'dashboard-modal',
                        overlay: true,
                        closeOnClick: 'body',
                        content: this.model.get( 'learnMore' ),
                        confirmButton: 'Setup',
                        cancelButton: 'Close',
                        closeOnConfirm: true,
                        confirm: function(){
                          nfRadio.channel( 'dashboard' ).request( 'install:service', that.model );
                        }
                    } ).open();
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
