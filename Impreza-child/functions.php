<?php
/* Custom functions code goes here. */

/**
 * 
 * Register files to include
 *
 */
include_once('grid_now_and_next.php');
include_once('acf_location.php');
include_once('acf_get_begin_end_date.php');
include_once('acf_city.php');
include_once('breadcrumbs.php');
include_once('create_menu_url.php');
include_once('includes/fix_counts.php');
include_once('my-acf-extension.php');
include_once('google_adsense_index_page.php');
include_once('create_category_list_for_post_site.php');
include_once('create_tag_for_grid.php');
include_once('custom_events_list_filter.php');
include_once('custom_locations_list_filter.php');
include_once('dynamic_search.php');
include_once('dynamic_breadcrumbs.php');
include_once('dynamic_search.php');

/**
 * Block wp-admin access for non-admins
 */

function block_wp_admin_access_callback() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_safe_redirect( home_url().'/my-account/' );
		exit;
	}
}
add_action( 'admin_init', 'block_wp_admin_access_callback' );


// Function to change email address
function wpb_sender_email( $original_email_address ) {
    return 'info@whatshappening.co.uk';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'info@whatshappening.co.uk';
}

// Hooking up our functions to WordPress filters
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );


/*
* Shortcodes
*/
function shortcodes_init(){
  // Grid
  add_shortcode('grid_now_and_next', 'grid_now_and_next_f');
  // Breadcrumbs
  add_shortcode('breadcrumbs', 'navxt_breadcrumbs');
  // Custom Menu URL
  add_shortcode('custom_url', 'custom_menu_url');
  // ACF field location name
  add_shortcode('get_acf_location', 'get_acf_location_content');
  // ACF field begin_date/end_date
  add_shortcode('get_acf_begindate_enddate', 'get_acf_begin_end_date');
  // ACF field city name
  add_shortcode('get_acf_city', 'get_acf_city');
  // Google Adsense index page 120x600
  add_shortcode('adsense_vertical_ad', 'google_adsense_vertical_ad');
  // get_category_list_for_post_site
  add_shortcode('get_category_list_for_post', 'get_category_list_for_post_site');
  // create_tag_for_grid
  add_shortcode('create_tag_for_grid', 'create_tag_for_grid');
  // Dynamic breadcrumbs
  add_shortcode('dynamic_breadcrumbs', 'generate_breadcrumbs');
  // Dynamic search
  add_shortcode('my_search', 'my_search_shortcode');
}
add_action('init', 'shortcodes_init');

/**
  * Connect a second database
  *
  */
function connect_another_db() {
    global $seconddb;
    $seconddb = new wpdb('', '', 'web119_db6','s193.goserver.host');
}
add_action('init', 'connect_another_db');

/*
* Disable admin bar for non Admins
*/
function wps_disable_admin_bar( $content ) {
    return ( current_user_can( 'administrator' ) ) ? $content : false;
}
add_filter('show_admin_bar','wps_disable_admin_bar');

function custom_disable_widget_shortcode_mce() {
	if ( class_exists( 'Widget_Shortcode_TinyMCE' ) ) {
		remove_filter( 'mce_buttons', array( Widget_Shortcode_TinyMCE::get_instance(), 'mce_buttons' ) );
	}
}
add_action( 'init', 'custom_disable_widget_shortcode_mce' );


// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


/**
 * Register custom query vars
 *
 * @param array $vars The array of available query variables
 */

function myplugin_register_query_vars( $vars ) {

 $vars[] = 'eventcity';
 $vars[] = 'evid';
 $vars[] = 'category';
 return $vars;

}
add_filter( 'query_vars', 'myplugin_register_query_vars' );


/**
 * Add rewrite tags and rules
 *
 * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_tag
 * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_rule
 */
/**
 * Add rewrite tags and rules
 */
