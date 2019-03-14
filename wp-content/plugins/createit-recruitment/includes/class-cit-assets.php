<?php
  if ( !defined('ABSPATH') ) {
    exit;
  }
  
  if ( !class_exists('CIT_Assets') ) {
    class CIT_Assets {
      public function __construct()
      {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts_and_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ) );
      }

      public function register_scripts_and_styles()
      {
        $assets = cit()->plugin_url() . '/assets/';
        $libs = cit()->plugin_url() . '/libs/';
        
        wp_register_style( 'bootstrap', $libs . 'bootstrap/dist/css/bootstrap.min.css' );
        
        wp_register_script( 'fancybox', $libs . 'fancybox/dist/jquery.fancybox.min.js' );
        wp_register_style( 'fancybox', $libs . 'fancybox/dist/jquery.fancybox.min.css' );

        wp_register_script( 'createit-recruitment', $assets . 'js/scripts.min.js' );
        wp_register_style( 'createit-recruitment', $assets . 'css/style.min.css' );
      }

      public function enqueue_scripts_and_styles()
      {
        wp_enqueue_style( 'bootstrap' );
      }
    }
  }
  new CIT_Assets;