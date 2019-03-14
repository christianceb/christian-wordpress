<?php
/**
 * Plugin Name: createIT Recruitment
 * Description: createIT Recruitment Plugin
 * Version: Always Beta
 * Author: Christian P
 */
if ( !defined('ABSPATH') ) {
	exit;
}

if ( !class_exists('CreateIT') ) {
	final class CreateIT
	{
		protected static $_instance = null;

		public static function instance()
		{
			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		protected function __construct()
		{
			$this->includes();
		}

		public function includes()
		{
			include_once( 'includes/class-cit-assets.php' );
			include_once( 'includes/class-cit-team-members-query.php' );
			include_once( 'includes/class-cit-post-types.php' );
			include_once( 'includes/class-cit-shortcodes.php' );
		}

		public function plugin_path()
		{
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		public function views_path()
		{
			return $this->plugin_path() . '/template';
		}

		public function plugin_url()
		{
			return untrailingslashit( plugin_dir_url( __FILE__ ) );
		}
	}
}

function cit() {
	return CreateIT::instance();
}

$GLOBALS['cit'] = cit();