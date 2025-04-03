<?php
if (is_single ()) {
  global $post;
  ?>

  <script type="text/javascript">
    var geocoder;
    var map;

    function initialize() {
      geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(-34.397, 150.644);
      var mapOptions = {
        zoom: 8,
        center: latlng
      }
      map = new google.maps.Map(document.getElementById('map'), mapOptions);
    }
    initialize();

    function codeAddress(address_data) {
      var address = address_data;//document.getElementById('address').value;
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == 'OK') {
          map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
          });
        } else {
          alert('Geocode was not successful for the following reason: ' + status);
        }
      });
    }

  <?php

  //if( $posts ) {
  //		foreach( $posts as $post ) {
        $city = get_field( "event_city", $post->ID );
        $address = get_field( "address", $post->ID );
  //    }
      $address_data = $address.",".$city;
  //}
  ?>

  codeAddress('<?php echo $address_data ?>');
  </script>
  <?php

}
?>
