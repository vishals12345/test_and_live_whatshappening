<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template Name: City_page
 * Template Post Type: page
 * The template for displaying pages
 *
 * Template to show single page or any post type
 */

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

	/*
	echo do_shortcode('[vc_row height="auto"]'.'[vc_column]'.'[vc_row_inner]'.'[vc_column_inner width="1/1"]'.'[us_image image="9144" size="full" align="center" has_ratio="1" ratio="custom" ratio_width="20" ratio_height="6"]'.'[/vc_column_inner]'.'[/vc_row_inner]'.'[/vc_column]'.'[/vc_row]'.'[vc_row height="small" columns="4-1"]'.'[vc_column width="4/5"]'.'[vc_row_inner css="%7B%22default%22%3A%7B%22margin-top%22%3A%22-20px%22%7D%7D"]'.'[vc_column_inner width="1/1"]'.'[vc_column_text css="%7B%22default%22%3A%7B%22text-align%22%3A%22left%22%2C%22font-size%22%3A%2213px%22%7D%7D"]<a href="'.get_site_url().'">Home</a> > '.ucfirst(get_query_var( 'eventcity' )).'[/vc_column_text]'.'[/vc_column_inner]'.'[/vc_row_inner]'.'[us_separator size="small"]'.'[us_additional_menu source="menu_middle" layout="hor" css="%7B%22default%22%3A%7B%22font-size%22%3A%2214px%22%2C%22border-style%22%3A%22solid%22%2C%22border-top-width%22%3A%221px%22%2C%22border-bottom-width%22%3A%221px%22%2C%22border-color%22%3A%22%23ff1c42%22%7D%7D"]'.'[us_separator size="small"]'.'[us_text text="Last added" tag="h2" css="%7B%22default%22%3A%7B%22color%22%3A%22_header_middle_bg%22%2C%22background-color%22%3A%22_alt_content_bg%22%2C%22margin-top%22%3A%2210px%22%2C%22padding-left%22%3A%2215px%22%2C%22padding-top%22%3A%2212px%22%2C%22padding-bottom%22%3A%2210px%22%7D%7D"]'.'[us_separator size="small"]'.'[us_grid taxonomy_post_tag="'.get_query_var( 'eventcity' ).'" items_quantity="12" pagination="ajax" items_layout="9990" columns="4"]'.'[/vc_column]'.'[vc_column sticky="1" css="%7B%22default%22%3A%7B%22margin-top%22%3A%2250px%22%7D%7D" width="1/5"]'.'[vc_row_inner css="%7B%22default%22%3A%7B%22margin-top%22%3A%22-20px%22%7D%7D"]'.'[vc_column_inner width="1/1"]'.'[us_html]JTVCYWRzZW5zZV92ZXJ0aWNhbF9hZCU1RA==[/us_html]'.'[/vc_column_inner]'.'[/vc_row_inner]'.'[/vc_column]'.'[/vc_row]');
	*/

	echo do_shortcode('[vc_row height="auto"]'.'[vc_column]'.'[vc_row_inner]'.'[vc_column_inner width="1/1"]'.'[us_image image="9144" size="full" align="center" has_ratio="1" ratio="custom" ratio_width="20" ratio_height="6"]'.'[/vc_column_inner]'.'[/vc_row_inner]'.'[/vc_column]'.'[/vc_row]'.'[vc_row height="small" columns="4-1"]'.'[vc_column width="4/5"]'.'[vc_row_inner css="%7B%22default%22%3A%7B%22margin-top%22%3A%22-20px%22%7D%7D"]'.'[vc_column_inner width="1/1"]'.'[vc_column_text css="%7B%22default%22%3A%7B%22text-align%22%3A%22left%22%2C%22font-size%22%3A%2213px%22%7D%7D"]<a href="'.get_site_url().'">Home</a> > '.ucfirst(get_query_var( 'eventcity' )).'[/vc_column_text]'.'[/vc_column_inner]'.'[/vc_row_inner]'.'[us_separator size="small"]'.'[us_additional_menu source="menu_middle" layout="hor" css="%7B%22default%22%3A%7B%22font-size%22%3A%2214px%22%2C%22border-style%22%3A%22solid%22%2C%22border-top-width%22%3A%221px%22%2C%22border-bottom-width%22%3A%221px%22%2C%22border-color%22%3A%22%23ff1c42%22%7D%7D"]'.'[us_separator size="small"]'.'[us_text text="What\'s happening in '.ucfirst(get_query_var( 'eventcity' )).'" tag="h1" css="%7B%22default%22%3A%7B%22font-size%22%3A%2220px%22%7D%7D"]'.'[us_text text="Last added" tag="h2" css="%7B%22default%22%3A%7B%22color%22%3A%22_header_middle_bg%22%2C%22background-color%22%3A%22_alt_content_bg%22%2C%22margin-top%22%3A%2210px%22%2C%22padding-left%22%3A%2215px%22%2C%22padding-top%22%3A%2212px%22%2C%22padding-bottom%22%3A%2210px%22%7D%7D"]'.'[us_separator size="small"]'.'[us_grid taxonomy_post_tag="'.get_query_var( 'eventcity' ).'" items_quantity="12" pagination="ajax" items_layout="9990" columns="4"]'.'[/vc_column]'.'[vc_column sticky="1" css="%7B%22default%22%3A%7B%22margin-top%22%3A%2250px%22%7D%7D" width="1/5"]'.'[vc_row_inner css="%7B%22default%22%3A%7B%22margin-top%22%3A%22-20px%22%7D%7D"]'.'[vc_column_inner width="1/1"]'.'[us_html]JTVCYWRzZW5zZV92ZXJ0aWNhbF9hZCU1RA==[/us_html]'.'[/vc_column_inner]'.'[/vc_row_inner]'.'[/vc_column]'.'[/vc_row]');

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
