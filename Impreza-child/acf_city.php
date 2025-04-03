<?php
function get_acf_city( $atts ) {

  $city = get_post_meta( get_the_ID(), 'city', true );
  $terms = get_the_terms( get_the_ID(), 'location_tag' );

  if ($terms) {
    foreach($terms as $tag) {
      $slug = $tag->slug;
    }
  }

  $field = '<a href="/'.$slug.'">'.$city.'</a>';

  return $field;

}
