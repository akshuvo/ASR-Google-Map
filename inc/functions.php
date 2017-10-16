<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
* Add Custom post Type
*/
if(!function_exists('asrgm_cpt')){	
	function asrgm_cpt(){
		register_post_type('gmap-pro',[
			'labels'      => [
                'name'          => __('Google Maps'),
                'singular_name' => __('Google Map'),
				'add_new' => __('Add New Map'),
				'all_items' => __('All Maps'),
				'edit_item' => __('Edit Map'),
			],
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'exclude_from_search' => true,
			'show_in_menu ' => true,
			'has_archive' => false,
			'rewrite' => false,
			'menu_position' => 100,
			'menu_icon' => 'dashicons-sticky',
			'supports' => ('title'),
		]);
	}
	add_action('init', 'asrgm_cpt');
}

/*
* Overriding preview Options
*/

function agm_settings($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Map Title'),        
        'lat' => __('Latitude'),        
        'long' => __('Longitude'),        
        'scode' => __('Shortcode'),        
    );
}

function agm_address_custom_columns($column){
 global $post;
 $lat = get_post_meta( get_the_ID(), 'latitude', true );
 $long = get_post_meta( get_the_ID(), 'longitude', true );
 
 switch ($column) {
    case "scode":
        echo '<code>[gmp id='.get_the_ID().']</code>';
        break;
    case "lat":
        echo $lat;
        break;
    case "long":
        echo $long;
        break;

    }
}

add_action("manage_gmap-pro_posts_custom_column",  "agm_address_custom_columns");
add_filter('manage_gmap-pro_posts_columns' , 'agm_settings');

/**
* Add Setting Page
*/
function agm_add_submenu_page() {
	add_submenu_page( 
		'edit.php?post_type=gmap-pro', 
		'Map Setting', 
		'Map Setting', 
		'manage_options', 
		'setting', 
		'asrgm_settings_callback' 
	);
}
add_action( 'admin_menu', 'agm_add_submenu_page' );

function asrgm_settings_callback(){ ?>
<div class="wrap">
<h1>Google Map Pro by ASRCODER™</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'asr-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'asr-plugin-settings-group' ); ?>
    <table class="form-table"> 
        <tr valign="top">
        <th scope="row">Google API key</th>
        <td>
			<input style="width:350px" type="text" name="asr_gmap_api" value="<?php echo esc_attr( get_option('asr_gmap_api') ); ?>" />
			<p>Obtain an API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank" rel="nofollow">Here</a></p>
		</td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>

<?php }


function register_asrgm_plugin_settings() {
	//register our settings
	register_setting( 'asr-plugin-settings-group', 'asr_gmap_api' );
}
add_action( 'admin_init', 'register_asrgm_plugin_settings' );