function myplugin_rewrite_tag_rule() {
  
  // rewrite tag for event city page
  add_rewrite_tag('%eventcity%', '([^&]+)', 'eventcity=');

  // rewrite tag for category page
  add_rewrite_tag('%category%', '([^&]+)', 'category=');
  
  // location tag for location page
  add_rewrite_tag('%location%', '([^&]+)', 'location='); 

  // Bestehende Regeln
  add_rewrite_rule('^about-us/?$', 'index.php?pagename=about-us', 'top');
  add_rewrite_rule('^events/?$', 'index.php?pagename=all_events', 'top');
  add_rewrite_rule('^locations/?$', 'index.php?pagename=locations', 'top');
  add_rewrite_rule('^listing/?$', 'index.php?pagename=listing', 'top');
  add_rewrite_rule('^my-account/?$', 'index.php?pagename=my-account', 'top');
  add_rewrite_rule('^my-events/?$', 'index.php?pagename=my-events', 'top');
  add_rewrite_rule('^new-event-added/?$', 'index.php?pagename=new-event-added', 'top');
  add_rewrite_rule('^new-location-added/?$', 'index.php?pagename=new-location-added', 'top');
  add_rewrite_rule('^delete-event/([^/]*)?$', 'index.php?pagename=delete-event&evid=$matches[1]', 'top');
  add_rewrite_rule('^add-new-event/?$', 'index.php?pagename=add-new-event', 'top');
  add_rewrite_rule('^add-new-location/?$', 'index.php?pagename=add-new-location', 'top');
  add_rewrite_rule('^edit-event/([^/]*)?$', 'index.php?pagename=edit-event&evid=$matches[1]', 'top');
  add_rewrite_rule('^all-events/?$', 'index.php?pagename=events-now-and-next', 'top');
  add_rewrite_rule('^today/?$', 'index.php?pagename=today', 'top');
  add_rewrite_rule('^this-month/?$', 'index.php?pagename=this-month', 'top');
  add_rewrite_rule('^([^/]*)/all-events/?$', 'index.php?pagename=now-and-next-city&eventcity=$matches[1]', 'top');
  add_rewrite_rule('^([^/]*)/today/?$', 'index.php?pagename=events-city-today&eventcity=$matches[1]', 'top');
  add_rewrite_rule('^([^/]*)/this-month/?$', 'index.php?pagename=events-this-month-city&eventcity=$matches[1]', 'top');
  add_rewrite_rule('^([^/]*)/events/?$', 'index.php?pagename=events_by_city&eventcity=$matches[1]', 'top');
  add_rewrite_rule('^cities/?$', 'index.php?pagename=cities', 'top');
  add_rewrite_rule('^([^/]*)/?$', 'index.php?pagename=city&eventcity=$matches[1]', 'top');
  
  // rewrite for custom post type category page
  add_rewrite_rule('^([^/]*)/([^/]*)/?$', 'index.php?pagename=events-by-city-and-category&eventcity=$matches[1]&category=$matches[2]', 'top');
  
  // rewrite for custom post type single page (event)
  add_rewrite_rule('^([^/]*)/events/([^/]*)/?$', 'index.php?eventcity=$matches[1]&name=$matches[2]', 'top');
  
  // rewrite rule for location page
  add_rewrite_rule('^([^/]*)/(restaurant|bar|pub|spot|cafe|club|theatre)/([^/]*)/?$', 'index.php?eventcity=$matches[1]&location=$matches[3]', 'top');

  // redirect non-location pages to 404
  add_rewrite_rule('^([^/]*)/(?!restaurant|bar|pub|spot|cafe|club|theatre)([^/]*)/?$', 'index.php?error=404', 'top');
}
add_action('init', 'myplugin_rewrite_tag_rule');

// Weiterleitungsfunktion hinzufügen
function redirect_old_location_url() {
  if (preg_match('/^\/location\/([^\/]+)\/?$/', $_SERVER['REQUEST_URI'], $matches)) {
      $eventcity = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : 'default-city';
      $new_url = home_url('/' . $eventcity . '/location/' . $matches[1] . '/');
      wp_redirect($new_url, 301);
      exit;
  }
}

