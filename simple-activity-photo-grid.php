<?php
/**
 * Plugin Name: MediaPress - Simple Activity Photo Grid Example
 * Plugin URI: http://buddydev.com/plugins/mpp-slick-slider-view/
 * Version: 1.0.0
 * Author: BuddyDev Team
 * Author URI: http://buddydev.com
 * Description: Use another activity grid view
 * 
 * License: GPL2 or Above
 * 
 */

/**
 * You don't need to use this plugin if your only purpose is to modify the layout of activity media.
 * You can simply copy wp-content/plugin/mediapress/templates/default/buddypress/activity/views to
 * your-theme/mediapress/default/buddypress/activity/views and then
 * you can modify grid-photo.php or grid-audio.php etc to as you wish
 *
 * This plugin simply shows the possibility to add new views for activity instead of just overriding one
 *
 * */
/*
 * Class MPP_Simple_Activity_Photo_Grid_Helper
 */
class MPP_Simple_Activity_Photo_Grid_Helper {
	/**
	 * Singleton Instance
	 * 
	 * @var MPP_Simple_Activity_Photo_Grid_Helper
	 */
	private static $instance = null;
	
	private $path;
	private $url;
	
	
	private function __construct () {
		
		$this->setup();
	}
	
	/**
	 * Get the singleton instance
	 * 
	 * @return MPP_Simple_Activity_Photo_Grid_Helper
	 */
	public static function get_instance() {
		
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
		
	}
	/**
	 * Setup hooks 
	 */
	private function setup() {
		
		//setup plugin path
		$this->path = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );

		
		//load files when MediaPress is loaded
		add_action( 'mpp_loaded', array( $this, 'load' ) );
        //register view
		add_action( 'mpp_setup_core', array( $this, 'register_views' ) );
        //load translations
		add_action( 'mpp_init', array( $this, 'load_textdomain' ) );
		
	}
	
	/**
	 * Load required files
	 */
	public function load() {

		require_once $this->path . 'core/class-mpp-simple-activity-grid-view.php' ;

	}

    /**
     * Register a View for displaying activity photo
     *
     * This is the only useful function in this plugin
     * Rest of the code in this class is just boilerplate
     */
	public function register_views() {

		//We register a View to type
        //The View class declares which speicifc views(activity|gallery|widgets etc) they support
		mpp_register_gallery_view( 'photo', MPP_Simple_Activity_Media_Grid_View::get_instance() );
		
	}
	/**
	 * Load plugin translations
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'mpp-simple-activity-grid', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	/**
	 *	Get the plugin directory absolute url
	 *  
	 * @return string url to the plugin directory e.g. http://example.com/wp-content/plugins/xyz-addon/
	 */
	public function get_url() {
		return $this->url;
	}
	
	/**
	 * Get absolute path to this plugin directory
	 * 
	 * @return string the real path tot his plugin directory e.g /var/www/xyz/wp/wp-content/plugins/mpp-skeleton-addon/
	 */
	public function get_path() {
		return $this->path;
	}
	
}
//initialize
MPP_Simple_Activity_Photo_Grid_Helper::get_instance();
/**
 * A shortcut function to allow access to the singleton instance of the Addon
 * 
 * @return MPP_Simple_Activity_Photo_Grid_Helper
 */
function mpp_simple_activity_photo_grid_helper() {
	
	return MPP_Simple_Activity_Photo_Grid_Helper::get_instance();
}