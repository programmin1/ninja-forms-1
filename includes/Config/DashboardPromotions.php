<?php

return apply_filters( 'ninja-forms-dashboard-promotions', [

  /*
  |--------------------------------------------------------------------------
  | Exmaple
  |--------------------------------------------------------------------------
  |
  */

  'txnemail' => [
    'id' => 'txnemail',
    'content' => '<a href="#services"><span class="dashicons dashicons-email-alt"></span>' . __( 'Want to improve the reliability of your submission emails?', 'ninja-forms' ) . '<br /><span class="cta">' . __( 'Try our new Ninja Mail service!', 'ninja-forms' ) . '</span></a>'
  ],

  // /*
  // |--------------------------------------------------------------------------
  // | Exmaple 4
  // |--------------------------------------------------------------------------
  // |
  // */
  // 'exampleB' => [
  //   'id' => 'exampleB',
  //   'content' => '<a href="#services"><img height="100px" width="750px" style="display:block;margin:auto;" src="https://placehold.it/750x100&text=Services+Ad+[B]" /></a>'
  // ],

]);