// Entfernen der Kategorie-Basis
function remove_category_base() {
  global $wp_rewrite;
  $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
}
add_action('init', 'remove_category_base');

// Kategorie-Links anpassen
function custom_category_link($termlink, $term, $taxonomy) {
  if ($taxonomy == 'category') {
      $termlink = str_replace('/category/', '/', $termlink);
  }
  return $termlink;
}
add_filter('term_link', 'custom_category_link', 10, 3);

// Kategorie-Basis aus den URLs entfernen
function fix_category_pagination($redirect_url, $requested_url) {
  if (strpos($redirect_url, '/category/') !== false) {
      $redirect_url = str_replace('/category/', '/', $redirect_url);
  }
  return $redirect_url;
}
add_filter('redirect_canonical', 'fix_category_pagination', 10, 2);

// Kategorie-Basis aus den Breadcrumbs entfernen (falls Impreza Breadcrumbs verwendet)
function fix_breadcrumbs_category_base($link, $term) {
  if ($term->taxonomy == 'category') {
      $link = str_replace('/category/', '/', $link);
  }
  return $link;
}
add_filter('wpseo_breadcrumb_single_link', 'fix_breadcrumbs_category_base', 10, 2);


function wp_tuts_filter_post_link( $permalink, $post ) {

    // Check if the %eventcity% tag is present in the url:
    if ( false === strpos( $permalink, '%eventcity%' ) )
        return $permalink;

    // Get the event city stored in post meta
    $eventcity = get_post_meta($post->ID, 'event_city', true);

    // Unfortunately, if no date is found, we need to provide a 'default value'.
    $eventcity = ( ! empty($eventcity) ? $eventcity : 'other' );

    $eventcity =urlencode(strtolower($eventcity));

    // Replace '%eventcity%'
    $permalink = str_replace( '%eventcity%', $eventcity , $permalink );

    return $permalink;
}
add_filter( 'post_link', 'wp_tuts_filter_post_link' , 10, 2 );


//flush_rewrite_rules();


/*
* Load event city data into acf field
*/
/*
function acf_load_cities_field_choices( $field ) {
	global $seconddb;
	$seconddb = new wpdb('web119_6', '%NpMM64yH!J#', 'web119_db6','s193.goserver.host');

	$cities = $seconddb->get_results( "SELECT id,city FROM cities ORDER BY city ASC" );
	$field['choices'] = array();
    if($cities){
        foreach( $cities as $value ) {
            $field['choices'][ urlencode(strtolower($value->city)) ] = $value->city;
        }
    }
    return $field;
}
add_filter('acf/load_field/name=event_city', 'acf_load_cities_field_choices');
*/

/*
* Load location data into acf field
*/

function acf_load_locations_field_choices( $field ) {

  if (is_page( array( 'edit-event', 'Edit event','add-new-event', 'Add new event')) || is_admin() ) { 
  
    // Retrieve location data from location post list
    $locations = get_posts( array(
      'post_type' => 'location',
      'post_status' => 'publish',
      'numberposts' => -1
    ) );

    if ( $locations ) {

        $field['choices'] = array();

        foreach ( $locations as $location ) {
          $field['choices'][$location->ID] = $location->post_title.', '.get_field( "field_62b31ca001c5f", $location->ID).', '.get_field( "field_62b31cad01c60", $location->ID).', '.get_field( "field_62b31cb801c61", $location->ID  );
        }

        wp_reset_postdata();
        return $field;
    }
  }
  else {
    return;
  }

  /* Old version
  /*

  global $seconddb;
	$seconddb = new wpdb('web119_6', '%NpMM64yH!J#', 'web119_db6','s193.goserver.host');

	$locations = $seconddb->get_results( "SELECT id,name,city,street FROM locations ORDER BY city,name ASC" );
	$field['choices'] = array();
    if($locations){
        foreach( $locations as $value ) {
            $field['choices'][$value->id] = $value->name.', '.$value->street;
        }
    }
    return $field;
    */
}
//add_filter('acf/load_field/name=location', 'acf_load_locations_field_choices');


