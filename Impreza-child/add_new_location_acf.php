<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template Name: Add_New_Location
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

	echo '

	<section class="l-section wpb_row height_small"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="g-cols wpb_row us_custom_595d2d28 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><h2 class="w-text us_custom_8b3d6790 has_text_color"><span class="w-text-h"><i class="fas fa-user"></i><span class="w-text-value">My Account</span></span></h2><div class="w-separator us_custom_bf81054c size_small with_line width_default thick_1 style_solid color_border align_center"><div class="w-separator-h"></div></div><div class="w-menu layout_hor style_links us_menu_1" style="--main-gap:1.5rem;--main-ver-indent:0.8em;--main-hor-indent:0.8em;"><ul id="menu-my-account" class="menu"><li id="menu-item-10383" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-10359 current_page_item menu-item-10383"><a href="/my-events/" aria-current="page">My Events</a></li><li id="menu-item-10388" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10388"><a href="/add-new-event/">Add New Event</a></li></ul><style>.us_menu_1 .menu>li>a{color:var(--color-header-middle-bg)}.us_menu_1 .menu>.menu-item:not(.current-menu-item)>a:hover{color:#bdc0ff}.us_menu_1 .menu>.current-menu-item>a{color:#bdc0ff}@media ( max-width:600px ){.us_menu_1 .menu{display:block!important}.us_menu_1 .menu>li{margin:0 0 var(--main-gap,1.5rem)!important}}</style></div></div></div></div></div></div></div></div>
	</section>

  <section class="l-section wpb_row us_custom_c4cf0450 height_auto">
    <div class="l-section-h i-cf"><div class="g-cols vc_row via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default">
      <div class="wpb_column vc_column_container">
        <div class="vc_column-inner">
          <div class="g-cols wpb_row us_custom_3ebe9510 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default">
            <div class="wpb_column vc_column_container">
              <div class="vc_column-inner">
                <h2 class="w-text">
                <span class="w-text-h">
                  <span class="w-text-value">New Location</span>
                </span></h2><div class="w-html">
                  <p></p>
                </div>
                <div class="wpb_text_column">
                  <div class="wpb_wrapper">
                  <p>
	';

  acf_form(array(
    'id'           => 'new-location',
    'post_id'		   => 'new_post',
    'post_title'	 => true,
    'post_content' => true,
    'new_post'		 => array(
      'post_type'		=> 'location',
      'post_status'	=> 'publish',
      'post_author' => $authorID
    ),
    'return'		    => home_url('new-location-added'),
    'submit_value'	=> 'Send'
  ));

	echo '
  </p>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
</section>';


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
