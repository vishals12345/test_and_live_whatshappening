<?php
function get_acf_location_content( $atts ) {

  // Get the current post ID
  $post_id = get_the_ID();

  // Get the location and city from post meta
  $city = get_field('event_city', $post_id);
  $location = get_post_meta($post_id, 'location', true);

  // Überprüfen, ob die Felder abgerufen wurden
  if (empty($location)) {
    return 'Location data is missing.';
  }

  if (empty($city)) {
    return 'City data is missing.';
  }

  // Get name and slug from $location
  $location_name = get_the_title($location);
  // Get meta value from $city 

  // Get the location slug from $location
  $location_slug = get_post_field('post_name', $location);

  // Get the location category slug from $location
  $location_category = get_the_terms($location, 'location_cat');
  $location_category_slug = $location_category[0]->slug;

  // Get base url
  $base_url = get_site_url();

  // Generate the URL
  $location_url = $base_url . '/' . $city . '/'.$location_category_slug.'/' . $location_slug . '/';

  // Create the HTML link
  $link = '<a href="' . esc_url( $location_url ) . '">' . esc_html( $location_name ) . '</a>';

  return $link;
}