/*
* Change Meta Title
*/
function change_title($title)
{
    if (basename(get_permalink())=="city") {
        $title = ucfirst(get_query_var( 'eventcity' )).' - What\'s happening';
    }
    elseif (basename(get_permalink())=="now-and-next-city")
    {
        $title = "All events in ".ucfirst(get_query_var( 'eventcity' )).' - What\'s happening';
    }
    elseif (basename(get_permalink())=="events-city-today")
    {
        $title = "Events in ".ucfirst(get_query_var( 'eventcity' )).' today - What\'s happening';
    }
    elseif (basename(get_permalink())=="events-this-month-city")
    {
        $title = "Events in ".ucfirst(get_query_var( 'eventcity' )).' this month - What\'s happening';
    }
    else {};
    return $title;
}
add_filter('pre_get_document_title', 'change_title');


/*
* Add Keywords
*/
function add_meta_tags()
{
  global $post;

  if ( is_page() ) {

    // City page
    if ( is_page('City') ) {

      echo "<meta name='keywords' content='".ucfirst(get_query_var( 'eventcity' )).", events, what\'s happening, whats on, guide' />";
      //echo "<meta name='description' content='What is happening in ".ucfirst(get_query_var( 'eventcity' )).". Find all sorts of events.' />";
    }
  }

  if (basename(get_permalink())=="now-and-next")
  {
      echo "<meta name='keywords' content='all events, events, what\'s happening, whats on, UK' />";
  }
  elseif (basename(get_permalink())=="today")
  {
      echo "<meta name='keywords' content='all events, today, events, what\'s happening, whats on, UK' />";
  }
  elseif (basename(get_permalink())=="now-and-next-city")
  {
      echo "<meta name='keywords' content='".ucfirst(get_query_var( 'eventcity' )).", all events, events, what\'s happening' />";
  }
  elseif (basename(get_permalink())=="events-city-today")
  {
      echo "<meta name='keywords' content='".ucfirst(get_query_var( 'eventcity' )).", Events today, events, what\'s happening' />";
  }
  elseif (basename(get_permalink())=="events-this-month-city")
  {
      echo "<meta name='keywords' content='".ucfirst(get_query_var( 'eventcity' )).", Events this month, events, what\'s happening' />";
  }
  else {

    if ( is_single() ) {
      $meta = strip_tags( $post->post_content );
      $meta = strip_shortcodes( $post->post_content );
      $meta = str_replace( array("\n", "\r", "\t"), ' ', $meta );
      $meta = substr( $meta, 0, 125 );
      $keywords = get_the_category( $post->ID );
      $metakeywords = get_the_title($post->ID);
      $metakeywords .= ", ".ucfirst(get_query_var( 'eventcity' )). ", ";
      foreach ( $keywords as $keyword ) {
          $metakeywords .= $keyword->cat_name . ", ";
      }
      $metakeywords .= "What's happening";
      echo '<meta name="keywords" content="' . $metakeywords . '" />' . "\n";
  }

  };
}
add_action( 'wp_head', 'add_meta_tags' ,2);

/**
 * Allow changing of the canonical URL.
 *
 * @param string $canonical The canonical URL.
 */
add_filter( 'rank_math/frontend/canonical', function( $canonical ) {
  global $post;

  if ( is_page('City') ) {
    $canonical = home_url().'/'.get_query_var( 'eventcity' ).'/';
  }

  if ( is_page('now-and-next') ) {
    $canonical = home_url().'/all-events/';
  }

  if ( is_page('today') ) {
    $canonical = home_url().'/today/';
  }

  if ( is_page('this-month') ) {
    $canonical = home_url().'/this-month/';
  }

  if ( is_page('now-and-next-city') ) {
    $canonical = home_url().'/'.get_query_var( 'eventcity' ).'/all-events/';
  }

  if ( is_page('events-city-today') ) {
    $canonical = home_url().'/'.get_query_var( 'eventcity' ).'/today/';
  }

  if ( is_page('events-this-month-city') ) {
    $canonical = home_url().'/'.get_query_var( 'eventcity' ).'/this-month/';
  }

	return $canonical;
});

