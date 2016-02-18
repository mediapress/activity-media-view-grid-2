<?php
// Exit if the file is accessed directly over web
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}
/***
 * Note:-
 * You can copy this file and put it in your theme/mediapress/default/buddypress/activity/views/simple-activity-photo-grid.php
 * and modify as you want
 * It will be used from your theme instead of the plugin directory if your theme has it.
 */
/*** 
 * 
 * Media List attached to an activity
 * This is a fallback template for new media types
 *
 * Our goal here is to show the first Image as a Large image and all images as grid below the first image)
 * I did it as it was needed by Graeme, I know you are smart to do the further modifications if needed :)
 */
$activity_id = bp_get_activity_id();
$media_ids = mpp_activity_get_attached_media_ids( $activity_id );
$mppq = new MPP_Cached_Media_Query( array( 'in' =>  $media_ids ) );
$looper = 0;
$count = count( $media_ids );
//has many images
$has_many = $count > 1 ? true : false;

?>
<div class="mpp-activity-image-viewer">
	
</div>

<?php if ( $mppq->have_media() ): ?>

	<div class="mpp-container mpp-media-list mpp-activity-media-list mpp-activity-photo-list">

		<?php while( $mppq->have_media() ): $mppq->the_media(); $looper++; ?>
			
			<?php if ( $looper == 1 ) :?>
				<?php //first image is always marked as the larger image ;;?>
					<div class="mpp-activity-single-image">
						<a href="<?php mpp_media_permalink();?>" ><img src="<?php mpp_media_src( 'original' );?>" class='mpp-attached-media-item mpp-large-item' data-mpp-activity-id="<?php echo $activity_id;?>" title="<?php echo esc_attr( mpp_get_media_title() );?>" /></a>
					</div>
			<?php endif;?>
			
			<?php if ( $has_many ) :?>
		
				<?php if ( $looper == 1 ):?>
					<div class="mpp-thumb-wrapper">
				<?php endif;?>

				<a href="<?php mpp_media_permalink();?>" ><img src="<?php mpp_media_src( 'thumbnail' );?>" class='mpp-attached-media-item' data-mpp-activity-id="<?php echo $activity_id;?>" title="<?php echo esc_attr( mpp_get_media_title() );?>" /></a>

				<?php if ( $looper == $count ) :?>
					</div>
				<?php endif;?>	

			<?php endif;?>

		<?php endwhile; ?>
	</div>
<?php endif; ?>


<?php mpp_reset_media_data();?>