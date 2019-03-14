<?php
  if ( !defined('ABSPATH') ) {
    exit;
  }
  
  if ( !class_exists('CIT_Post_Types') ) {
    class CIT_Post_Types {
      public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
      }

      public function register_post_type()
      {
        register_post_type(
          'team-members',
          array(
            'labels' => array( 'name' => 'Team Members' ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail' )
          )
        );
      }
    }
  }
  new CIT_Post_Types;