/**
 * Function to automatically update the focus keyword with the post title
 */

function update_focus_keywords()
{
    $posts = get_posts(array(
        'posts_per_page'    => 1,
        'post_type'        => 'post' //replace post with the name of your post type
    ));
    foreach ($posts as $p) {
        update_post_meta($p->ID, 'rank_math_focus_keyword', strtolower(get_the_title($p->ID)));
    }
}
add_action('init', 'update_focus_keywords');

/**
 * Allow changing the meta description sentence from within the theme.
 *
 * @param string $description The description sentence.
 */
add_filter( 'rank_math/frontend/description', function( $description ) {

  if ( is_page('City') ) {
    $description = "What\'s happening in ".ucfirst(get_query_var( 'eventcity' )).". A comprehensive guide on what is going on in ".ucfirst(get_query_var( 'eventcity' )). ". Event guide and listings from users.";
  }

  if (basename(get_permalink())=="today")
  {
      $description = "What\'s happening today. A comprehensive guide on what is going on today. Events listed by users.";
  }
  elseif (basename(get_permalink())=="now-and-next-city")
  {
      $description = "All events happening in ".ucfirst(get_query_var( 'eventcity' )).". A comprehensive guide on what is going on today. Events listed by users.";
  }
  elseif (basename(get_permalink())=="events-city-today")
  {
      $description = "What\'s happening in ".ucfirst(get_query_var( 'eventcity' ))." today. A comprehensive guide on what is going on today. Events listed by users.";
  }
  elseif (basename(get_permalink())=="this-month")
  {
      $description = "What\'s happening this month. A comprehensive guide on what is going on this month. Events listed by users.";
  }
  elseif (basename(get_permalink())=="events-this-month-city")
  {
      $description = "What\'s happening in ".ucfirst(get_query_var( 'eventcity' ))." this month. A comprehensive guide on what is going on this month. Events listed by users.";
  }
  else {
  }


  return $description;
});

/*
* Enqueue Scripts
*/
/*
function enqueue_scripts() {

  if ( !is_page('my-account') ||
       !is_page('my-events') ||
       !is_page('new-event-added') ||
       !is_page('new-location-added') ||
       !is_page('delete-event') ||
       !is_page('add-new-event') ||
       !is_page('add-new-location') ||
       !is_page('edit-event')
     ) {

    wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDyDclcWu-Wa2zzo6O0TZaBBlR35Nzoz_k', array(''), '', true);
    wp_enqueue_script('googlemaps');

  }
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');
*/

