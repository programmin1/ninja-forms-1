<?php

namespace NinjaForms\Services;

// Services require PHP v5.6+
if( version_compare( PHP_VERSION, '5.6', '<' ) ) return;

// Setup OAuth as a prerequisite for services.
include_once plugin_dir_path( __FILE__ ) . 'oauth.php';
(new OAuth('https://my.ninjaforms.com/oauth'))->setup();

include_once plugin_dir_path( __FILE__ ) . 'transactional-email/fake-mailer.php';
include_once plugin_dir_path( __FILE__ ) . 'transactional-email/transactional-email.php';
(new Transactional_Email())->setup();

add_action( 'wp_ajax_nf_oauth', function(){

});

add_action( 'wp_ajax_nf_services', function(){
  $services = [
    [
      'name' => 'Transactional Email',
      'slug' => 'transactional_email',
      'enabled' => get_option( 'ninja_forms_transactional_email_enabled' ),
      'description' => 'Increase Email Deliverability with a dedicated email service by Ninja Forms.',
      'image' => 'https://placehold.it/400x163&text=Transactional%20Email',
    ],
  ];

  wp_die( json_encode( [ 'data' => $services ] ) );
});
