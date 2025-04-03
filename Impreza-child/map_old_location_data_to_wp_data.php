<?php
require_once('/home/www/whatshappening.co.uk/wp-config.php');
require( '/home/www/whatshappening.co.uk/wp-load.php' );
require( '/home/www/whatshappening.co.uk/wp-admin/includes/image.php' );

global $seconddb;
$seconddb = new wpdb('web119_6', '%NpMM64yH!J#', 'web119_db6','s193.goserver.host');

test_article($seconddb);

function test_article($seconddb) {

  global $wpdb;

  echo "Start:";

  $args = array(
    'posts_per_page'   => -1,
    'post_type'        => 'post'
  );
  $the_query = new WP_Query( $args );

  if ( $the_query->have_posts() ) :

    while ( $the_query->have_posts() ) : $the_query->the_post();

      $postID = get_the_ID();
      $key_1_value = get_post_meta( get_the_ID(), 'location', true );
      echo "Post location ID: ".$key_1_value."\n";

      if ($key_1_value !="") {
        $query = "SELECT type, iden FROM locations WHERE id=".$key_1_value;

        if ($seconddb->query($query) === FALSE) {
          echo "Misst";
        	return FALSE;
        } else {
        	//return $seconddb->get_results($query);
          $rows = $seconddb->get_results($query);

        }

        foreach ($rows as $obj) {
        $query2 = "SELECT name, strasse, plz, stadt from ".strtolower($obj->type)." WHERE identifier=".$obj->iden;
        //echo $query2;
        if ($seconddb->query($query2) === FALSE) {
          echo "Misst";
        	return FALSE;
        } else {
        	//return $seconddb->get_results($query);
          $rows2 = $seconddb->get_results($query2);
        }

        foreach ($rows2 as $obj2) {
          echo "Data from Laravel DB: ".$obj2->name.", ".$obj2->strasse.", ".$obj2->plz.", ".$obj2->stadt."\n";

          $args2 = array(
            'posts_per_page'   => -1,
            'post_type'        => 'location',
            'meta_query' => array(
        			'relation' => 'AND',
        			array(
        				'key' => 'city',
        				'value' => $obj2->stadt,
                'compare' => 'LIKE'
        			)
              ,
        			array(
        				'key' => 'postcode',
        				'value' => $obj2->plz,
                'compare' => 'LIKE'
        			)
              ,
              array(
                'key' => 'street',
                'value' => $obj2->strasse,
                'compare' => '='
              )
        		)
          );
          $the_query2 = new WP_Query( $args2 );

          if ( $the_query2->have_posts() ) :

            while ( $the_query2->have_posts() ) : $the_query2->the_post();

              $key_2_value = get_post_meta( get_the_ID(), 'postcode', true );
              $key_2_value1 = get_post_meta( get_the_ID(), 'street', true );
              $key_2_value2 = get_post_meta( get_the_ID(), 'city', true );

              if ($obj2->name == get_the_title()) {
                echo "Update: ".$key_1_value."->".get_the_ID().",".get_the_title().",".$key_2_value.",".$key_2_value1.",".$key_2_value2."\n";
                update_post_meta( $postID, 'location', get_the_ID());
              }


            endwhile;
          endif;

          //$results_wpl = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE option_id = 1", OBJECT );


        }

      }
    }
    endwhile;
    wp_reset_postdata();
  endif;

  /*
  $query = "SELECT name,
            	strasse,
            	plz,
            	stadt,
            	telefon1,
            	website,
            	email
            FROM restaurants ORDER BY name ASC LIMIT 50";

  if ($seconddb->query($query) === FALSE) {
    echo "Misst";
  	return FALSE;
  } else {
  	//return $seconddb->get_results($query);
    $rows = $seconddb->get_results($query);

  }

  $post_id = 0;
  foreach ($rows as $obj) {

  }
  */

}
?>
