<?php

function custom_menu_url($atts) {
  global $wp;

  extract(shortcode_atts(array(
  'site'=> array()
      ), $atts));

  if (get_site_url()!='' && get_query_var('eventcity')=='') {
      $url = '<i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.strtolower(str_replace(" ","-",$atts['site'])).'">'.ucfirst($atts['site']).'</a>';
  } else {
      $url = '<i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/'.strtolower(str_replace(" ","-",$atts['site'])).'">'.ucfirst($atts['site']).'</a>';
  }

  return $url;
}
