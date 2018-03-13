define( [ 'models/oauthModel' ], function( OAuthModel ) {
    var view = Marionette.View.extend( {

      model: new OAuthModel(),

      template: '#tmpl-nf-services-oauth',

      initialize: function() {
        var that = this;
        this.model.fetch({
          success:function(){
            that.render();
          }
        });
      }

    } );
    return view;
} );
