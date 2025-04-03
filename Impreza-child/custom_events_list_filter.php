<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Enqueue scripts and styles
function apf_enqueue_scripts() {
    wp_enqueue_script( 'apf-scripts',  get_stylesheet_directory_uri() . '/js/scripts.js?v=1.7', array('jquery'), null, true );
 
    // Localize script to pass AJAX URL
    wp_localize_script( 'apf-scripts', 'apf_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'apf_enqueue_scripts' );

function apf_display_posts_shortcode($a) {
    $atts = shortcode_atts( array(
		 'city' => '', 
            'category' => '',
            'time' => '', //today, tomorrow, weekend, month, last-month
            'fromdate' => '',
            'todate'=> '',
            'location' => '',
	), $a );
    
  
    ob_start();
    global $post;
    

    ?> <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<div class="g-cols vc_row via_grid cols_3 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default stacking_default" bis_skin_checked="1"><div class="wpb_column vc_column_container" bis_skin_checked="1"><div class="vc_column-inner" bis_skin_checked="1"></div></div><div class="wpb_column vc_column_container" bis_skin_checked="1"><div class="vc_column-inner" bis_skin_checked="1"></div></div><div class="wpb_column vc_column_container" bis_skin_checked="1"><div class="vc_column-inner" bis_skin_checked="1"></div></div></div>
    <div id="apf-post-filter">
        <div class="w-filter-list" style="margin-bottom: 20px;">
 <?php 
 if (isset($a['filtercategory'])  && isset($a['filtercity']) && isset($a['filtertime']) ) {
    echo '    <div class="g-cols vc_row via_grid cols_4 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default stacking_default">
			 <div class="w-filter-item type_dropdown wpb_column vc_column_container" >
 			 </div>';
} else { ?>

<div class="w-filter-list-title testClass">Filters</div>

            <button class="w-filter-list-closer" title="Close" aria-label="Close"></button>
            <div class="g-cols vc_row via_grid cols_4 laptops-cols_inherit tablets-cols_inherit mobiles-cols_1 valign_top type_default stacking_default">
             <div class="w-filter-item type_dropdown wpb_column vc_column_container" style="display:none;">
             <h4>Filter:</h4>
             </div>
   <?php } ?>         
            <input type="hidden" name="location" id="location" value="<?php  if( $post->post_type == 'location') echo $post->ID; elseif($atts['location'] != '') echo $atts['location']; ?>"/> 
            <div class="w-filter-item type_dropdown wpb_column vc_column_container" <?php if (isset($a['filtercategory'])) { echo 'style="display:none;"'; } ?> >
                <button class="w-filter-item-title" style="display:none;">Category<span></span></button>
                <a class="w-filter-item-reset" href="#" title="Reset"><span>Reset</span></a>
                <div class="w-filter-item-values" data-maxheight="40vh" style="max-height:40vh">
                    
                    <select class="w-filter-item-value-select" name="filter_category" id="apf-category">
                        <option value="">All Categories</option>
                        <?php 
                        
                        $categories = get_categories();
                        foreach ( $categories as $category ) {
                        if(esc_attr($atts['category']) &&  esc_attr($atts['category']) == $category->slug) $s = 'selected'; 
						else $s = '';
                            echo '<option value="' . $category->term_id . '"  '.$s.'>' . $category->name . '</option>';
                        }
                        
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="w-filter-item type_dropdown wpb_column vc_column_container" <?php if (isset($a['filtercity'])) { echo 'style="display:none;"'; } ?> >
                <button class="w-filter-item-title" style="display:none;">City<span></span></button>
                <a class="w-filter-item-reset" href="#" title="Reset"><span>Reset</span></a>
                <div class="w-filter-item-values" data-maxheight="40vh" style="max-height:40vh">
                    <select class="w-filter-item-value-select" name="filter_city" id="apf-city">
                        <option value="">All Cities</option>
                        
                        <?php 
                                                
                        $cities = get_terms( array('taxonomy' => 'post_tag', 'hide_empty' => false) );
						
                       
						if(get_query_var( 'eventcity' ) )  { 
			$term = get_term_by('slug', get_query_var( 'eventcity' ), 'post_tag');
			if ($term) {
			   	$cityid = $term->term_id;
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

            <div class="w-filter-item type_dropdown wpb_column vc_column_container"  <?php if (isset($a['filtertime'])) { echo 'style="display:none;"'; } ?>>
                <button class="w-filter-item-title" style="display:none;">Time<span></span></button>
                <a class="w-filter-item-reset" href="#" title="Reset"><span>Reset</span></a>
                <div class="w-filter-item-values" data-maxheight="40vh" style="max-height:40vh">
                    <select class="w-filter-item-value-select" name="filter_time" id="apf-time">
                          <option value="" <?php selected(esc_attr($atts['time']), '', true); ?>>All</option>
    <option value="today" <?php selected(esc_attr($atts['time']), 'today', true); ?>>Today</option>
    <option value="tomorrow" <?php selected(esc_attr($atts['time']), 'tomorrow', true); ?>>Tomorrow</option>
    <option value="weekend" <?php selected(esc_attr($atts['time']), 'weekend', true); ?>>This Weekend</option>
    <option value="this-month" <?php selected(esc_attr($atts['time']), 'month', true); ?>>This Month</option>
    <option value="last-month" <?php selected(esc_attr($atts['time']), 'last-month', true); ?>>Last Month</option>
    <option value="custom" <?php selected(esc_attr($atts['time']), 'custom', true); ?>>Custom</option>

                    </select>
                    <div id="custom-date-range" style="display: none;">
                        <label for="from-date">From:</label>
                        <input type="text" id="from-date" name="from-date" value="<?php echo esc_attr($atts['fromdate']); ?>"> 
                        
                        <label for="to-date">To:</label>
                        <input type="text" id="to-date" name="to-date" value="<?php echo esc_attr($atts['todate']); ?>">
                        
                        <button id="customdateFilter">Filter</button>
                    </div>
                </div>
            </div>
        </div>
		</div>
        <div class="w-grid type_grid layout_9990 cols_4 pagination_ajax overflow_hidden">
			<div id="apf-posts-container" class="w-grid-list"></div>
		</div>
		<div id="apf-load-more" class="g-loadmore " bis_skin_checked="1" data-type="apf_load_posts">
				<div class="g-preloader type_1" bis_skin_checked="1">
					<div bis_skin_checked="1"></div>
				</div>
				<button class="w-btn us-btn-style_1" fdprocessedid="ks4utb">
					<span class="w-btn-label" id="apf-load-more-text">Load More</span>
				</button>
			</div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'apf_display_posts', 'apf_display_posts_shortcode' );

// AJAX handler for filtering and loading posts
function apf_load_posts() {
	
	
	//print_r('<pre>'); print_r($_POST); print_r('</pre>');
	
    $paged = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
    $category = isset( $_POST['category'] ) ? intval( $_POST['category'] ) : '';
    $city = isset( $_POST['city'] ) ? intval( $_POST['city'] ) : '';
    $time = isset( $_POST['time'] ) ? sanitize_text_field( $_POST['time'] ) : '';
    $from_date =  isset( $_POST['from_date'] ) ? sanitize_text_field( $_POST['from_date'] ) : '';
    $to_date =  isset( $_POST['to_date'] ) ? sanitize_text_field( $_POST['to_date'] ) : '';
    $locations =  isset( $_POST['locations'] ) ? sanitize_text_field( $_POST['locations'] ) : '';

    if(get_query_var( 'eventcity' ) && $city  == '' )  { 
        $term = get_term_by('slug', get_query_var( 'eventcity' ), 'post_tag');
        if ($term) {
            $city = $term->term_id;
        }
    }
 
    $current_date = current_time('Ymd');

    $args = array(
        'post_type' => 'post',
        'paged' => $paged,
        'posts_per_page' => 12,
        'meta_query' => array(
            
            array(
                'relation' => 'OR',
                array(
                    'key' => 'end_date',
                    'value' => $current_date,
                    'compare' => '>=',
                    'type' => 'DATE'
                ),
                array(
                    'key' => 'begin_date',
                    'value' => $current_date,
                    'compare' => '>=',
                    'type' => 'DATE'
                ),
            )
        ),
        'orderby' => 'meta_value',
        'meta_key' => 'begin_date',
        'order' => 'ASC',
    );

    if ( $category ) {
        $args['cat'] = $category;
    }

    if ( $city ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $city,
        );
    }
    

    
    

    if ( $time ) { $args['meta_query'] = array();
        switch ( $time ) {
		
            case 'today':
                $args['meta_query'][] = array(
                    'key'     => 'begin_date',
                    'value'   => $current_date,
                    'compare' => '<=',
                    'type'    => 'DATE'
                );
                $args['meta_query'][] = array(
                    'key'     => 'end_date',
                    'value'   => $current_date,
                    'compare' => '>=',
                    'type'    => 'DATE'
                );
                break;
            case 'tomorrow':
                $tomorrow = date('Ymd', strtotime('+1 day'));
                $args['meta_query'][] = array(
                    'key'     => 'begin_date',
                    'value'   => $tomorrow,
                    'compare' => '<=',
                    'type'    => 'DATE'
                );
                $args['meta_query'][] = array(
                    'key'     => 'end_date',
                    'value'   => $tomorrow,
                    'compare' => '>=',
                    'type'    => 'DATE'
                );
                break;
            case 'weekend':
                $saturday = date('Ymd', strtotime('next Saturday'));
                $sunday = date('Ymd', strtotime('next Sunday'));
            
                $args['meta_query'] = array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'begin_date',
                        'value'   => $sunday,
                        'compare' => '<=',
                        'type'    => 'DATE'
                    ),
                    array(
                        'key'     => 'end_date',
                        'value'   => $saturday,
                        'compare' => '>=',
                        'type'    => 'DATE'
                    )
                );
                break;
                                
                case 'this-month':
                    $start_of_month = date('Ym') . '01';
                    $end_of_month = date('Ymt');
                
                    $args['meta_query'] = array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'begin_date',
                            'value'   => $end_of_month,
                            'compare' => '<=',
                            'type'    => 'DATE'
                        ),
                        array(
                            'key'     => 'end_date',
                            'value'   => $start_of_month,
                            'compare' => '>=',
                            'type'    => 'DATE'
                        )
                    );
                    break;
                    
                // Add condition for events happening last weekend (previous Saturday and Sunday) if within this month
                if ($last_saturday >= $start_of_month && $last_saturday <= $end_of_month) {
                    echo "trueshyeb2";
                    $args['meta_query'][] = array(
                        'key'     => 'begin_date',
                        'value'   => $last_saturday,
                        'compare' => '<=',
                        'type'    => 'DATE'
                    );
                    $args['meta_query'][] = array(
                        'key'     => 'end_date',
                        'value'   => $last_sunday,
                        'compare' => '>=',
                        'type'    => 'DATE'
                    );
                }
            
                // Optionally, check for today and add current weekend if today is Thursday or later
                // If today is Thursday, Friday, Saturday, or Sunday, add the current weekend dates
                $today = date('Ymd');
                if (in_array(date('l'), ['Thursday', 'Friday', 'Saturday', 'Sunday'])) {
                    if ($current_saturday >= $start_of_month && $current_saturday <= $end_of_month) {
                        $args['meta_query'][] = array(
                            'key'     => 'begin_date',
                            'value'   => $current_saturday,
                            'compare' => '<=',
                            'type'    => 'DATE'
                        );
                        $args['meta_query'][] = array(
                            'key'     => 'end_date',
                            'value'   => $current_sunday,
                            'compare' => '>=',
                            'type'    => 'DATE'
                        );
                    }
                }
                break;
                
                
            case 'last-month':
                $start_of_last_month = date('Ym', strtotime('-1 month')) . '01';
                $end_of_last_month = date('Ymt', strtotime('-1 month'));

                $args['meta_query']['relation'] = 'AND';
                $args['meta_query'][] = array(
                    'key'     => 'begin_date',
                    'value'   => $start_of_last_month,
                    'compare' => '<=',
                    'type'    => 'DATE'
                );
                $args['meta_query'][] = array(
                    'key'     => 'end_date',
                    'value'   => $end_of_last_month,
                    'compare' => '>=',
                    'type'    => 'DATE'
                );
                break;
        }
    }

