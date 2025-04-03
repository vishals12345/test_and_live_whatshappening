<?php
//require_once('/home/www/thatstheatre.com/wp-config.php');
require( '/home/www/thatstheatre.com/wp-load.php' );

global $seconddb;
$seconddb = new wpdb('web119_3', 'z1tYpHA76a4Nw8$59@j!rsa&', 'web119_db3','s193.goserver.host:3307');

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
                    (SELECT name FROM locations WHERE id=events.location_id) as location,
                    address,
                    charge,
                    begin_date,
                    end_date,
                    begin_time,
                    end_time,
                    image
              FROM events WHERE created_at <= curdate() and date_stamp_added IS NULL ORDER BY created_at DESC LIMIT 5";

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


    $title = get_page_by_title($obj->headline, 'OBJECT', 'post');

    //print_r($title);
    //echo $title->post_title;


    //if (!get_page_by_title($title->post_title, 'OBJECT', 'post') ){

    //$ID             = $row['post_id'];
    $title          = $obj->headline;
    $content        = $obj->description;
    $postdate       = $obj->created_at;
    $imagePath      = '2021/10/'.$obj->image;
    $slug           = $post_name;
    $author         = $obj->user_id;

    $my_post = array(
                'ID'           => $ID,
                'post_title'   => $title,
                'post_content' => $content,
                'post_date'    => $postdate,
                'post_name'    => $slug,
                'post_author'  => $author
            );

    //print_r($my_post);

    //$parent_post_id = wp_insert_post( $my_post ); //Returns the post ID on success.

    $post_id = wp_insert_post( $my_post );

    if(!$post_id) {
      //log an error or something...
      echo "No post_id.";
      continue;
    }
    //}

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
    update_field( 'field_615dcbc91e5b8', $obj->city, $post_id );
    update_field( 'field_615dcbe91e5b9', $obj->location, $post_id );
    update_field( 'field_615dcbff1e5ba', $obj->address, $post_id );
    update_field( 'field_615dd05ace2d7', $obj->begin_date, $post_id );
    update_field( 'field_615dd07dce2d8', $obj->begin_time, $post_id );
    update_field( 'field_615dd0a9ce2d9', $obj->end_date, $post_id );
    update_field( 'field_615dd0bfce2da', $obj->end_time, $post_id );

  }

}
?>
