<?php

namespace NinjaForms;

if( ! defined( 'NF_SERVER_URL' ) )
  define( 'NF_SERVER_URL', 'https://my.ninjaforms.com' );

// Setup OAuth as a prerequisite for services.
include_once plugin_dir_path( __FILE__ ) . 'oauth.php';
OAuth::set_base_url( NF_SERVER_URL . '/oauth' );
OAuth::getInstance()->setup();

add_action( 'wp_ajax_nf_services', function(){
  $services = apply_filters( 'ninja_forms_services', [
    'ninja-forms-addon-manager' => [
      'name' => __( 'Add-on Manager (Beta)', 'ninja-mail' ),
      'slug' => 'ninja-forms-addon-manager',
      'installPath' => 'ninja-forms-addon-manager/ninja-forms-addon-manager.php',
      'description' => 'Install Ninja Forms add-ons remotely.',
      'enabled' => null,
      'learnMore' => '<div>Install Ninja Forms add-ons remotely.</div>',
    ],

    'ninja-mail' => [
      'name' => __( 'Transactional Email', 'ninja-mail' ),
      'slug' => 'ninja-mail',
      'installPath' => 'ninja-mail/ninja-mail.php',
      'description' => 'Increase Email Deliverability with a dedicated email service by Ninja Forms for only $5/month/site.',
      'enabled' => null,
      'learnMore' => '
      <h2>Frustrated by your WordPress forms not sending email?</h2>
      <p>Form submission notifications not hitting your inbox? Some of your visitors getting form feedback via email, others not? Just can’t get your form email to work at all?</p>
      <p>It’s an all too common issue in WordPress. There’s now a solution.</p>
      <p>Sign up for Ninja Mail today, and never deal with form email issues again!</p>
      <hr />
      <h3>Why Ninja Mail?</h3>
      <p>Because you can take the pain out of email, starting today!</p>
      <h3>Cut out the middleman.</h3>
      <p>Form email normally depends on your host or a third-party plugin to send it to its destination. That handoff is where the vast majority of email issues arise. No more. With Ninja Mail, we see to your form email being sent personally, from form to inbox.</p>
      <h3>If it doesn’t work, it doesn’t cost a dime.</h3>
      <p>Every new Ninja Mail subscription begins with a 14 day free trial. You’ll know right away if Ninja Mail works for you, and if not, you’re not out a single cent.</p>
      <button style="float:right;" class="nf-button primary" onclick="Backbone.Radio.channel( \'dashboard\' ).request( \'install:service\', \'ninja-mail\' );var spinner = document.createElement(\'span\'); spinner.classList.add(\'dashicons\', \'dashicons-update\', \'dashicons-update-spin\'); this.innerHTML = spinner.outerHTML; console.log( spinner )">Setup</button>
      ',
    ],
  ] );
  wp_die( json_encode( [ 'data' => array_values( $services ) ] ) );
});

add_action( 'admin_enqueue_scripts', function() {
  wp_localize_script( 'nf-dashboard', 'nfPromotions', 'YOLO' );
});

add_action( 'wp_ajax_nf_services_install', function() {

  // register_shutdown_function(function(){
  //   if( ! error_get_last() ) return;
  //   echo '<pre>';
  //   print_r( error_get_last() );
  //   echo '</pre>';
  // });

  if ( ! current_user_can('install_plugins') )
    die( json_encode( [ 'error' => __( 'Sorry, you are not allowed to install plugins on this site.' ) ] ) );

  $plugin = $_REQUEST[ 'plugin' ];
  $install_path = $_REQUEST[ 'install_path' ];

  include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); //for plugins_api..
  $api = plugins_api( 'plugin_information', array(
    'slug' => $plugin,
    'fields' => array(
      'short_description' => false,
      'sections' => false,
      'requires' => false,
      'rating' => false,
      'ratings' => false,
      'downloaded' => false,
      'last_updated' => false,
      'added' => false,
      'tags' => false,
      'compatibility' => false,
      'homepage' => false,
      'donate_link' => false,
    ),
  ) );

  if ( is_wp_error( $api ) ) {
    die( json_encode( [ 'error' => $api->get_error_message() ] ) );
  }

  if ( ! class_exists( 'Plugin_Upgrader' ) ) {
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
  }

  include_once plugin_dir_path( __FILE__ ) . 'remote-installer-skin.php';
  ob_start();
  $upgrader = new \Plugin_Upgrader( new Remote_Installer_Skin() );

  $install = $upgrader->install( $api->download_link );

  if( ! $install ){
    die( json_encode( [ 'error' => $upgrader->skin->get_errors() ] ) );
  }

  $activated = activate_plugin( $install_path );
  ob_clean();
  if( is_wp_error( $activated ) ){
    die( json_encode( [ 'error' => $activated->get_error_message() ] ) );
  }

  $response = apply_filters( 'nf_services_installed_' . $plugin, '1' );

  echo json_encode( $response );
  die( '1' );
});

/**
 * Override the Ninja Mail download link until published in the repository.
 */
add_filter( 'plugins_api_result', function( $response, $action, $args ){
  if( 'plugin_information' !== $action ) return $response;
  if( 'ninja-mail' !== $args->slug ) return;

  $response = new \stdClass();
  $response->download_link = 'http://my.ninjaforms.com/wp-content/uploads/ninja-mail-9cadb602a6b2e28adc3fa3f30049747220bba116.zip';

  return $response;
}, 10, 3 );

/**
 * Override the Add-on Manager download link until published in the repository.
 */
add_filter( 'plugins_api_result', function( $response, $action, $args ){
  if( 'plugin_information' !== $action ) return $response;
  if( 'ninja-forms-addon-manager' !== $args->slug ) return;

  $response = new \stdClass();
  $response->download_link = 'http://my.ninjaforms.com/wp-content/uploads/ninja-forms-addon-manager-c71361bc441f2205844a0f02f775b2277b75879e.zip';

  return $response;
}, 10, 3 );

add_filter( 'http_request_args', function( $args, $url ){
  if( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    $args['sslverify'] = false; // Local development
    $args['reject_unsafe_urls'] = false;
  }
  return $args;
}, 10, 2 );
