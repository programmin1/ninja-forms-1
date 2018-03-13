<?php

namespace NinjaForms\Services;

// Services require PHP v5.6+
if( version_compare( PHP_VERSION, '5.6', '<' ) ) return;

// Setup OAuth as a prerequisite for services.
include_once plugin_dir_path( __FILE__ ) . 'oauth.php';
(new OAuth('https://my.ninjaforms.com/oauth'))->setup();

add_action( 'wp_ajax_nf_oauth', function(){

});

add_action( 'wp_ajax_nf_services', function(){
  $services = [
    [
      'name' => 'Transactional Email',
      'enabled' => false,
      'description' => 'Increase Email Deliverability with a dedicated email service by Ninja Forms.',
      'image' => 'https://placehold.it/400x163&text=Transactional%20Email',
    ],
  ];

  wp_die( json_encode( [ 'data' => $services ] ) );
});
