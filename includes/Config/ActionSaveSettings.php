<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_action_email_settings', array(

    /*
     * To
     */

    'fields_save_toggle' => array(
        'name' => 'fields_save_toggle',
        'type' => 'radio',
        'options' => array(
            array( 'label' => __( 'Save All', 'ninja-forms' ), 'value' => 'save_all' ),
            array( 'label' => __( 'Save None', 'ninja-forms' ), 'value' => 'save_none' )
        ),
        'group' => 'primary',
        'label' => __( 'Fields Save', 'ninja-forms' ),
        'value' => 'save_all',
    ),
));

