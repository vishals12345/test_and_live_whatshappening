<?php
require_once('/home/www/thatstheatre.com/wp-config.php');
require( '/home/www/thatstheatre.com/wp-load.php' );
global $wpdb;
global $seconddb;
$seconddb = new wpdb('web119_3', 'z1tYpHA76a4Nw8$59@j!rsa&', 'web119_db3','s193.goserver.host:3307');

test_article($seconddb,$wpdb);

function test_article($seconddb,$wpdb) {

  $query = "SELECT id,
                    password,
                    username,
                    name,
                    email,
                    vorname,
                    nachname,
                    My_Hobbies,
                    created_at
              FROM users ORDER BY id ASC";

  if ($seconddb->query($query) === FALSE) {
    echo "Misst";
  	return FALSE;
  } else {
  	//return $seconddb->get_results($query);
    $rows = $seconddb->get_results($query);
  }

  foreach ($rows as $obj) {
    /*
    $query_userid = "SELECT COUNT(ID) from wp_users WHERE ID=".$obj->id;

    $rowcount = $wpdb->get_var($query_userid);

    echo $rowcount;
    */
    echo "Insert user: ".$obj->username."\n";

    $user_id = username_exists( $obj->username );

    if (!$user_id) {
      $user_id = wp_create_user( $obj->username, $obj->password, $obj->email );
      $user_id = username_exists( $obj->username );
      echo "!--".$user_id." ".$obj->username;
      $wpdb->update( 'wp_users', array( 'ID' => $obj->id),array('ID'=>$user_id));
      $wpdb->delete( 'wp_usermeta', array( 'user_id' => $user_id));
      //$wpdb->insert( $wpdb->users, array( 'ID' => $obj->id ) );

      $userdata = array(
        'ID'                    => $obj->id,    //(int) User ID. If supplied, the user will be updated.
        'user_pass'             => $obj->password,   //(string) The plain-text user password.
        'user_login'            => strtolower($obj->username),   //(string) The user's login username.
        'user_nicename'         => $obj->name,   //(string) The URL-friendly user name.
        //'user_url'              => '',   //(string) The user URL.
        'user_email'            => $obj->email,   //(string) The user email address.
        'display_name'          => $obj->vorname,   //(string) The user's display name. Default is the user's username.
        'nickname'              => $obj->name,   //(string) The user's nickname. Default is the user's username.
        'first_name'            => $obj->vorname,   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
        'last_name'             => $obj->nachname,   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
        'description'           => $obj->My_Hobbies,   //(string) The user's biographical description.
        //'rich_editing'          => '',   //(string|bool) Whether to enable the rich-editor for the user. False if not empty.
        //'syntax_highlighting'   => '',   //(string|bool) Whether to enable the rich code editor for the user. False if not empty.
        //'comment_shortcuts'     => '',   //(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
        //'admin_color'           => '',   //(string) Admin color scheme for the user. Default 'fresh'.
        //'use_ssl'               => '',   //(bool) Whether the user should always access the admin over https. Default false.
        'user_registered'       => $obj->created_at,   //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
        //'show_admin_bar_front'  => '',   //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
        'role'                  => 'subscriber',   //(string) User's role.
        //'locale'                => '',   //(string) User's locale. Default empty.
      );

      $user = wp_insert_user( $userdata ) ;
    }

  }

}
?>
