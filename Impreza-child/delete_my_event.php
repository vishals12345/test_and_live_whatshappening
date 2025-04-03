<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template Name: Delete_My_Event
 * Template Post Type: page
 * The template for displaying pages
 *
 * Template to show single page or any post type
 */

include_once('includes/root_html_sections.php');
acf_form_head();


$us_layout = US_Layout::instance();

//us_register_context_layout( 'header' );
get_header();

//us_register_context_layout( 'main' );

// Check if the Content template is applied to this page
if ( $content_area_id = us_get_page_area_id( 'content' ) AND get_post_status( $content_area_id ) != FALSE ) {
	$has_content_template = TRUE;
	$usbid_container_attribute = '';
} else {
	$has_content_template = FALSE;

	// If no Content template, add the specific attribute to enable correct editing in USBuilder
	$usbid_container_attribute = apply_filters( 'usb_get_usbid_container', NULL );
}

get_header();

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


  global $current_user;
  wp_get_current_user();
  $authorID = $current_user->ID;
  $args = array(
          'post_type'       => 'post',
          'posts_per_page'  => -1,
          'author'          => $authorID,
          'p'               => get_query_var( 'evid' )
          );

  // query
  $the_query = new WP_Query( $args );

  if( $the_query->have_posts() ):

      while( $the_query->have_posts() ) : $the_query->the_post();

        $attachments = get_attached_media( '', get_the_ID() );

        foreach ($attachments as $attachment) {
          wp_delete_attachment( $attachment->ID );
        }

        wp_delete_post( get_the_ID() );

      endwhile;

  endif;

  echo '
  <section class="l-section wpb_row height_medium"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><h2 class="w-text us_custom_4edec70e has_text_color"><span class="w-text-h"><span class="w-text-value">Event deleted!</span></span></h2><div class="w-separator size_small"></div><div class="w-btn-wrapper align_center"><a class="w-btn us-btn-style_1" title="My Events" href="/my-events/"><span class="w-btn-label">Back</span></a></div></div></div></div></div></section>';


	if ( us_get_option( 'enable_sidebar_titlebar', 0 ) ) {
		// AFTER wrapper for Sidebar
		us_load_template( 'templates/sidebar', array( 'place' => 'after' ) );
	}

	do_action( 'us_after_page' );
	?>
</main>

<?php
//us_register_context_layout( 'footer' );
get_footer()
?>
