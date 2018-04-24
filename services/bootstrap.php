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
    'addon-manager' => [
      'name' => __( 'Add-on Manager', 'ninja-mail' ),
      'slug' => 'addon-manager',
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
      'learnMore' => '<div>Increase Email Deliverability with a dedicated email service by Ninja Forms for only $5/month/site.</div>',
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
  $response->download_link = 'http://my.ninjaforms.com/wp-content/uploads/ninja-mail-4905a6af0c36e02c052f9c0456e1519ce075d3df.zip';

  return $response;
}, 10, 3 );

add_filter( 'http_request_args', function( $args, $url ){
  if( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    $args['sslverify'] = false; // Local development
    $args['reject_unsafe_urls'] = false;
  }
  return $args;
}, 10, 2 );
