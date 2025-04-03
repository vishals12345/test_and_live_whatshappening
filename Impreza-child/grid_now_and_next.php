<?php
function grid_now_and_next_f( $atts ) {

  //$grid = $atts['posts'];

  extract(shortcode_atts(array(
                'post_content'=> array()
                    ), $atts));

  print_r($atts[post_content]);

  $grid = '
  <section class="l-section wpb_row height_medium">
	<div class="l-section-h i-cf">
	<div class="g-cols via_grid cols_1 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default">
	<div class="wpb_column vc_column_container">
	<div class="vc_column-inner">
	<div class="w-grid type_grid layout_9990 cols_4 overflow_hidden" id="us_grid_1" data-filterable="true">
  <style>#us_grid_1 .w-grid-item{padding:1.5rem}#us_grid_1 .w-grid-list{margin:-1.5rem}.w-grid + #us_grid_1 .w-grid-list,.w-grid-none + #us_grid_1 .w-grid-list{margin-top:1.5rem}@media (max-width:1199px){#us_grid_1 .w-grid-item{width:33.3333%}}@media (max-width:899px){#us_grid_1 .w-grid-item{width:50%}}@media (max-width:599px){#us_grid_1 .w-grid-list{margin:0}#us_grid_1 .w-grid-item{width:100%;padding:0;margin-bottom:1.5rem}}.layout_9990 .w-grid-item-h{background:var(--color-header-middle-bg);color:var(--color-content-heading);border-radius:0.3rem;box-shadow:0 0.03rem 0.06rem rgba(0,0,0,0.1),0 0.1rem 0.3rem rgba(0,0,0,0.1);transition-duration:0.3s}.no-touch .layout_9990 .w-grid-item-h:hover{box-shadow:0 0.12rem 0.24rem rgba(0,0,0,0.1),0 0.4rem 1.2rem rgba(0,0,0,0.15);z-index:4}.layout_9990 .usg_vwrapper_1{padding:0.8rem 1.5rem 1.5rem 1.5rem!important}.layout_9990 .usg_hwrapper_1{margin-bottom:0.3rem!important}.layout_9990 .usg_post_taxonomy_1{font-weight:700!important;text-transform:uppercase!important;font-size:14px!important;margin-right:0.6rem!important}.layout_9990 .usg_post_date_1{color:var(--color-content-faded)!important;font-size:14px!important;margin-bottom:0.3rem!important}.layout_9990 .usg_post_title_1{color:inherit!important;font-weight:700!important;font-size:1.4rem!important}@media (max-width:600px){.layout_9990 .usg_post_title_1{font-size:1.2rem!important}}</style>
    <div class="w-grid-list">'.$atts[post_content];
    echo '
    </div>
    <div class="w-grid-preloader">
      <div class="g-preloader type_1"><div>
    </div>
  </div>
	</div>
	</div>
	</div>
	</div>
	</section>
  ';

  return $grid;

}
