<?php

return apply_filters( 'ninja-forms-dashboard-promotions', [

  /*
  |--------------------------------------------------------------------------
  | Ninja Mail
  |--------------------------------------------------------------------------
  |
  */

  'ninja-mail' => [
    'id' => 'ninja-mail',
    'content' => '<a href="#services"><span class="dashicons dashicons-email-alt"></span>' . __( 'Hosts are bad at sending emails. Improve the reliability of your submission emails! ', 'ninja-forms' ) . '<br /><span class="cta">' . __( 'Try our new Ninja Mail service!', 'ninja-forms' ) . '</span></a>',
    // 'script' => "
    //   new jBox( 'Modal', {
    //       width: 300,
    //       addClass: 'dashboard-modal',
    //       overlay: true,
    //       closeOnClick: 'body',
    //       content: '<div>INSIDE <strong>HTML</strong> GOES HERE.</div>'
    //   } ).open();
    // "
  ],


]);
