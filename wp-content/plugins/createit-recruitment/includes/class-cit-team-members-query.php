<?php
if ( !defined('ABSPATH') ) {
  exit;
}

if ( !class_exists('CIT_Team_Members_Query') ) {
  class CIT_Team_Members_Query {
    public $image_sizes = array( 'full', 'thumbnail', 'medium', 'large' ); // TO DO: might want to make this dynamic by getting all image sizes?
    public $team_members = array();
    public $query;

    public function __construct( $args )
    {
      $this->query( $args );
    }

    public function query( $args )
    {
      $defaults = array(
        'order' => 'desc',
        'orderby' => 'date',
        'posts_per_page' => get_option( 'posts_per_page' )
      );
      $args = wp_parse_args( $args, $defaults );

      $args['post_type'] = 'team-members';

      $query = new WP_Query( $args );

      foreach( $query->posts as $team_member_wp_post_obj ) {
        $this->append_team_member( $team_member_wp_post_obj );
      }
    }

    public function append_team_member( $team_member_wp_post_obj ) {
      $team_member = array();

      $team_member['post'] = $team_member_wp_post_obj;
      $team_member['name'] = $team_member_wp_post_obj->post_title;
      
      $team_member['images'] = $this->get_post_featured_image( $team_member_wp_post_obj->ID );
      
      $this->team_members[] = $team_member;
    }

    public function get_post_featured_image( $post_id ) {
      $image_sizes = array();

      $attachment_id = get_post_thumbnail_id( $post_id );
      foreach( $this->image_sizes as $image_size ) {
        $attachment = wp_get_attachment_image_src( $attachment_id, $image_size );

        $image_sizes[ $image_size ] = array(
          'src' => $attachment[0],
          'width' => $attachment[1],
          'height' => $attachment[2]
        );
      }

      return $image_sizes;
    }
  }
}