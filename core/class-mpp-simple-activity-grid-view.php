<?php
/**
 * Implementing a subclass of MPP_Gallery_View that supports Activity View
 */
class MPP_Simple_Activity_Media_Grid_View extends MPP_Gallery_View {
	
	private static $instance = null;
	
	protected function __construct() {
		
		parent::__construct();
		//the id is very important and is used internally
		//must be unique per media type type, should not contain spaces and it is recommentded to use lowercase alphabet and -, _, avoid starting with digits
        //We do not specify a View to media type association here
        //It is registered on mpp_setup or mpp_init action later to allow reusing same view for multiple types

		$this->id = 'activity-simple-photo-grid';

        //This name appears in the Admin Settings Setion where the default view is selected
		$this->name = __( 'Simple Activity Photo Grid', 'mpp-simple-activity-photo-grid' );

        //this view only supports activity, see the MPP_Gallery_View for more details
		$this->supported_views = array('activity');//only activity view will be supported by this
	}

    /**
     * I am implementing it as a singleton but you don't need to do that unless you are using a View to support multiple types
     * In that case, singleton will save some memory
     *
     * @return MPP_Simple_Activity_Media_Grid_View|null
     */
	public static function get_instance() {
		
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}

	/**
	 * Render View template for the media attached to activity
	 *  if this View is set as default view for activity
     * in the MediaPress settings screen
     *
	 * @param int[] $media_ids
	 * @return null
	 */
	public function activity_display( $media_ids = array() ) {

        //just checking that we have some media
		if ( ! $media_ids ) {
			return ;
		}
		
		$media = $media_ids[0];
		//another check to make sure that there is one valid media
		$media = mpp_get_media( $media );
		
		if ( ! $media ) {
			return ;
		}
		
		//this template can be overridden by putting the template file
		//in your theme's mediapress/default/buddypress/activity/views/simple-activity-photo-grid.php
		mpp_get_template( 'buddypress/activity/views/simple-activity-photo-grid.php', array(), mpp_simple_activity_photo_grid_helper()->get_path().'templates' );
		
		
	}
}