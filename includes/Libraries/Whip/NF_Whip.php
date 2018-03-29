<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Whip
{
    public function __construct()
    {
        add_action( 'admin_notices', array( $this, 'whip_message' ) );
    }

    public function whip_message()
    {

        $message = '';
    }
}