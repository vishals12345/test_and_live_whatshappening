<?php
function get_category_list_for_post_site() {

  $post_categories = wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) );;
  //$cats = array();

  $terms = get_the_terms( get_the_ID(), 'post_tag' );
if ( !empty( $terms ) ){
    // get the first term
    $term = array_shift( $terms );
    $slug = $term->slug;
}

  $div = '
  <div class="w-post-elm post_taxonomy style_badge color_link_inherit">
  <div class="w-post-elm-list">';

  if( $post_categories ){
    foreach($post_categories as $c){
        $div .= '<a class="w-btn us-btn-style_2" href="/'.$slug.'/category/'.$c->slug.'"><span class="w-btn-label">'.$c->name.'</span></a>';
    }
  }

  $div .= '
  </div>
  </div>';

  return $div;

}
