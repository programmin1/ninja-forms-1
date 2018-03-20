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
              // nfRadio.channel( 'dashboard' ).trigger( 'forms:delete', this );
          },
      },

    } );
    return view;
} );
