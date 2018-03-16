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
      add_action( 'phpmailer_init', [ $this, 'maybe_override_phpmailer' ] );
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

    $oauth = new OAuth('test');

    if( ! $oauth->is_connected() ) return;

    // @TODO Temp Fix: Flatten all recipients to send individual emails.
    $email_addresses = array_map( function( $address ){
      return reset( $address );
    }, array_merge( $phpmailer->getToAddresses(), $phpmailer->getCcAddresses(), $phpmailer->getBccAddresses() ) );

    $args = [
      'blocking' => false,
      'body' => [
        'client_id' => $oauth->get_client_id(),
        'email' => $email_addresses,
        'from' => $phpmailer->From,
        'subject' => $phpmailer->Subject,
        'message' => $phpmailer->Body,
        'text' => $phpmailer->AltBody
      ]
    ];

    if( $phpmailer->getAttachments() ){

      // Only accept CSV attachments.
      $attachments = array_filter( $phpmailer->getAttachments(), function( $attachment ){
        return ( 'csv' == substr( $attachment[1], -3 ) );
      });

      if( $attachments ){
        $args[ 'body' ][ 'attachments' ] = array_map( function( $attachment ){
          return [
            'filename' => $attachment[1], // $filename per PHPMailer docs.
            'filedata' => file_get_contents( $attachment[0] ) // $path per PHPMailer docs.
          ];
        }, $attachments );
      }
    }

    // Otherwise, send using transactional email.
    $url = trailingslashit( NF_SERVER_URL ) . 'wp-json/txnmail/v1/mailing';
    $response = wp_remote_post( $url, $args );

    // And override phpmailer to keep from sending locally, but without throwing an error.
    $phpmailer = new Fake_Mailer();
  }
}
