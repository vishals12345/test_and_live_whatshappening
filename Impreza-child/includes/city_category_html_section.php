<?php

function html_section($posts, $parameter, $term_name) {

  $html = '
  <section class="l-section wpb_row height_auto"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="g-cols wpb_row via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="w-image has_ratio align_center"><div class="w-image-h"><div style="padding-bottom:30%"></div><img src="'.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser.jpg" class="attachment-full size-full" alt="whatshappening.co.uk" loading="lazy" srcset="'.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser.jpg 1920w, '.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser-300x169.jpg 300w, '.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser-1024x576.jpg 1024w" sizes="(max-width: 1920px) 100vw, 1920px" width="1920" height="1080"></div></div></div></div></div></div></div></div></div>
  </section>

  <section class="l-section wpb_row height_small"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_4-1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="g-cols wpb_row us_custom_6217dcc9 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="wpb_text_column us_custom_a757445a"><div class="wpb_wrapper"><p><a href="'.get_site_url().'">Home</a> &gt; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'">'.ucfirst(get_query_var( 'eventcity' )).'</a> &gt; '.$term_name.'</p>
  </div></div></div></div></div><div class="w-separator size_small"></div><div class="w-menu us_custom_0bd8daf1 layout_hor style_links us_menu_1" style="--main-gap:1.5rem;--main-ver-indent:0.8em;--main-hor-indent:0.8em;"><ul id="menu-menu_middle" class="menu"><li id="menu-item-10258" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10258"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/all-events">All Events</a></li><li id="menu-item-10257" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10257"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/today">Today</a></li><li id="menu-item-10259" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10259"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/this-month">This Month</a></li><li id="menu-item-10276" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10276"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="/cities">Cities</a></li></ul><style>.us_menu_1 .menu>li>a{color:inherit}@media ( max-width:600px ){.us_menu_1 .menu{display:block!important}.us_menu_1 .menu>li{margin:0 0 var(--main-gap,1.5rem)!important}}</style></div><div class="w-separator size_small"></div><h2 class="w-text us_custom_bcff52ef has_text_color"><span class="w-text-h"><span class="w-text-value">'.$term_name.'</span></span></h2><div class="w-separator size_small"></div> ';

  $city = get_query_var( 'eventcity' );
	$term = get_query_var( 'category' );
    $html .=  do_shortcode('[apf_display_posts city="'.$city.'" category="'.$term.'"]');

 $html .= '
 
  </div></div></div><div class="wpb_column vc_column_container us_custom_72fc42ef type_sticky"><div class="vc_column-inner" style="top:"><div class="g-cols wpb_row us_custom_6217dcc9 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="w-image align_none"><div class="w-image-h">'.do_shortcode('[adsense_vertical_ad]').'</div></div></div></div></div></div></div></div></div>
  </section>';

  return $html;
}
?>
