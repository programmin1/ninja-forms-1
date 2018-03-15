<?php

namespace NinjaForms\Services;

use NinjaForms\Services\OAuth;
use NinjaForms\Services\Transactional_Email\Fake_Mailer;

class Transactional_Email
{
  public function __construct() {

  }

  public function setup() {

    if( get_option( 'ninja_forms_transactional_email_enabled' ) ){
      add_action( 'phpmailer_init', 'maybe_override_phpmailer' );
    }

    add_action( 'wp_ajax_nf_service_transactional_email', function(){
      if( 'true' == $_POST[ 'enabled' ] ){
        update_option( 'ninja_forms_transactional_email_enabled', true );
      } else {
        update_option( 'ninja_forms_transactional_email_enabled', false );
      }
      wp_die( 1 );
    });
  }

  public function maybe_override_phpmailer( &$phpmailer ) {

    $headers = $phpmailer->getCustomHeaders();

    // Check for Ninja Forms headers. If not there, move along.
    if( ! in_array( 'X-Ninja-Forms', $headers[0] ) ) return;



    // $oauth = new OAuth();
    //
    // if( ! $oauth->is_connected() ) return;

    $args = [
      'blocking' => false,
      'body' => [
        'client_id' => $oauth->client_id,
        'email' => $phpmailer->getToAddresses()[0][0], // @TODO handle multiple recipients.
        'from' => $phpmailer->From,
        'subject' => $phpmailer->Subject,
        'message' => $phpmailer->Body,
        'text' => $phpmailer->AltBody
      ]
    ];

    // Otherwise, send using transactional email.
    $url = trailingslashit( NF_SERVER_URL ) . 'wp-json/txnmail/v1/mailing';
    $response = wp_remote_post( $url, $args );

    // And override phpmailer to keep from sending locally, but without throwing an error.
    $phpmailer = new Fake_Mailer();
  }
}
