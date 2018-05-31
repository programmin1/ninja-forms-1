<?php
final class NF_Database_SubmissionDeletionController
{

    public function __construct()
    {
        add_action( 'nf_admin_init', array( $this, 'test' ), 9999 );
    }

    public function test()
    {
        $options = get_option( 'nf_sub_expiration' );

        if( empty( $options ) ) return;


        foreach( $options as $option ) {
            $option = explode( ',', $option );

            $expired_subs[] = $this->get_expired_subs( $option[ 0 ], $option[ 1 ] );
        }

        echo '<pre>';
        var_dump( $expired_subs );
        echo '</pre>';
    }

    public function get_expired_subs( $form_id, $expiration_time )
    {
        $expired_subs = array();

        $deletion_timestamp = 24 * 60 * 60 * $expiration_time;

        $deletion_timestamp = time() - $deletion_timestamp;

        $sub = Ninja_Forms()->form( $form_id )->get_subs();
        foreach( $sub as $sub_model ) {
            $sub_timestamp = strtotime( $sub_model->get_sub_date( 'Y-m-d') );
            if( $sub_timestamp <= $deletion_timestamp ) {
                $expired_subs[] = $sub_model->get_id();
            }
        }
        return $expired_subs;
    }
}