<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template Name: Posts_This_Month
 * Template Post Type: page
 * The template for displaying pages
 *
 * Template to show single page or any post type
 */

include_once('includes/root_html_sections.php');

$us_layout = US_Layout::instance();

// us_register_context_layout( 'header' );
get_header();

// us_register_context_layout( 'main' );

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

  // Find todays date in Ymd format.
  //$date_now = date('Ym');
	$start_date = date( 'ym01' );
	$end_date = date( 'ymt' );
	//$date_now = current_time('Ymd');
  // Query posts using a meta_query to compare two custom fields; start_date and end_date.
  $posts = get_posts( array(
      'post_type' 			=> 'post',
      'posts_per_page'	=> -1,
			'meta_query' => array(
			    'relation' => 'AND',
			    array(
			        'key'     => 'begin_date',
			        'value'   => array( $start_date, $end_date ),
			        'compare' => 'BETWEEN',
			        'type'    => 'DATE'
			    )
					,
          array(
			        'key'     => 'end_date',
			        'value'   => array( $start_date, $end_date ) ,
			        'compare' => 'BETWEEN',
			        'type'    => 'DATE'
			    )
			),
      'orderby' 				=> 'meta_value',
      'order' 					=> 'ASC'
		)
	);

	echo html_section($posts, "This Month");

	if ( us_get_option( 'enable_sidebar_titlebar', 0 ) ) {
		// AFTER wrapper for Sidebar
		us_load_template( 'templates/sidebar', array( 'place' => 'after' ) );
	}

	do_action( 'us_after_page' );
	?>
</main>

<?php
// us_register_context_layout( 'footer' );
get_footer()
?>
