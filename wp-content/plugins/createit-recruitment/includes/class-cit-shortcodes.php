<?php
  if ( !defined('ABSPATH') ) {
    exit;
  }
  
  if ( !class_exists('CIT_Shortcodes') ) {
    class CIT_Shortcodes {
      public function __construct()
      {
        add_action( 'init', array( $this, 'add_shortcode' ) );
      }

      public function add_shortcode()
      {
        add_shortcode( 'ct_team', array( $this, 'ct_team_shortcode' ) );
      }

      public function ct_team_shortcode( $attributes )
      {
        $query_args = shortcode_atts(
          array(
            'order' => 'asc',
            'orderby' => 'title',
            'limit' => -1,
          ),
          $attributes
        );

        // Substitute 'name' value on orderby to 'title'
        $query_args['orderby'] = $query_args['orderby'] == 'name' ? 'title' : $query_args['orderby'];

        // Substitute 'limit' key to posts_per_page
        $query_args['posts_per_page'] = $query_args['limit'];
        unset($query_args['limit']);

        $attributes = shortcode_atts(
          array(
            'title' => true,
            'image_size' => 'thumbnail',
          ),
          $attributes
        );

        $team_members_query = new CIT_Team_Members_Query( $query_args );

        if ( $attributes['title'] === 'false' ) {
          add_filter( 'cit_shortcode_show_title', '__return_false' );
        }

        add_filter( 'cit_shortcode_image_size', function () use ( $attributes ) { return $attributes['image_size']; } );

        $GLOBALS['team_members'] = $team_members_query->team_members;

        add_action( 'cit_shortcode_title', array( $this, 'shortcode_title' ) );
        add_action( 'cit_shortcode_team_members', array( $this, 'shortcode_list_members' ) );

        $this->enqueue_scripts_styles();

        load_template( cit()->views_path().'/shortcode/team-members.php' );
      }

      public function shortcode_title() {
        $display = apply_filters( 'cit_shortcode_show_title', true );

        if ( $display ) {
          echo apply_filters( 'cit_shortcode_title_html', '<h2>Team Members</h2>' );
        }
      }

      public function shortcode_list_members() {
        global $team_members;

        foreach( $team_members as $team_member ) {
          $GLOBALS['team_member'] = $team_member;
          load_template( cit()->views_path().'/shortcode/team-member.php', false );
          unset($GLOBALS['team_member']);
        }

        unset($GLOBALS['team_members']);
      }

      public function enqueue_scripts_styles() {
        wp_enqueue_style( 'fancybox' );
        wp_enqueue_script( 'fancybox' );

        wp_enqueue_style( 'createit-recruitment' );
        wp_enqueue_script( 'createit-recruitment' );
      }
    }
  }
  new CIT_Shortcodes;