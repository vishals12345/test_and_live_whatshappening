<?php

function html_section($posts, $parameter, $term_name) {

  $html = '
  <section class="l-section wpb_row height_auto"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="g-cols wpb_row via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="w-image has_ratio align_center"><div class="w-image-h"><div style="padding-bottom:30%"></div><img src="'.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser.jpg" class="attachment-full size-full" alt="whatshappening.co.uk" loading="lazy" srcset="'.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser.jpg 1920w, '.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser-300x169.jpg 300w, '.get_site_url().'/wp-content/uploads/2021/12/whatshappening_teaser-1024x576.jpg 1024w" sizes="(max-width: 1920px) 100vw, 1920px" width="1920" height="1080"></div></div></div></div></div></div></div></div></div>
  </section>

  <section class="l-section wpb_row height_small"><div class="l-section-h i-cf"><div class="g-cols via_grid cols_4-1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="g-cols wpb_row us_custom_6217dcc9 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="wpb_text_column us_custom_a757445a"><div class="wpb_wrapper"><p><a href="'.get_site_url().'">Home</a> &gt; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'">'.ucfirst(get_query_var( 'eventcity' )).'</a> &gt; '.$term_name.'</p>
  </div></div></div></div></div><div class="w-separator size_small"></div><div class="w-menu us_custom_0bd8daf1 layout_hor style_links us_menu_1" style="--main-gap:1.5rem;--main-ver-indent:0.8em;--main-hor-indent:0.8em;"><ul id="menu-menu_middle" class="menu"><li id="menu-item-10258" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10258"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/all-events">All Events</a></li><li id="menu-item-10257" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10257"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/today">Today</a></li><li id="menu-item-10259" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10259"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/this-month">This Month</a></li><li id="menu-item-10276" class="menu-item menu-item-type-gs_sim menu-item-object-gs_sim menu-item-10276"><i style="color: #ff1c42;" class="fas fa-square-full"></i>&nbsp; <a href="/cities">Cities</a></li></ul><style>.us_menu_1 .menu>li>a{color:inherit}@media ( max-width:600px ){.us_menu_1 .menu{display:block!important}.us_menu_1 .menu>li{margin:0 0 var(--main-gap,1.5rem)!important}}</style></div><div class="w-separator size_small"></div><h2 class="w-text us_custom_bcff52ef has_text_color"><span class="w-text-h"><span class="w-text-value">'.$term_name.'</span></span></h2><div class="w-separator size_small"></div><div class="w-grid type_grid layout_9990 cols_4 overflow_hidden" id="us_grid_1" data-filterable="true"><style>#us_grid_1 .w-grid-item{padding:1.5rem}#us_grid_1 .w-grid-list{margin:-1.5rem -1.5rem 1.5rem}.w-grid + #us_grid_1 .w-grid-list,.w-grid-none + #us_grid_1 .w-grid-list{margin-top:1.5rem}@media (max-width:1199px){#us_grid_1 .w-grid-item{width:33.3333%}}@media (max-width:899px){#us_grid_1 .w-grid-item{width:50%}}@media (max-width:599px){#us_grid_1 .w-grid-list{margin:0}#us_grid_1 .w-grid-item{width:100%;padding:0;margin-bottom:1.5rem}}.layout_9990 .w-grid-item-h{background:var(--color-header-middle-bg);color:var(--color-content-heading);box-shadow:0 0.03rem 0.06rem rgba(0,0,0,0.1),0 0.1rem 0.3rem rgba(0,0,0,0.1);transition-duration:0.3s}.no-touch .layout_9990 .w-grid-item-h:hover{box-shadow:0 0.12rem 0.24rem rgba(0,0,0,0.1),0 0.4rem 1.2rem rgba(0,0,0,0.15);z-index:4}.layout_9990 .usg_vwrapper_1{padding:0.8rem 1.5rem 1.5rem 1.5rem!important}.layout_9990 .usg_hwrapper_1{margin-bottom:0.3rem!important}.layout_9990 .usg_post_taxonomy_1{font-weight:700!important;text-transform:uppercase!important;font-size:14px!important;margin-right:0.6rem!important}.layout_9990 .usg_post_title_1{color:inherit!important;font-weight:700!important;font-size:16px!important}.layout_9990 .usg_html_1{font-size:14px!important}.layout_9990 .usg_hwrapper_4{margin-top:10px!important}.layout_9990 .usg_html_2{color:var(--color-content-faded)!important;font-size:12px!important}@media (max-width:600px){.layout_9990 .usg_post_title_1{font-size:1.2rem!important}}</style><div class="w-grid-list">';

  if( $posts ) {
  		foreach( $posts as $post ) {

      $locaton = do_shortcode( '[get_acf_location postID="'.$post->ID.'"] ');
      $slugs = wp_get_post_terms($post->ID,'category',['fields'=>'all']);

      $html .= '
      <article class="w-grid-item post-'.$post->ID.' post type-post status-publish format-standard has-post-thumbnail hentry category-events tag-'.get_field( "event_city", $post->ID ).'" data-id="'.$post->ID.'">
      		<div class="w-grid-item-h">
      						<div class="w-post-elm post_image usg_post_image_1 stretched">
                    <a href="'.get_permalink( $post->ID ).'" aria-label="'.$post->post_title.'"><img src="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ).'" class="attachment-us_600_600_crop size-us_600_600_crop wp-post-image" alt="" loading="lazy"></a>
                  </div>
                  <div class="w-vwrapper usg_vwrapper_1 align_none valign_top">
                    <div class="w-hwrapper usg_hwrapper_4 align_none valign_top" style="--hwrapper-gap:1.20rem">
                      <h2 class="w-post-elm post_title usg_post_title_1 entry-title color_link_inherit">
                        <a href="'.get_permalink( $post->ID ).'">'.$post->post_title.'</a>
                      </h2>
                    </div>
                    <div class="w-hwrapper usg_hwrapper_1 align_none valign_top">
                    <div class="w-post-elm post_taxonomy usg_post_taxonomy_1 style_simple">
                      <a href="'.get_site_url().'/'.get_field( "event_city", $post->ID ).'/" rel="tag">'.get_field( "event_city", $post->ID ).'</a>
                    </div>
                  </div>
                  <div class="w-hwrapper usg_hwrapper_3 align_none valign_top">
                    <div class="w-vwrapper usg_vwrapper_2 align_none valign_top">
                      <div class="w-html usg_html_1">'.$locaton.'</div>
                    </div>
                  </div>
                  <div class="w-hwrapper usg_hwrapper_2 align_none valign_top">
                    <div class="w-html usg_html_2">'.get_field( "begin_date", $post->ID ).' - '.get_field( "end_date", $post->ID ).'</div>
                  </div>
                  <div class="w-hwrapper usg_hwrapper_1 align_none valign_top">
                      <div class="w-post-elm-list">';

                      foreach ($slugs as $slug ) {
                        $html .= ' <a class="w-btn us-btn-style_3" href="'.get_site_url().'/'.get_query_var( 'eventcity' ).'/category/'.$slug->slug.'"><span class="w-btn-label">'.$slug->name.'</span></a>';
                      }

                      $html .= '
                    </div>
                  </div>
              </div>
          </div>
      </article>';

      }
 }

 $html .= '
  </div>
  <div class="w-grid-preloader"><div class="g-preloader type_1">
  	<div></div>
  </div>
  </div>
  </div></div></div><div class="wpb_column vc_column_container us_custom_72fc42ef type_sticky"><div class="vc_column-inner" style="top:"><div class="g-cols wpb_row us_custom_6217dcc9 via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default"><div class="wpb_column vc_column_container"><div class="vc_column-inner"><div class="w-image align_none"><div class="w-image-h">'.do_shortcode('[adsense_vertical_ad]').'</div></div></div></div></div></div></div></div></div>
  </section>';

  return $html;
}
?>
