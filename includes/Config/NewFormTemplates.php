<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
    'slug_name' => array(
        //Same as slug name/
        'id'            => 'slug_name',
        'title'         => 'nicename',
        'template-desc' => '',
    ),
 */

return apply_filters( 'ninja_forms_new_form_templates', array(
    /**
     * Regular old form templates
     */

    'formtemplate-contactform'          => array(
        'id'                            => 'formtemplate-contactform',
        'title'                         => __( 'Contact Us', 'ninja-forms' ),
        'template-desc'                 => __( 'Allow your users to contact you with this simple contact form. You can add and remove fields as needed.', 'ninja-forms' ),
    ),

    'formtemplate-quoterequest'         => array(
        'id'                            => 'formtemplate-quoterequest',
        'title'                         => __( 'Quote Request', 'ninja-forms' ),
        'template-desc'                 => __( 'Manage quote requests from your website easily with this template. You can add and remove fields as needed.', 'ninja-forms' ),
    ),

    'formtemplate-eventregistration'    => array(
        'id'                            => 'formtemplate-eventregistration',
        'title'                         => __( 'Event Registration', 'ninja-forms' ),
        'template-desc'                 => __( 'Allow user to register for your next event this easy to complete form. You can add and remove fields as needed.', 'ninja-forms' ),
    ),

    'formtemplate-productorder'         => array(
        'id'                            => 'formtemplate-productorder',
        'title'                         => __( 'Product Order Form', 'ninja-forms' ),
        'template-desc'                 => __( 'Collect user information so that you can send an invoice and product. You can add and remove fields as needed.', 'ninja-forms' ),
    ),

    'formtemplate-feedback'         => array(
        'id'                            => 'formtemplate-feedback',
        'title'                         => __( 'Collect feedback', 'ninja-forms' ),
        'template-desc'                 => __( 'Collect feedback for an event, blog post, or anything else. You can add and remove fields as needed.', 'ninja-forms' ),
    ),



    /**
     * Ads
     */

    'mailchimp-signup'                  => array(
        'id'                            => 'mailchimp-signup',
        'title'                         => __( 'MailChimp Signup', 'ninja-forms' ),
        'template-desc'                 => __( 'Add a user to a list in MailChimp', 'ninja-forms' ),
        'type'                          => 'ad',
        'modal-title'                   => 'Get MailChimp for Ninja Forms',
        'modal-content'                 => '<img src="' . Ninja_Forms::$url . 'assets/img/add-ons/mailchimp-for-ninja-forms.png"/>
                                            <p>In order to use this template, you need MailChimp for Ninja Forms.</p>
                                            <p>The MailChimp extension allows you to quickly create newsletter signup forms for your MailChimp account using the power and flexibility that Ninja Forms provides.</p>
                                            <div class="actions">
                                                <a target="_blank" href="https://ninjaforms.com/extensions/mail-chimp/?utm_medium=plugin&amp;utm_source=new-form-templates&amp;utm_campaign=Ninja+Forms+Addons+Page&amp;utm_content=MailChimp" title="MailChimp" class="primary nf-button">Learn More</a>
                                            </div>',
    ),

    'stripe-payment'                    => array(
        'id'                            => 'stripe-payment',
        'title'                         => __( 'Stripe Payment', 'ninja-forms' ),
        'template-desc'                 => __( 'Collect a payment using Stripe', 'ninja-forms' ),
        'type'                          => 'ad',
        'modal-title'                   => 'Get Stripe for Ninja Forms',
        'modal-content'                 => '<div class="video-wrapper"><iframe src="https://www.youtube.com/embed/WdFmgAffA50" allowfullscreen="" name="fitvid0" frameborder="0"></iframe></div>
                                            <p>In order to use this template, you need Stripe for Ninja Forms.</p>
                                            <div class="actions">
                                                <a target="_blank" href="https://ninjaforms.com/extensions/stripe/?utm_medium=plugin&utm_source=new-form-templates&utm_campaign=Ninja+Forms+Addons+Page&utm_content=Stripe" title="MailChimp" class="primary nf-button">Learn More</a>
                                            </div>',
    ),

    'file-upload'                       => array(
        'id'                            => 'file-upload',
        'title'                         => __( 'File Upload', 'ninja-forms' ),
        'template-desc'                 => __( 'Allow users to upload files with their forms.', 'ninja-forms' ),
        'type'                          => 'ad',
        'modal-title'                   => 'Get File Uploads for Ninja Forms',
        'modal-content'                 => '<div class="video-wrapper"><iframe src="https://www.youtube.com/embed/Tl91cuFsnvM" allowfullscreen="" name="fitvid0" frameborder="0"></iframe></div>
                                            <p>In order to use this template, you need File Uploads for Ninja Forms.</p>
                                            <div class="actions">
                                                <a target="_blank" href="https://ninjaforms.com/extensions/stripe/?utm_medium=plugin&utm_source=new-form-templates&utm_campaign=Ninja+Forms+Addons+Page&utm_content=Stripe" title="MailChimp" class="primary nf-button">Learn More</a>
                                            </div>',
    ),

    'paypal-payment'                    => array(
        'id'                            => 'paypal-payment',
        'title'                         => __( 'PayPal Payment', 'ninja-forms' ),
        'template-desc'                 => __( 'Collect a payment using PayPal Express', 'ninja-forms' ),
        'type'                          => 'ad',
        'modal-title'                   => 'Get PayPal Express for Ninja Forms',
        'modal-content'                 => '<img src="' . Ninja_Forms::$url . 'assets/img/add-ons/paypal-express.png"/>
                                            <p>In order to use this template, you need PayPal Express for Ninja Forms.</p>
                                            <p>PayPal Express allows you to accept payments using Ninja Forms. It leverages the powerful processing engine that runs each Ninja Form to get a total, perform a checkout, and send your users to PayPal to complete their transaction.</p>
                                            <div class="actions">
                                                <a target="_blank" href="https://ninjaforms.com/extensions/paypal-express/?utm_medium=plugin&utm_source=new-form-templates&utm_campaign=Ninja+Forms+Addons+Page&utm_content=PayPal+Express" title="MailChimp" class="primary nf-button">Learn More</a>
                                            </div>',
    ),

    'create-post'                       => array(
        'id'                            => 'create-post',
        'title'                         => __( 'Create a Post', 'ninja-forms' ),
        'template-desc'                 => __( 'Allow users to create posts from the front-end using a form, including custom post meta!', 'ninja-forms' ),
        'type'                          => 'ad',
        'modal-title'                   => 'Get Front-End Posting for Ninja Forms',
        'modal-content'                 => '<img src="' . Ninja_Forms::$url . 'assets/img/add-ons/front-end-posting.png"/>
                                            <p>In order to use this template, you need User Management for Ninja Forms.</p>
                                            <p>Create posts, pages, or any custom post type from the front-end.</p>
                                            <p>The Ninja Forms Front-end Posting extension gives you the power of the WordPress post editor on any publicly viewable page you choose.</p>
                                            <div class="actions">
                                                <a target="_blank" href="https://ninjaforms.com/extensions/user-management/?utm_medium=plugin&utm_source=new-form-templates&utm_campaign=Ninja+Forms+Addons+Page&utm_content=User+Management" title="MailChimp" class="primary nf-button">Learn More</a>
                                            </div>',
    ),

    'register-user'                     => array(
        'id'                            => 'register-user',
        'title'                         => __( 'Register a User', 'ninja-forms' ),
        'template-desc'                 => __( 'Register a WordPress User', 'ninja-forms' ),
        'type'                          => 'ad',
        'modal-title'                   => 'Get User Management for Ninja Forms',
        'modal-content'                 => '<img src="' . Ninja_Forms::$url . 'assets/img/add-ons/user-management-product-graphic.png"/>
                                            <p>In order to use this template, you need User Management for Ninja Forms.</p>
                                            <p>User Management brings you the remarkable flexibility to register new WordPress users and manage existing ones through your Ninja Forms!</p>
                                            <div class="actions">
                                                <a target="_blank" href="https://ninjaforms.com/extensions/user-management/?utm_medium=plugin&utm_source=new-form-templates&utm_campaign=Ninja+Forms+Addons+Page&utm_content=User+Management" title="MailChimp" class="primary nf-button">Learn More</a>
                                            </div>',
    ),

    'update-profile'                    => array(
        'id'                            => 'update-profile',
        'title'                         => __( 'Update User Profile', 'ninja-forms' ),
        'template-desc'                 => __( 'Allow WordPress users to edit their profiles from the front-end, including custom user meta!', 'ninja-forms' ),
        'type'                          => 'ad',
        'modal-title'                   => 'Get User Management for Ninja Forms',
        'modal-content'                 => '<img src="' . Ninja_Forms::$url . 'assets/img/add-ons/user-management-product-graphic.png"/>
                                            <p>In order to use this template, you need User Management for Ninja Forms.</p>
                                            <p>User Management brings you the remarkable flexibility to register new WordPress users and manage existing ones through your Ninja Forms!</p>
                                            <div class="actions">
                                                <a target="_blank" href="https://ninjaforms.com/extensions/user-management/?utm_medium=plugin&utm_source=new-form-templates&utm_campaign=Ninja+Forms+Addons+Page&utm_content=User+Management" title="MailChimp" class="primary nf-button">Learn More</a>
                                            </div>',
    ),
) );