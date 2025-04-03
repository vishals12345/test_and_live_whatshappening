<?php
require_once('/home/www/whatshappening.co.uk/wp-config.php');
require( '/home/www/whatshappening.co.uk/wp-load.php' );
require( '/home/www/whatshappening.co.uk/wp-admin/includes/image.php' );

global $seconddb;
$seconddb = new wpdb('web119_6', '%NpMM64yH!J#', 'web119_db6','s193.goserver.host');

test_article($seconddb);

function test_article($seconddb) {

  $query = "SELECT user_id,
            	headline,
            	image,
            	created_at,
            	description,
            	website,
            	ticket_url,
            	email,
              city,
            	-- (SELECT C.id FROM (SELECT id,city,count(city) AS CC FROM cities GROUP BY city) C WHERE C.CC=1 AND C.city=events.city) CITYID,
            	location_id,
            	address,
            	charge,
            	begin_date,
            	end_date,
            	begin_time,
            	end_time,
            	image,
            	category
            FROM events WHERE created_at LIKE '2022-03-14%' and date_stamp_added IS NULL ORDER BY created_at DESC";

  if ($seconddb->query($query) === FALSE) {
    echo "Misst";
  	return FALSE;
  } else {
  	//return $seconddb->get_results($query);
    $rows = $seconddb->get_results($query);

  }

  //print_r($rows);

  $post_id = 0;
  foreach ($rows as $obj) {

    $post_name = strtolower(preg_replace('/[\s,%\'@-]+/','-',$obj->headline));

    echo "Insert event: ".$obj->headline."\n";

    $title = get_page_by_title($obj->headline, 'OBJECT', 'post');

    //print_r($title);
    //echo $title->post_title;


    //if (!get_page_by_title($title->post_title, 'OBJECT', 'post') ){

    if ($obj->category == "Other Events") {
      $cat_id = get_cat_ID ( 'Other' );
    }
    else {
      $cat_id = get_cat_ID ( $obj->category );
    }

    echo $cat_id.", ".$obj->category."\n";

    //$ID             = $row['post_id'];
    $title          = $obj->headline;
    $content        = $obj->description;
    $postdate       = $obj->created_at;
      $imagePath      = '2021/10/'.$obj->image;
    $slug           = $post_name;
    $author         = $obj->user_id;
    $category       = array($cat_id);
    $tags           = array($obj->city);

    $my_post = array(
                'ID'           => '',
                'post_title'   => $title,
                'post_content' => $content,
                'post_date'    => $postdate,
                'post_name'    => $slug,
                'post_author'  => $author,
                'post_status'  => 'publish',
                'post_category'=> $category,
                'tags_input'   => $tags
            );

    //print_r($my_post);

    $post_id = wp_insert_post( $my_post );

    $new_slug = strtolower(preg_replace('/[\s,%\'@-]+/','-',$obj->city))."/".$post_name;

    update_post_meta($post_id, 'custom_permalink', $new_slug);

    /**** wp_insert_attachment ****/

    $filetype = wp_check_filetype( basename( $imagePath ), null );

    $wp_upload_dir = wp_upload_dir();

    $attachment = array(
        'guid' => $wp_upload_dir['url'] . '/' . basename($imagePath),
        'post_mime_type' => $filetype['type'],
        'post_title' => sanitize_file_name(basename($imagePath)),
        'post_content' => '',
        'post_status' => 'inherit',
        'post_parent' => $post_id
    );

    // So here we attach image to its parent's post ID from above
    //echo "<br>".$wp_upload_dir['basedir']."/".$imagePath;
    $file = $wp_upload_dir['basedir']."/".$imagePath;
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id);
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    //print_r($attach_data);
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail( $post_id, $attach_id );


    update_field( 'field_615dcb641e5b4', $obj->website, $post_id );
    update_field( 'field_615dcb881e5b5', $obj->email, $post_id );
    update_field( 'field_615dcba11e5b6', $obj->ticket_url, $post_id );
    update_field( 'field_615dcbb21e5b7', $obj->charge, $post_id );
    update_field( 'field_61604c0abe153', urlencode($obj->city), $post_id );
    update_field( 'field_615dcbe91e5b9', $obj->location_id, $post_id );
    update_field( 'field_615dcbff1e5ba', $obj->address, $post_id );
    update_field( 'field_615dd05ace2d7', $obj->begin_date, $post_id );
    update_field( 'field_615dd07dce2d8', $obj->begin_time, $post_id );
    update_field( 'field_615dd0a9ce2d9', $obj->end_date, $post_id );
    update_field( 'field_615dd0bfce2da', $obj->end_time, $post_id );

  }

}
?>