if ( ! empty( $meta_query ) ) {
            $args['meta_query'] = $meta_query;
        }
        
        if ($time === 'custom' && $from_date && $to_date) {
            $args['meta_query']['relation'] = 'AND';
        
            // Ensure that the begin_date is on or before the 'to_date'
            $args['meta_query'][] = array(
                'key' => 'begin_date',
                'value' => date('Ymd', strtotime($to_date)),
                'compare' => '<=',
                'type' => 'DATE'
            );
        
            // Ensure that the end_date is on or after the 'from_date'
            $args['meta_query'][] = array(
                'key' => 'end_date',
                'value' => date('Ymd', strtotime($from_date)),
                'compare' => '>=',
                'type' => 'DATE'
            );
        
            // Include events where the event ends exactly on or before the 'to_date'
            $args['meta_query'][] = array(
                'key' => 'end_date',
                'value' => date('Ymd', strtotime($to_date)),
                'compare' => '<=',
                'type' => 'DATE'
            );
        }
        
        
        
    
    if($locations)
    {
         $args['meta_query'][] = array(
            'key' => 'location',
            'value' => $locations,
            'compare' => '=',
        );
    }
 		
// print_r('<pre>'); print_r( $args); print_r('</pre>'); 
		
    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
	    
        while ( $query->have_posts() ) {  
            $query->the_post(); 
			
			  if ( has_post_thumbnail() ) {
				  $img = '<a href="'. get_permalink() .'" aria-label="'. get_the_title() .'">
                            <img width="300" height="300" src="'. get_the_post_thumbnail_url().'" class="attachment-us_600_600_crop size-us_600_600_crop wp-post-image" alt="'. get_the_title().'" title="'. get_the_title() .'">
                        </a>'; 
                   }else { $img = '';}
					
		    $tags = get_the_tags();
			$tg= '';
                                if ( $tags ) {
                                    foreach ( $tags as $tag ) {
                                        $tg .=   '<a class="term-' . esc_attr( $tag->term_id ) . ' term-' . esc_attr( $tag->slug ) . '" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a> ';
                                    }
                                }
                                
					
            $posts_html .= '
            <article class="w-grid-item size_1x1 post-'. get_the_ID().' post type-post status-publish format-standard has-post-thumbnail hentry category-other tag-altrincham" data-id="'. get_the_ID() .'">
                <div class="w-grid-item-h" bis_skin_checked="1">
                    <div class="w-post-elm post_image usg_post_image_1 stretched" bis_skin_checked="1">
                   '.$img.'
                    </div>
                    <div class="w-vwrapper usg_vwrapper_1 align_none valign_top" bis_skin_checked="1">
                        <div class="w-hwrapper usg_hwrapper_4 align_none valign_top" style="--hwrapper-gap:1.20rem" bis_skin_checked="1">
                            <h2 class="w-post-elm post_title usg_post_title_1 has_text_color entry-title color_link_inherit">
                                <a href="'. get_permalink().'">'. get_the_title() .'</a>
                            </h2>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_5 align_none valign_top" bis_skin_checked="1">
                            <div class="w-post-elm post_taxonomy usg_post_taxonomy_2 style_simple" bis_skin_checked="1">
                               '.$tg.'
                            </div>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_3 align_none valign_top" bis_skin_checked="1">
                            <div class="w-vwrapper usg_vwrapper_2 align_none valign_top" bis_skin_checked="1">
                                <div class="w-html usg_html_1" bis_skin_checked="1">
                                    '. do_shortcode('[get_acf_location]') .'
                                </div>
                            </div>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_6 align_left valign_middle" style="--hwrapper-gap:1.20rem" bis_skin_checked="1">
                            <div class="w-hwrapper usg_hwrapper_7 align_left valign_middle" style="--hwrapper-gap:5px" bis_skin_checked="1">
                                <div class="w-post-elm post_custom_field usg_post_custom_field_2 has_text_color type_text begin_date color_link_inherit" bis_skin_checked="1">
                                    <span class="w-post-elm-value">'.  get_field('begin_date') .'</span>
                                </div>
                                <div class="w-text usg_text_1 has_text_color" bis_skin_checked="1">
                                    <span class="w-text-h"><span class="w-text-value">–</span></span>
                                </div>
                                <div class="w-post-elm post_custom_field usg_post_custom_field_1 has_text_color type_text end_date color_link_inherit" bis_skin_checked="1">
                                    <span class="w-post-elm-value">'. get_field('end_date') .'</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_2 align_none valign_top" bis_skin_checked="1">
                            <div class="w-html usg_html_2" bis_skin_checked="1">
                                <div class="w-post-elm post_taxonomy style_badge color_link_inherit" bis_skin_checked="1">
                                    '.  do_shortcode('[create_tag_for_grid]') .'
                                </div>
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
add_action( 'wp_ajax_nopriv_apf_load_posts', 'apf_load_posts' );
add_action( 'wp_ajax_apf_load_posts', 'apf_load_posts' );



function related_events_shortcode($atts) {
    global $post;
    $output = '';

    if (is_singular('post')) {
        $categories = wp_get_post_categories($post->ID);
        $tags = wp_get_post_tags($post->ID);
        $current_date = current_time('Ymd');

        // Condition 1: Match both categories and tags
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 6, // Adjust the number of posts to display
            'post__not_in' => array($post->ID),
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $categories,
                    'operator' => 'IN',
                ),
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'id',
                    'terms' => wp_list_pluck($tags, 'term_id'),
                    'operator' => 'IN',
                ),
            ),
          'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'begin_date',
                'value' => $current_date,
                'compare' => '>=',
                'type' => 'DATE'
            ),
            array(
                'relation' => 'OR',
                array(
                    'key' => 'end_date',
                    'value' => $current_date,
                    'compare' => '>=',
                    'type' => 'DATE'
                ),
                array(
                    'key' => 'begin_date',
                    'value' => $current_date,
                    'compare' => '>=',
                    'type' => 'DATE'
                ),
            )
        ),
        'orderby' => 'meta_value',
        'meta_key' => 'begin_date',
        'order' => 'ASC',
        );

        $related_query = new WP_Query($args);

        // Condition 2: Match tags only if no posts found in Condition 1
        if (!$related_query->have_posts()) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'id',
                    'terms' => wp_list_pluck($tags, 'term_id'),
                    'operator' => 'IN',
                ),
            );
            $related_query = new WP_Query($args);
        }

        // Condition 3: Match categories only if no posts found in Condition 2
        if (!$related_query->have_posts()) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $categories,
                    'operator' => 'IN',
                ),
            );
            $related_query = new WP_Query($args);
        }

        if ($related_query->have_posts()) { $output .= '<div class="w-grid type_grid layout_9990 cols_2 overflow_hidden" id="us_grid_1" style="--gap:1.5rem;" data-filterable="true" bis_skin_checked="1">
<div class="w-grid-list" bis_skin_checked="1" id="apf-posts-container-events">	 ';
            while ($related_query->have_posts()) {
                $related_query->the_post();
                 if ( has_post_thumbnail() ) {  $img = '<a href="'. get_permalink() .'" aria-label="'. get_the_title() .'">
                            <img width="300" height="300" src="'. get_the_post_thumbnail_url().'" class="attachment-us_600_600_crop size-us_600_600_crop wp-post-image" alt="'. get_the_title().'" title="'. get_the_title() .'">
                        </a>'; 
                   }else { $img = '';}
					
		    $tags = get_the_tags();
			$tg= '';
                                if ( $tags ) {
                                    foreach ( $tags as $tag ) {
                                        $tg .=   '<a class="term-' . esc_attr( $tag->term_id ) . ' term-' . esc_attr( $tag->slug ) . '" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a> ';
                                    }
                                }
                                
					
            $output .= '
            <article class="w-grid-item size_1x1 post-'. get_the_ID().' post type-post status-publish format-standard has-post-thumbnail hentry category-other tag-altrincham" data-id="'. get_the_ID() .'">
                <div class="w-grid-item-h" bis_skin_checked="1">
                    <div class="w-post-elm post_image usg_post_image_1 stretched" bis_skin_checked="1">
                   '.$img.'
                    </div>
                    <div class="w-vwrapper usg_vwrapper_1 align_none valign_top" bis_skin_checked="1">
                        <div class="w-hwrapper usg_hwrapper_4 align_none valign_top" style="--hwrapper-gap:1.20rem" bis_skin_checked="1">
                            <h2 class="w-post-elm post_title usg_post_title_1 has_text_color entry-title color_link_inherit">
                                <a href="'. get_permalink().'">'. get_the_title() .'</a>
                            </h2>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_5 align_none valign_top" bis_skin_checked="1">
                            <div class="w-post-elm post_taxonomy usg_post_taxonomy_2 style_simple" bis_skin_checked="1">
                               '.$tg.'
                            </div>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_3 align_none valign_top" bis_skin_checked="1">
                            <div class="w-vwrapper usg_vwrapper_2 align_none valign_top" bis_skin_checked="1">
                                <div class="w-html usg_html_1" bis_skin_checked="1">
                                    '. do_shortcode('[get_acf_location]') .'
                                </div>
                            </div>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_6 align_left valign_middle" style="--hwrapper-gap:1.20rem" bis_skin_checked="1">
                            <div class="w-hwrapper usg_hwrapper_7 align_left valign_middle" style="--hwrapper-gap:5px" bis_skin_checked="1">
                                <div class="w-post-elm post_custom_field usg_post_custom_field_2 has_text_color type_text begin_date color_link_inherit" bis_skin_checked="1">
                                    <span class="w-post-elm-value">'.  get_field('begin_date') .'</span>
                                </div>
                                <div class="w-text usg_text_1 has_text_color" bis_skin_checked="1">
                                    <span class="w-text-h"><span class="w-text-value">–</span></span>
                                </div>
                                <div class="w-post-elm post_custom_field usg_post_custom_field_1 has_text_color type_text end_date color_link_inherit" bis_skin_checked="1">
                                    <span class="w-post-elm-value">'. get_field('end_date') .'</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-hwrapper usg_hwrapper_2 align_none valign_top" bis_skin_checked="1">
                            <div class="w-html usg_html_2" bis_skin_checked="1">
                                <div class="w-post-elm post_taxonomy style_badge color_link_inherit" bis_skin_checked="1">
                                    '.  do_shortcode('[create_tag_for_grid]') .'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>'; 
            }
            $output .= '</div></div>';
            wp_reset_postdata();
        } else {
            $output .= '<p>No related events found.</p>';
        }
    }

    return $output;
}
add_shortcode('related_events', 'related_events_shortcode');