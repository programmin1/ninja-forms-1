<?php

namespace NinjaForms\Services;

class OAuth
{
  protected $base_url;

  protected $client_id,
            $client_secret;

  public function __construct( $base_url ) {

    $this->base_url = trailingslashit( $base_url );

    $this->client_id = get_option( 'ninja_forms_oauth_client_id' );

    $this->client_secret = get_option( 'ninja_forms_oauth_client_secret' );
    if( ! $this->client_secret ){
      $this->client_secret = self::generate_secret();
      update_option( 'ninja_forms_oauth_client_secret', $this->client_secret );
    }
  }

  public function setup() {

    add_action( 'wp_ajax_nf_oauth', function(){
      wp_die( json_encode( [
        'data' => [
          'connected' => ( $this->client_id ),
          'connect_url' => $this->connect_url(),
        ]
      ] ) );
    });

    add_action( 'wp_ajax_nf_oauth_connect', [ $this, 'connect' ] );
    add_action( 'wp_ajax_nf_oauth_disconnect', [ $this, 'disconnect' ] );
  }

  public function connect_url() {

    $client_redirect = add_query_arg( [
      'action' => 'nf_oauth_connect',
      'nonce'  => wp_create_nonce( 'nf-oauth-connect' )
    ], admin_url( 'admin-ajax.php' ) );

    return add_query_arg([
        'client_secret' => $this->client_secret,
        'client_redirect' => urlencode( $client_redirect ),
        'client_site_url' => urlencode( site_url() ),
    ], $this->base_url . '/connect' );
  }

  public function connect() {

    wp_verify_nonce( $_REQUEST['nonce'], 'nf-oauth-connect' );

    if( ! isset( $_GET[ 'client_id' ] ) ) return;

    $client_id = sanitize_text_field( $_GET[ 'client_id' ] );
    update_option( 'ninja_forms_oauth_client_id', $client_id );

    wp_safe_redirect( admin_url( 'admin.php?page=ninja-forms#services' ) );
    exit;
  }

  public function disconnect() {

    delete_option( 'ninja_forms_oauth_client_id' );
    delete_option( 'ninja_forms_oauth_client_secret' );

    wp_remote_request( $this->base_url . '/disconnect', [
      'blocking' => false,
      'method' => 'DELETE'
    ] );

    wp_safe_redirect( admin_url() );
    exit;
  }

  public static function generate_secret( $length = 40 ) {

    if( 0 >= $length ) $length = 40; // Min key length.
    if( 255 <= $length ) $length = 255; // Max key length.

    $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';
    for ( $i = 0; $i < $length; $i ++ ) {
        $random_string .= $characters[ rand( 0, strlen( $characters ) - 1 ) ];
    }

    return $random_string;
  }
}
