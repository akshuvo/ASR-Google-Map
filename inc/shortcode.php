<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
* Add Shortcode 
*/
function gmap_shortcode( $atts ){	
	$atts= shortcode_atts( array(
			'id' => '',	
			'width' => '100%',	
			'height' => '450px',	
		), $atts );	
		
	ob_start();?>
	<?php		
		$args = array(
		  'p'         => $atts['id'], // ID of a page, post, or custom type
		  'post_type' => 'gmap-pro'
		);		
		$loop = new WP_Query( $args );
		
		$lat = get_post_meta( $atts['id'], 'latitude', true );
		$long = get_post_meta( $atts['id'], 'longitude', true );
		$zoom = get_post_meta( $atts['id'], 'zoom', true );
		
		while ( $loop->have_posts() ) : $loop->the_post();
	?>	
    <div id="map_<?php echo $atts['id']; ?>" style="width:<?php echo $atts['width']; ?>;height:<?php echo $atts['height']; ?>"></div>
    <script>
      function initMap() {
        var uluru = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>};
        var map = new google.maps.Map(document.getElementById('map_<?php echo $atts['id']; ?>'), {
          zoom: <?php echo $zoom; ?>,
          center: uluru,
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
	<?php endwhile; ?>
	<?php wp_reset_query(); ?>	
	<?php return ob_get_clean();
}

add_shortcode('gmp', 'gmap_shortcode');