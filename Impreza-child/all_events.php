<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template Name: all_events
 * Template Post Type: page
 * The template for displaying pages
 *
 * Template to show single page or any post type
 */

$us_layout = US_Layout::instance();

us_register_context_layout( 'header' );
get_header();

us_register_context_layout( 'main' );

// Check if the Content template is applied to this page
if ( $content_area_id = us_get_page_area_id( 'content' ) AND get_post_status( $content_area_id ) != FALSE ) {
	$has_content_template = TRUE;
	$usbid_container_attribute = '';
} else {
	$has_content_template = FALSE;

	// If no Content template, add the specific attribute to enable correct editing in USBuilder
	$usbid_container_attribute = apply_filters( 'usb_get_usbid_container', NULL );
}

?>
<main id="page-content" class="l-main"<?php echo $usbid_container_attribute . ( ( us_get_option( 'schema_markup' ) ) ? ' itemprop="mainContentOfPage"' : ''); ?>>
	<?php
	do_action( 'us_before_page' );

	if ( us_get_option( 'enable_sidebar_titlebar', 0 ) ) {

		// Titlebar, if it is enabled in Theme Options
		us_load_template( 'templates/titlebar' );

		// START wrapper for Sidebar
		us_load_template( 'templates/sidebar', array( 'place' => 'before' ) );
	}

  // Display grid
	//echo "<p>";
	echo do_shortcode('[vc_row]'.'[vc_column]'.'[us_text text="All events in UK" tag="h2" css="%7B%22default%22%3A%7B%22color%22%3A%22%23ffffff%22%2C%22background-color%22%3A%22%23ff1c42%22%2C%22height%22%3A%2250px%22%2C%22padding-left%22%3A%2210px%22%2C%22padding-top%22%3A%2210px%22%2C%22padding-bottom%22%3A%2210px%22%2C%22box-shadow-v-offset%22%3A%223px%22%2C%22box-shadow-blur%22%3A%223px%22%2C%22box-shadow-color%22%3A%22%23bababa%22%7D%7D"]'.'[us_grid items_quantity="20" pagination="ajax" items_layout="10024" columns="4"]'.'[/vc_column]'.'[/vc_row]');
	//echo "</p>";

	if ( us_get_option( 'enable_sidebar_titlebar', 0 ) ) {
		// AFTER wrapper for Sidebar
		us_load_template( 'templates/sidebar', array( 'place' => 'after' ) );
	}

	do_action( 'us_after_page' );
	?>
</main>

<?php
us_register_context_layout( 'footer' );
get_footer()
?>