/*
function wpb_hook_javascript() {
  if (is_single ()) {
    global $post;
    ?>
    <script type="text/javascript" >
      jQuery(document).on("usGmapLoaded", function(){
        let geocoder;
        let map;

        function initMap() {
          //console.log('--- Google Maps API version: ' + google.maps.version);
          console.log('--- Google Maps API version: ' + google.maps.version);
          geocoder = new google.maps.Geocoder();
          let latlng = new google.maps.LatLng(51.50515478301073, -0.11196170097650275);
          let mapOptions = {
            zoom: 2,
            center: latlng
          }
          map = new google.maps.Map(document.getElementById('map'), mapOptions);
        }

        initMap();

        function codeAddress(address_data) {
          let address = address_data; 
          //console.log(address_data);
          console.log(address_data);
          geocoder.geocode( { 'address': address}, function(results, status) {
            
            if (status == 'OK') {
              //console.log('--- Status: ' + status);
              console.log('--- Status: ' + status);
              console.log(results[0].geometry.location);
              let latLng = results[0].geometry.location;
              map.setCenter(latLng);
              map.setZoom(15); // Stellen Sie den Zoom-Level ein, der Ihren Bedürfnissen entspricht
              let marker = new google.maps.Marker({
                  map: map,
                  position: latLng
              });
              //console.log('--- Marker: ' + marker);
              console.log('--- Marker: ' + marker);
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
          });
        }

      <?php

      $post_type = get_post_type( get_the_ID() );

      if( $post_type == "post" ) {
          $city = get_field( "event_city", $post->ID );
          $address = get_field( "address", $post->ID );
          $address_data = $address.",".$city;
      }

      if ( $post_type == "location" ) {
        $city = get_field( "city", $post->ID );
        $street = get_field( "street", $post->ID );
        $postcode = get_field( "postcode", $post->ID );
        $address_data = addslashes($street).",".$postcode.",".$city;
      }
      ?>
      codeAddress('<?php echo $address_data ?>');
    });
    </script>
    <?php

  }
}
add_action('wp_footer', 'wpb_hook_javascript');
*/


/*
* Update tag for events in editing mode
*/
function my_acf_save_post( $post_id ) {

    // Get previous values.
    //$prev_values = get_fields( $post_id );

    // Get submitted values.
    $values = $_POST['acf'];

    // Get current page name
    $slug = get_post_field('post_name', get_post() ) ;

    // Check if a specific value was updated.
    if( isset($_POST['acf']['field_61604c0abe153']) && ( $slug=="edit-event" || $slug=="add-new-event" )) {
        wp_set_post_tags($post_id, $_POST['acf']['field_61604c0abe153']);
    }

    if( isset($_POST['acf']['field_62b31cb801c61']) && ( $slug=="add-new-location" )) {
        wp_set_object_terms($post_id, $_POST['acf']['field_62b31cb801c61'], 'location_tag');
    }

}
add_action('acf/save_post', 'my_acf_save_post', 5);

/*
* Login redirect
*/
function my_login_redirect( $redirect_to, $request, $user ) {
    $redirect_to =  home_url();

    return $redirect_to;
}
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : get_site_url();
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}



