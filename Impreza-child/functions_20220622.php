<?php
/* Custom functions code goes here. */

/**
 * Register files to include
 *
 */
include_once('grid_now_and_next.php');
include_once('acf_location.php');
include_once('breadcrumbs.php');
include_once('create_menu_url.php');
include_once('includes/fix_counts.php');
include_once('my-acf-extension.php');
include_once('google_adsense_index_page.php');


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
  // Google Adsense index page 120x600
  add_shortcode('adsense_vertical_ad', 'google_adsense_vertical_ad');
}
add_action('init', 'shortcodes_init');

/**
  * Connect a second database (former Laravel DB)
  *
  */
function connect_another_db() {
    global $seconddb;
    $seconddb = new wpdb('web119_6', '%NpMM64yH!J#', 'web119_db6','s193.goserver.host');
}
add_action('init', 'connect_another_db');

/*
* Disable admin bar for non Admins
*/
function wps_disable_admin_bar( $content ) {
    return ( current_user_can( 'administrator' ) ) ? $content : false;
}

add_filter(
    'show_admin_bar',
    'wps_disable_admin_bar'
);

function custom_disable_widget_shortcode_mce() {
	if ( class_exists( 'Widget_Shortcode_TinyMCE' ) ) {
		remove_filter( 'mce_buttons', array( Widget_Shortcode_TinyMCE::get_instance(), 'mce_buttons' ) );
	}
}
add_action( 'init', 'custom_disable_widget_shortcode_mce' );

/**
 * Register custom query vars
 *
 * @param array $vars The array of available query variables
 */

function myplugin_register_query_vars( $vars ) {

 $vars[] = 'eventcity';
 $vars[] = 'evid';
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
	add_rewrite_tag( '%eventcity%', '([^&]+)', 'eventcity=');
  add_rewrite_rule( '^london/?$', 'index.php?pagename=london','top' );
  add_rewrite_rule( '^birmingham/?$', 'index.php?pagename=birmingham','top' );
  add_rewrite_rule( '^manchester/?$', 'index.php?pagename=manchester','top' );
  add_rewrite_rule( '^about-us/?$', 'index.php?pagename=about-us','top' );
  add_rewrite_rule( '^events/?$', 'index.php?pagename=all_events','top' );
  add_rewrite_rule( '^my-account/?$', 'index.php?pagename=my-account','top' );
  add_rewrite_rule( '^my-events/?$', 'index.php?pagename=my-events','top' );
  add_rewrite_rule( '^new-event-added/?$', 'index.php?pagename=new-event-added','top' );
  add_rewrite_rule( '^delete-event/([^/]*)?$', 'index.php?pagename=delete-event&evid=$matches[1]','top' );
  add_rewrite_rule( '^add-new-event/?$', 'index.php?pagename=add-new-event','top' );
  add_rewrite_rule( '^edit-event/([^/]*)?$', 'index.php?pagename=edit-event&evid=$matches[1]','top' );
  add_rewrite_rule( '^all-events/?$', 'index.php?pagename=now-and-next','top' );
  add_rewrite_rule( '^today/?$', 'index.php?pagename=today','top' );
  add_rewrite_rule( '^this-month/?$', 'index.php?pagename=this-month','top' );
  add_rewrite_rule( '^([^/]*)/all-events/?$', 'index.php?pagename=now-and-next-city&eventcity=$matches[1]','top' );
  add_rewrite_rule( '^([^/]*)/today/?$', 'index.php?pagename=events-city-today&eventcity=$matches[1]','top' );
  add_rewrite_rule( '^([^/]*)/this-month/?$', 'index.php?pagename=events-this-month-city&eventcity=$matches[1]','top' );
	add_rewrite_rule( '^([^/]*)/events/?$', 'index.php?pagename=events_by_city&eventcity=$matches[1]','top' );
  add_rewrite_rule( '^cities/?$', 'index.php?pagename=cities','top' );
  add_rewrite_rule( '^([^/]*)/?$', 'index.php?pagename=city&eventcity=$matches[1]','top' );
}
add_action('init', 'myplugin_rewrite_tag_rule');


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
}
add_filter('acf/load_field/name=location', 'acf_load_locations_field_choices');


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
        'posts_per_page'    => -1,
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
function enqueue_scripts() {
  wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDyDclcWu-Wa2zzo6O0TZaBBlR35Nzoz_k', array(''), '', true);
  wp_enqueue_script('googlemaps');
  //wp_register_script('googlegeoencoder', 'https://www.whatshappening.co.uk/wp-content/themes/Impreza-child/js/google_geocoder.js', array('googlemaps'), '', true);
  //wp_enqueue_script('googlegeoencoder');
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');



function wpb_hook_javascript() {
  if (is_single ()) {
    global $post;
    ?>

    <script type="text/javascript">
      var geocoder;
      var map;

      function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
          zoom: 13,
          center: latlng
        }
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
      }
      initialize();

      function codeAddress(address_data) {
        var address = address_data;//document.getElementById('address').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

    <?php

    //if( $posts ) {
    //		foreach( $posts as $post ) {
          $city = get_field( "event_city", $post->ID );
          $address = get_field( "address", $post->ID );
    //    }
        $address_data = $address.",".$city;
    //}
    ?>

    codeAddress('<?php echo $address_data ?>');
    </script>
    <?php

  }
}
add_action('wp_footer', 'wpb_hook_javascript',100);


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

?>
