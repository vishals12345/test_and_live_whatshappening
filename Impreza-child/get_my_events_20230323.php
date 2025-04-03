<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template Name: Get_My_Events
 * Template Post Type: page
 * The template for displaying pages
 *
 * Template to show single page or any post type
 */

acf_form_head();


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
          );

  // query
  $the_query = new WP_Query( $args );

  echo '

	<section class="l-section wpb_row height_small"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="g-cols wpb_row us_custom_595d2d28 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><h2 class="w-text us_custom_8b3d6790 has_text_color"><span class="w-text-h"><i class="fas fa-user"></i><span class="w-text-value">My Account</span></span></h2><div class="w-separator us_custom_bf81054c size_small with_line width_default thick_1 style_solid color_border align_center"><div class="w-separator-h"></div></div><div class="w-menu layout_hor style_links us_menu_1" style="--main-gap:1.5rem;--main-ver-indent:0.8em;--main-hor-indent:0.8em;"><ul id="menu-my-account" class="menu"><li id="menu-item-10383" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-10359 current_page_item menu-item-10383"><a href="/my-events/" aria-current="page">My Events</a></li><li id="menu-item-10388" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10388"><a href="/add-new-event/">Add New Event</a></li></ul><style>.us_menu_1 .menu>li>a{color:var(--color-header-middle-bg)}.us_menu_1 .menu>.menu-item:not(.current-menu-item)>a:hover{color:#bdc0ff}.us_menu_1 .menu>.current-menu-item>a{color:#bdc0ff}@media ( max-width:600px ){.us_menu_1 .menu{display:block!important}.us_menu_1 .menu>li{margin:0 0 var(--main-gap,1.5rem)!important}}</style></div></div></div></div></div></div></div></div>
	</section>

	<section class="l-section wpb_row us_custom_c4cf0450 height_auto"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="g-cols wpb_row us_custom_3ebe9510 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="w-grid type_grid layout_10364" id="us_grid_1" data-filterable="true"><style>#us_grid_1 .w-grid-item:not(:last-child){margin-bottom:1.5rem}#us_grid_1 .g-loadmore{margin-top:1.5rem}.layout_10364 .w-grid-item-h{}.layout_10364 .usg_vwrapper_1{width:87%!important}.layout_10364 .usg_vwrapper_3{width:5%!important}.layout_10364 .usg_vwrapper_4{width:5%!important}.layout_10364 .usg_vwrapper_2{width:3%!important}</style>
	<div class="w-grid-list">
	';

  if( $the_query->have_posts() ):

      while( $the_query->have_posts() ) : $the_query->the_post();

      echo '

			<article class="w-grid-item post-'.get_the_ID().' post type-post status-publish format-standard has-post-thumbnail hentry category-events tag-london" data-id="'.get_the_ID().'">
				<div class="w-grid-item-h">
								<div class="w-hwrapper usg_hwrapper_1 align_left valign_middle" style="--hwrapper-gap:1.20rem"><div class="w-vwrapper usg_vwrapper_1 align_left valign_top"><div class="w-post-elm post_title usg_post_title_1 align_left entry-title color_link_inherit">'.get_the_title().'</div></div><div class="w-vwrapper usg_vwrapper_3 align_center valign_middle"><a class="w-btn us-btn-style_1 usg_btn_1 icon_atright text_none" aria-label="Button" href="/edit-event/'.get_the_ID().'"><i class="fas fa-edit"></i></a></div><div class="w-vwrapper usg_vwrapper_2 align_none valign_top"></div><div class="w-vwrapper usg_vwrapper_4 align_center valign_middle"><a class="w-btn us-btn-style_1 usg_btn_2 icon_atleft text_none" aria-label="Button" href="/delete-event/'.get_the_ID().'"><i class="fas fa-trash-alt"></i></a></div></div>		</div>
			</article>';

    endwhile;
  endif;

  echo'
	</div><div class="w-grid-preloader"><div class="g-preloader type_1">
		<div></div>
	</div>
	</div>
		</div></div></div></div></div></div></div></div></section>';


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
