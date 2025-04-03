<?php
global $wpdb;
require_once('/home/www/thatstheatre.com/wp-config.php');
require( '/home/www/thatstheatre.com/wp-load.php' );

//echo "aaa".$_SERVER['DOCUMENT_ROOT'];

$fivesdrafts = $wpdb->get_results(
    "
        SELECT ID, post_title
        FROM $wpdb->posts
        WHERE post_status = 'draft'
    "
);

foreach ( $fivesdrafts as $fivesdraft ) {
    echo $fivesdraft->post_title;
}
