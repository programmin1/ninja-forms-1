/**
 * @package Ninja Forms
 * @subpackage Dashboard
 * @copyright (c) 2017 WP Ninjas
 * @since 3.2
 */
define( [ 'views/services/oauth', 'views/services/services' ], function( OAuthView, ServicesView ) {
    var view = Marionette.View.extend( {
        template: '#tmpl-nf-services',

        regions: {
            oauth: '.oauth',
            services: '.services'
        },

        onRender: function() {
            this.showChildView( 'oauth', new OAuthView() );
            this.showChildView( 'services', new ServicesView() );
        }
    } );
    return view;
} );
