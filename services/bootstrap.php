<?php

namespace NinjaForms;

if( ! defined( 'NF_SERVER_URL' ) )
  define( 'NF_SERVER_URL', 'http://my.ninjaforms.com' );

// Setup OAuth as a prerequisite for services.
include_once plugin_dir_path( __FILE__ ) . 'oauth.php';
OAuth::set_base_url( NF_SERVER_URL . '/oauth' );
OAuth::getInstance()->setup();

add_action( 'wp_ajax_nf_services', function(){
  $services = apply_filters( 'ninja_forms_services', [
    'addon-manager' => [
      'name' => __( 'Addon Manager', 'ninja-forms' ),
      'slug' => 'addon-manager',
      'enabled' => null,
      'description' => 'Manage Addons for Ninja Forms',
      'infoLink' => [
        'text' => 'Learn More',
        'href' => 'https://ninjaforms.com/services/addon-manager',
        'classes' => 'nf-button primary'
      ]
    ],
    'transactional-email' => [
      'name' => __( 'Transactional Email', 'ninja-mail' ),
      'slug' => 'transactional-email',
      'description' => 'Increase Email Deliverability with a dedicated email service by Ninja Forms.',
      'enabled' => null,
      'infoLink' => [
        'text' => 'Learn More',
        'href' => 'https://ninjaforms.com/services/transactional-email',
        'classes' => 'nf-button primary'
      ]
    ],
  ] );
  wp_die( json_encode( [ 'data' => array_values( $services ) ] ) );
});

add_action( 'admin_enqueue_scripts', function() {
  wp_localize_script( 'nf-dashboard', 'nfPromotions', 'YOLO' );
});
