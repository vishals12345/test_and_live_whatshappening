<?php
function get_acf_location_content( $atts ) {

  if (isset($atts["postID"])) {
    $id = get_field("location", $atts["postID"]);
  }
  else {
    $id = get_field("location");
  }

  global $wpdb;

  $location = get_post_meta( get_the_ID(), 'location', false );

  /*
  $posts = get_posts( array(
      'post_type' 			=> 'post',
      'posts_per_page'	=> 1,
      'meta_key' 				=> 'location',
    )
  );
  */

  foreach( $location as $loc ) {

      $field = '<a href="'.get_permalink($loc).'">'.get_the_title($loc).'</a>';
      //$field = '<a href="'.get_permalink($post->location).'">'.get_the_title($post->location).'</a>';
  }
  //echo "--".$id."--".$atts["postID"].".";

  //print_r($id);
  /*
  global $seconddb;

  $location = $seconddb->get_results( "SELECT name FROM locations WHERE id='".$id."'" );

  $field = "";

  foreach( $location as $value ) {
    $field = $value->name;
  }
  */
  return $field;

}
