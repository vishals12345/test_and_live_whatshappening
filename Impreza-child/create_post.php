<?php

function test_insert_post() {

  //require_once(ABSPATH . 'wp-admin/includes/image.php');

  $wp_posts = array(
      array(
          'post_id'        => '10',
          'post_title'     => 'Post Title 1',
          'post_date'      => '2015-06-22',
          'post_content'   => 'Post Content 1',
          'post_imagePath' => '2021/10/1620801158.jpg',
          'post_name' => 'my-custom-slug1'
      )
  );

  foreach ($wp_posts as $i => $row){
      $ID             = $row['post_id'];
      $title          = $row['post_title'];
      $content        = $row['post_content'];
      $postdate       = $row['post_date'];
      $imagePath      = $row['post_imagePath'];
      $slug           = $row['post_name'];

      $my_post = array(
                  'ID'           => $ID,
                  'post_title'   => $title,
                  'post_content' => $content,
                  'post_date'    => $postdate,
                  'post_name'    => $slug
              );

      $parent_post_id = wp_insert_post( $my_post ); //Returns the post ID on success.

      $post_id = wp_insert_post( $my_post );

      if(!$post_id) {
        //log an error or something...
        echo "No post_id.";
        continue;
      }

      /**** wp_insert_attachment ****/

      $filetype = wp_check_filetype( basename( $imagePath ), null );

      //echo $filetype['ext']."<br>".$filetype['type']."<br>".basename($imagePath); // will output jpg

      $wp_upload_dir = wp_upload_dir();

      //print_r($wp_upload_dir);

      $attachment = array(
          'guid' => $wp_upload_dir['url'] . '/' . basename($imagePath),
          'post_mime_type' => $filetype['type'],
          'post_title' => sanitize_file_name(basename($imagePath)),
          'post_content' => '',
          'post_status' => 'inherit',
          'post_parent' => $parent_post_id
      );

      // So here we attach image to its parent's post ID from above
      //echo "<br>".$wp_upload_dir['basedir']."/".$imagePath;
      $file = $wp_upload_dir['basedir']."/".$imagePath;
      $attach_id = wp_insert_attachment( $attachment, $file, $parent_post_id);
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
      //print_r($attach_data);
      wp_update_attachment_metadata( $attach_id, $attach_data );
      set_post_thumbnail( $parent_post_id, $attach_id );

      update_field( 'field_615705569bc9f', 'Hallo', $post_id );
  }
}
?>