// Register Custom Post Type Location
function create_location_cpt() {

	$labels = array(
		'name' => _x( 'Locations', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'Location', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => _x( 'Locations', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar' => _x( 'Location', 'Add New on Toolbar', 'textdomain' ),
		'archives' => __( 'Location Archives', 'textdomain' ),
		'attributes' => __( 'Location Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Location:', 'textdomain' ),
		'all_items' => __( 'All Locations', 'textdomain' ),
		'add_new_item' => __( 'Add New Location', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New Location', 'textdomain' ),
		'edit_item' => __( 'Edit Location', 'textdomain' ),
		'update_item' => __( 'Update Location', 'textdomain' ),
		'view_item' => __( 'View Location', 'textdomain' ),
		'view_items' => __( 'View Locations', 'textdomain' ),
		'search_items' => __( 'Search Location', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into Location', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Location', 'textdomain' ),
		'items_list' => __( 'Locations list', 'textdomain' ),
		'items_list_navigation' => __( 'Locations list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter Locations list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'Location', 'textdomain' ),
		'description' => __( 'List of all locations', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-location-alt',
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments', 'custom-fields'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'page',
	);
	register_post_type( 'location', $args );

  register_taxonomy('location_cat','location',array(
        'label'        => 'Loc_Categories',
        'query_var'    => true,
        'rewrite'      => true,
        'hierarchical' => true
  ));
  register_taxonomy('location_tag','location',array(
        'label'        => 'City',
        'query_var'    => true,
        'rewrite'      => true,
        'hierarchical' => true
    ));

}
add_action( 'init', 'create_location_cpt', 0 );

function rename_post_type() {
    global $wp_post_types;
    // Get the post object
    $post_type = 'post';
    if (isset($wp_post_types[$post_type])) {
        $labels = &$wp_post_types[$post_type]->labels;
        $labels->name = 'Events';
        $labels->singular_name = 'Event';
        $labels->add_new = 'Add Event';
        $labels->add_new_item = 'Add New Event';
        $labels->edit_item = 'Edit Event';
        $labels->new_item = 'New Event';
        $labels->view_item = 'View Event';
        $labels->search_items = 'Search Events';
        $labels->not_found = 'No Events found';
        $labels->not_found_in_trash = 'No Events found in Trash';
        $labels->all_items = 'All Events';
        $labels->menu_name = 'Events';
        $labels->name_admin_bar = 'Event';
    }
}
add_action('init', 'rename_post_type');

function rename_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Events';
    $submenu['edit.php'][5][0] = 'Events';
    $submenu['edit.php'][10][0] = 'Add Event';
    $submenu['edit.php'][16][0] = 'Event Tags';
    echo '';
}
add_action('admin_menu', 'rename_post_menu_label');

function rename_post_object_label() {
    global $wp_post_types;
    $wp_post_types['post']->labels->name = 'Events';
    $wp_post_types['post']->labels->singular_name = 'Event';
    $wp_post_types['post']->labels->add_new = 'Add Event';
    $wp_post_types['post']->labels->add_new_item = 'Add Event';
    $wp_post_types['post']->labels->edit_item = 'Edit Event';
    $wp_post_types['post']->labels->new_item = 'Event';
    $wp_post_types['post']->labels->view_item = 'View Event';
    $wp_post_types['post']->labels->search_items = 'Search Events';
    $wp_post_types['post']->labels->not_found = 'No Events found';
    $wp_post_types['post']->labels->not_found_in_trash = 'No Events found in Trash';
    $wp_post_types['post']->labels->all_items = 'All Events';
    $wp_post_types['post']->labels->menu_name = 'Events';
    $wp_post_types['post']->labels->name_admin_bar = 'Events';
}
add_action('init', 'rename_post_object_label');

function rename_post_tag_labels() {
    global $wp_taxonomies;
    // Get the post_tag object
    $taxonomy = 'post_tag';
    if (isset($wp_taxonomies[$taxonomy])) {
        $labels = &$wp_taxonomies[$taxonomy]->labels;
        $labels->name = 'Cities';
        $labels->singular_name = 'City';
        $labels->search_items = 'Search Cities';
        $labels->popular_items = 'Popular Cities';
        $labels->all_items = 'All Cities';
        $labels->parent_item = null; // Post tags don't have parents
        $labels->parent_item_colon = null;
        $labels->edit_item = 'Edit City';
        $labels->view_item = 'View City';
        $labels->update_item = 'Update City';
        $labels->add_new_item = 'Add New City';
        $labels->new_item_name = 'New City Name';
        $labels->separate_items_with_commas = 'Separate cities with commas';
        $labels->add_or_remove_items = 'Add or remove cities';
        $labels->choose_from_most_used = 'Choose from the most used cities';
        $labels->not_found = 'No cities found.';
        $labels->menu_name = 'Cities';
    }
}
add_action('init', 'rename_post_tag_labels');

function rename_tag_menu_label() {
    global $submenu;
    $submenu['edit.php'][16][0] = 'Cities';
}
add_action('admin_menu', 'rename_tag_menu_label');


// Hook to the 'admin_menu' action
add_action('admin_menu', 'link_existing_tags_page_menu');

// Function to add the menu item
function link_existing_tags_page_menu() {
    add_menu_page(
        'Cities',           // Page title
        'Cities',                      // Menu title
        'manage_options',            // Capability required
        'edit-tags.php?taxonomy=post_tag', // Menu slug (existing page URL with parameters)
        '',                          // Function to display content (not needed)
        'dashicons-tag',             // Icon URL or dashicon class
        6                            // Position in the menu
    );
}

