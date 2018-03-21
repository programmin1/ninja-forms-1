<?php

namespace NinjaForms;

if( ! defined( 'NF_SERVER_URL' ) )
  define( NF_SERVER_URL, 'http://my.ninjaforms.com' );

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
      'link' => 'https://ninjaforms.com/services/addon-manager'
    ],
    'transactional-email' => [
      'name' => __( 'Transactional Email', 'ninja-mail' ),
      'slug' => 'transactional-email',
      'description' => 'Increase Email Deliverability with a dedicated email service by Ninja Forms.',
      'enabled' => null,
      'link' => 'https://ninjaforms.com/services/transactional-email'
    ],
  ] );
  wp_die( json_encode( [ 'data' => array_values( $services ) ] ) );
});
