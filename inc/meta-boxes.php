<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Register Shortcode meta box.
 */
function asrgm_cmb() {
    add_meta_box( 'gmap-shortcode-box', __( 'Shortcode', 'asr_td' ), 'asrgm_shortcode_display_callback', 'gmap-pro','side','high' );
}
add_action( 'add_meta_boxes', 'asrgm_cmb' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function asrgm_shortcode_display_callback( $post ) {
	echo '<strong>Use this shortcode for display the map anywhere</strong><br /><br /><center>[gmp id='.get_the_ID().']</center><br />';
}

/**
 * Register meta box(es).
 */
function asrgm_register_meta_boxes() {
    add_meta_box( 'gmap-meta-box', __( 'Map Settings', 'asr_td' ), 'asrgm_my_display_callback', 'gmap-pro','normal','core' );
}
add_action( 'add_meta_boxes', 'asrgm_register_meta_boxes' );

 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function asrgm_my_display_callback( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'asr_jobs_nonce' );
	$asr_stored_meta = get_post_meta( $post->ID ); ?>

	<div class="map-setting">
		<div class="col-sm-6">
			<div class="meta-row row">
				<div class="latitude meta-th">
					<label for="latitude-listed" class="asr-row-title"><?php _e( 'Latitude', 'asr_td' ); ?></label>
				</div>
				<div class="latitude meta-td">
					<input type="text" class="asr-row-content latitude-input" name="latitude" id="date-listed" value="<?php if ( ! empty ( $asr_stored_meta['latitude'] ) ) echo esc_attr( $asr_stored_meta['latitude'][0] ); ?>"/>
				</div>
			</div>
			<div class="meta-row row">
				<div class="longitude meta-th">
					<label for="longitude-listed" class="asr-row-title"><?php _e( 'Longitude', 'asr_td' ); ?></label>
				</div>
				<div class="longitude meta-td">
					<input type="text" class="asr-row-content longitude-input" name="longitude" id="date-listed" value="<?php if ( ! empty ( $asr_stored_meta['longitude'] ) ) echo esc_attr( $asr_stored_meta['longitude'][0] ); ?>"/>
				</div>
			</div>
		</div>
		<div class="col-sm-6 last">
			<div class="meta-row row">
				<div class="zoom meta-th">
					<label for="zoom-listed" class="asr-row-title"><?php _e( 'Zoom', 'asr_td' ); ?></label>
				</div>
				<div class="zoom meta-td">
					<div class="zoom-div meta-td">
						<div class="quantity">
							<input type="number" class="asr-row-content zoom-input" min="1" name="zoom" id="date-listed" value="<?php if ( ! empty ( $asr_stored_meta['zoom'] ) ){echo esc_attr( $asr_stored_meta['zoom'][0] );} else echo '10'; ?>"/>					
						</div>
					</div>
				</div>
			</div>
		</div>


	
	</div>	
	<?php
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box( $post_id ) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'asr_jobs_nonce' ] ) && wp_verify_nonce( $_POST[ 'asr_jobs_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
   //data passing to database
    if ( isset( $_POST[ 'latitude' ] ) ) {
    	update_post_meta( $post_id, 'latitude', sanitize_text_field( $_POST[ 'latitude' ] ) );
    }
    if ( isset( $_POST[ 'longitude' ] ) ) {
    	update_post_meta( $post_id, 'longitude', sanitize_text_field( $_POST[ 'longitude' ] ) );
    }
    if ( isset( $_POST[ 'zoom' ] ) ) {
    	update_post_meta( $post_id, 'zoom', sanitize_text_field( $_POST[ 'zoom' ] ) );
    }
	
}
add_action( 'save_post', 'wpdocs_save_meta_box' );