define( [ 'views/service', 'models/serviceCollection' ], function( ServiceView, ServiceCollection ) {
    var view = Marionette.CollectionView.extend( {

      collection: new ServiceCollection(),

      className: 'wrap apps-container', /* Reusing "App" section styles. */

      childView: ServiceView,

      initialize: function() {
        this.collection.fetch();
      }

    } );
    return view;
} );
