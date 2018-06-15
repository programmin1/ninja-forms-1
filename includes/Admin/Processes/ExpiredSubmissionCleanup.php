<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Batch_Process
 */
class NF_Admin_Processes_ExpiredSubmissionCleanup extends NF_Abstracts_BatchProcess
{

    /**
     * Constructor
     */
    public function __construct( $data = array() )
    {
        //Bail if we aren't in the admin.
        if ( ! is_admin() )
            return false;

        // Run process.
        $this->process();
    }


    /**
     * Function to loop over the batch.
     */
    public function process()
    {
        if ( ! get_option( 'nf_doing_expired_submission_cleanup' ) ) {
            // Run the startup process.
            $this->startup();
        } // Otherwise... (We've already run startup.)
    }


    /**
     * Function to run any setup steps necessary to begin processing.
     */
    public function startup()
    {
        // Retrieves the option that contains all of our expiration data.
        $expired_sub_option = get_option( 'nf_sub_expiration' );

        $this->expired_subs = array();

        // Loop over our options and ...
        foreach( $expired_sub_option as $sub ) {
            /*
             * Separate our $option values into two positions
             *  $option[ 0 ] = ( int ) form_id
             *  $option[ 1 ] = ( int ) expiration time in days.
             */
            $sub = explode( ',', $sub );

            // Use the helper method to build an array of expired subs.
            $this->expired_subs = array_merge( $this->expired_subs, $this->get_expired_subs( $sub[ 0 ], $sub[ 1 ] ) );
        }

        add_option( 'nf_doing_expired_submission_cleanup', 'true' );
    }


    /**
     * Function to cleanup any lingering temporary elements of a batch process after completion.
     */
    public function cleanup()
    {

    }

    /**
     * Get Expired Subs
     * Gathers our expired subs puts them into an array and returns it.
     *
     * @param $form_id - ( int ) ID of the Form.
     * @param $expiration_time - ( int ) number of days the submissions
     *                                  are set to expire in
     *
     * @return array of all the expired subs that were found.
     */
    public function get_expired_subs( $form_id, $expiration_time )
    {
        // Create the that will house our expired subs.
        $expired_subs = array();

        // Create our deletion timestamp.
        $deletion_timestamp = time() - ( 24 * 60 * 60 * $expiration_time );

        // Get our subs and loop over them.
        $sub = Ninja_Forms()->form( $form_id )->get_subs();
        foreach( $sub as $sub_model ) {
            // Get the sub date and change it to a UNIX time stamp.
            $sub_timestamp = strtotime( $sub_model->get_sub_date( 'Y-m-d') );
            // Compare our timestamps and any expired subs to the array.
            if( $sub_timestamp <= $deletion_timestamp ) {
                $expired_subs[] = $sub_model->get_id();
            }
        }
        return $expired_subs;
    }
}