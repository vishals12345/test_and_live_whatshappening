<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


function apf_display_locations_shortcode($a) {
	  $atts = shortcode_atts(
        array(
            'city' => '', 
            'category' => ''
        ),
        $a,
        'apf_posts'
    );
    ob_start();
	
	//print_r('<pre>'); print_r($a); print_r('</pre>');
    ?> <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<div class="g-cols vc_row via_grid cols_3 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default stacking_default" bis_skin_checked="1"><div class="wpb_column vc_column_container" bis_skin_checked="1"><div class="vc_column-inner" bis_skin_checked="1"></div></div><div class="wpb_column vc_column_container" bis_skin_checked="1"><div class="vc_column-inner" bis_skin_checked="1"></div></div><div class="wpb_column vc_column_container" bis_skin_checked="1"><div class="vc_column-inner" bis_skin_checked="1"></div></div></div>
    <div id="apf-post-filter">
        <div class="w-filter-list">
      <?php if (isset($a['categoryfilter']) && isset($a['cityfilter']) ) { 
		  echo '<div class="g-cols vc_row via_grid cols_4 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default stacking_default">
			 <div class="w-filter-item type_dropdown wpb_column vc_column_container" >
			 
			 </div>';} else{?>
	  
       <div class="w-filter-list-title">Filters</div>
            <button class="w-filter-list-closer" title="Close" aria-label="Close"></button>
            <div class="g-cols vc_row via_grid cols_4 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default stacking_default">
			 <div class="w-filter-item type_dropdown wpb_column vc_column_container" style="display:none;">
			 <h4><!-- Filter: --></h4>
			 </div>
	  <?php } ?>
            <div class="w-filter-item type_dropdown wpb_column vc_column_container" <?php if (isset($a['categoryfilter'])) { echo 'style="display:none;"'; } ?>>
                <button class="w-filter-item-title" style="display:none;">Category<span></span></button>
                <a class="w-filter-item-reset" href="#" title="Reset"><span>Reset</span></a>
                <div class="w-filter-item-values" data-maxheight="40vh" style="max-height:40vh">
                    <select class="w-filter-item-value-select" name="filter_category" id="apf-categoryL">
                        <option value="">All Locations</option>
                       <?php 
                        $cities = get_terms( array('taxonomy' => 'location_cat', 'hide_empty' => false) );
						
						  
						if(get_query_var( 'eventcity' ) )  { 
			$term = get_term_by('slug', get_query_var( 'eventcity' ), 'post_tag');
			if ($term) {
			 echo 	$cityid = $term->term_id;
				// Now you can use $term_id as needed
			}
   }

                        foreach ( $cities as $city ) {
						if($cityid == $city->term_id ) $s = 'selected'; 
						elseif(esc_attr($atts['city']) &&  esc_attr($atts['city']) == $city->slug) $s = 'selected'; 
						else $s = '';

                            echo '<option value="' . $city->term_id . '" '. $s .'>' . $city->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="w-filter-item type_dropdown wpb_column vc_column_container" <?php if (isset($a['cityfilter'])) { echo 'style="display:none;"'; } ?> >
                <button class="w-filter-item-title" style="display:none;">City <?php echo $slug; ?><span></span></button>
                <a class="w-filter-item-reset" href="#" title="Reset"><span>Reset</span></a>
                <div class="w-filter-item-values" data-maxheight="40vh" style="max-height:40vh">
                    <select class="w-filter-item-value-select" name="filter_city" id="apf-cityL">
                        <option value="">All Cities</option>
                        <?php 
						if($atts['city'] == '') $atts['city'] = $slug;
                        $cities = get_terms( array('taxonomy' => 'location_tag', 'hide_empty' => false) );
						
						                       
						if(get_query_var( 'eventcity' ) )  { 
								$term = get_term_by('slug', get_query_var( 'eventcity' ), 'location_tag');
								//print_r('<pre>'); print_r($term); print_r('</pre>'); die();
								 
								if ($term) {
									$cityid = $term->term_id;
									// Now you can use $term_id as needed
								}
					   }
			

                        foreach ( $cities as $city ) {
						if($cityid == $city->term_id ) $s = 'selected'; 
						elseif(esc_attr($atts['city']) &&  esc_attr($atts['city']) == $city->term_id) $s = 'selected'; 
						else $s = '';

                            echo '<option value="' . $city->term_id . '" '. $s .'>' . $city->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
		</div>
        <div class="w-grid type_grid layout_9990 cols_4 pagination_ajax overflow_hidden">
			<div id="apf-posts-containerL" class="w-grid-list"></div>
		</div>
		<div id="apf-load-moreL" class="g-loadmore " bis_skin_checked="1" data-type="apf_load_locations">
				<div class="g-preloader type_1" bis_skin_checked="1">
					<div bis_skin_checked="1"></div>
				</div>
				<button class="w-btn us-btn-style_1" fdprocessedid="ks4utb">
					<span class="w-btn-label" id="apf-load-more-textL">Load More</span>
				</button>
			</div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'apf_display_locations', 'apf_display_locations_shortcode' );

// AJAX handler for filtering and loading posts
function apf_load_locations() {
	
	
	
	
    $paged = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
    $category = isset( $_POST['category'] ) ? intval( $_POST['category'] ) : '';
    $city = isset( $_POST['city'] ) ? intval( $_POST['city'] ) : '';
   
    if(get_query_var( 'eventcity' ) && $city  == '' )  { 
        $term = get_term_by('slug', get_query_var( 'eventcity' ), 'location_tag');
        if ($term) {
            $city = $term->term_id;
        }
    }
 
    $current_date = current_time('Ymd');

    $args = array(
        'post_type' => 'location',
        'paged' => $paged,
        'posts_per_page' => 20,
		'order' => 'ASC',
		'orderby' => 'title'
    );

    if ( $category ) {
         $args['tax_query'][] = array(
            'taxonomy' => 'location_cat',
            'field'    => 'term_id',
            'terms'    => $category,
        );
    }

    if ( $city ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'location_tag',
            'field'    => 'term_id',
            'terms'    => $city,
        );
    }


 		
 //  print_r('<pre>'); print_r( $args); print_r('</pre>'); die();
		
    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        $posts_html = '';

        while ( $query->have_posts() ) {  
            $query->the_post(); 
			
			  if ( has_post_thumbnail() ) { 
				  	$img_url = get_the_post_thumbnail_url(); 

					// Define the incorrect and correct base URLs
					$incorrect_base_url = 'https://test.whatshappening.co.uk/location/';
					$correct_base_url = 'https://test.whatshappening.co.uk/london/restaurant/';

					// Replace the incorrect base URL with the correct one
					$final_img_url = str_replace($incorrect_base_url, $correct_base_url, $img_url);
				  $img = '<a href="'. get_permalink() .'" aria-label="'. get_the_title() .'">
                            <img width="300" height="300" src="'. esc_url($final_img_url) .'" class="attachment-us_600_600_crop size-us_600_600_crop wp-post-image" alt="'. get_the_title().'" title="'. get_the_title() .'">
                        </a>'; 
                   }else { $img = '';}
					
                                
            $term = get_field('city');
            // Get taxonomy slug from $term
            $slug = get_term_by('name', $term, 'location_tag')->slug;
            // Get the location category slug from the location
            $category = get_the_terms( get_the_ID(), 'location_cat' );
            $category = array_shift( $category );
            $category_slug = $category->slug;

            $posts_html .= '
            <article class="w-grid-item size_1x1 post-'. get_the_ID().' post type-post status-publish format-standard has-post-thumbnail hentry category-other tag-altrincham" data-id="'. get_the_ID() .'">
                <div class="w-grid-item-h" bis_skin_checked="1">
                    <div class="w-post-elm post_image usg_post_image_1 stretched" bis_skin_checked="1">
                   '.$img.'
                    </div>
                    <div class="w-vwrapper usg_vwrapper_1 align_none valign_top" bis_skin_checked="1">
                        <div class="w-hwrapper usg_hwrapper_4 align_none valign_top" style="--hwrapper-gap:1.20rem" bis_skin_checked="1">
                            <h2 class="w-post-elm post_title usg_post_title_1 has_text_color entry-title color_link_inherit">
                                <a href="'. home_url() . '/' . $slug . '/'. $category_slug .'/'. get_post_field( 'post_name', get_post() ) .'">'. get_the_title() .'</a>
                            </h2>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_5 align_none valign_top" bis_skin_checked="1">
                            <div class="w-post-elm post_taxonomy usg_post_taxonomy_2 style_simple" bis_skin_checked="1">
                               <a href="'.home_url().'/'.$slug.'">'. get_field('city') .'</a>
                            </div>
                        </div>
                         
                    </div>
                </div>
            </article>'; 
        }
		 
        // Determine if there are more posts
        $has_more_posts = $query->max_num_pages > $paged;
		
 
        echo json_encode( array( 'posts' => $posts_html, 'has_more' => $has_more_posts ) );
    } else {
        echo json_encode( array( 'posts' => '<p class="noevents">No events</>', 'has_more' => false , 'noevents' => true ) );
    }

    wp_reset_postdata();
    wp_die();
}
add_action( 'wp_ajax_nopriv_apf_load_locations', 'apf_load_locations' );
add_action( 'wp_ajax_apf_load_locations', 'apf_load_locations' );