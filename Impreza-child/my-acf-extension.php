<?php

	new my_acf_extension();

	class my_acf_extension {

		public function __construct() {
			// state field on city
			//add_action('acf/load_field/key=field_579376941cecc', array($this, 'load_city_field_choices'));
			// state field on post (city)
			add_action('acf/load_field/key=field_61604c0abe153', array($this, 'load_city_field_choices'));
			// city field on post (location)
			//add_action('acf/load_field/key=field_615dcbe91e5b9', array($this, 'load_location_field_choices'));
			// ajax action for loading city choices
			add_action('wp_ajax_load_location_field_choices', array($this, 'ajax_load_location_field_choices'));
			// address field on post
			add_action('acf/load_field/key=field_615dcbff1e5ba', array($this, 'load_address_field_choices'));
			// ajax action for loading address choices
			add_action('wp_ajax_load_address_field_choices', array($this, 'ajax_load_address_field_choices'));
			// enqueue js extension for acf
			// do this when ACF in enqueuing scripts
			add_action('acf/input/admin_enqueue_scripts', array($this, 'enqueue_script'));
		} // end public function __construct

		public function load_city_field_choices($field) {
			// this funciton dynamically loads the state select field choices
			
			$cities = $this->get_cities($city);
			$field['choices'] = $cities;
	    	return $field;

		} // end public function load_city_field_choices

		public function load_location_field_choices($field) {
			// this function dynamically loads location field choices
			// based on the currently saved city

			// I only want to do this on Posts
			global $post;
			if (!$post ||
			    !isset($post->ID) ||
			    get_post_type($post->ID) != 'post') {
				return $field;
			}

			// get the state post id
			// I generally use get_post_meta() instead of get_field()
			// when building functionality, but get_field() could be
			// subsitited here
			$city = $_POST['event_city'];
			$locations = $this->get_locations($city);
			$field['choices'] = $locations;
			return $field;
		} // end public funciton load_location_field_choices

		public function load_address_field_choices($field) {
			// this function dynamically loads location field choices
			// based on the currently saved city

			// I only want to do this on Posts
			global $post;
			if (!$post ||
			    !isset($post->ID) ||
			    get_post_type($post->ID) != 'post') {
				return $field;
			}

			// get the state post id
			// I generally use get_post_meta() instead of get_field()
			// when building functionality, but get_field() could be
			// subsitited here
			$location = $_POST['location_id'];
			$address = $this->get_addresses($location);
			$field['choices'] = $address;
			return $field;
		} // end public funciton load_location_field_choices


		public function enqueue_script() {
			// enqueue acf extenstion

			// only enqueue the script on the post page where it needs to run
			/* *** THIS IS IMPORTANT
			       ACF uses the same scripts as well as the same field identification
			       markup (the data-key attribute) if the ACF field group editor
			       because of this, if you load and run your custom javascript on
			       the field group editor page it can have unintended side effects
			       on this page. It is important to alway make sure you're only
			       loading scripts where you need them.
			*/

			$handle = 'my-acf-extension';
			$acf_version = acf_get_setting('version');
			//echo $version;
			if (version_compare($acf_version, '5.7.0', '<')) {
				// I'm using this method to set the src because
				// I don't know where this file will be located
				// you should alter this to use the correct fundtions
				// to set the src value to point to the javascript file
				$src = '/'.str_replace(ABSPATH, '', dirname(__FILE__)).'/my-acf-extension.js';
			} else {
				$src = '/'.str_replace(ABSPATH, '', dirname(__FILE__)).'/dynamic-select-on-select.js';
			}
			// make this script dependent on acf-input
			$depends = array('acf-input');

			wp_enqueue_script($handle, $src, $depends);
		} // end public function enqueue_script

		public function ajax_load_location_field_choices() {
			// this funtion is called by AJAX to load locations
			// based on city selecteion

			// we can use the acf nonce to verify
			if (!wp_verify_nonce($_POST['nonce'], 'acf_nonce')) {
				die();
			}

			$city = 0;
			if (isset($_POST['event_city'])) {
				//$state = intval($_POST['event_city']);
				$city = $_POST['event_city'];
			}
			$locations = $this->get_locations($city);
			$choices = array();
			foreach ($locations as $value => $label) {
				$choices[] = array('value' => $value, 'label' => $label);
			}
			echo json_encode($choices);
			exit;
		} // end public function ajax_load_location_field_choices

		public function ajax_load_address_field_choices() {
			// this funtion is called by AJAX to load locations
			// based on city selecteion

			// we can use the acf nonce to verify
			if (!wp_verify_nonce($_POST['nonce'], 'acf_nonce')) {
				die();
			}

			$location = 0;
			if (isset($_POST['location_id'])) {
				//$state = intval($_POST['event_city']);
				$location = $_POST['location_id'];
			}
			$address = $this->get_addresses($location);
			$choices = array();
			foreach ($address as $value => $label) {
				$choices[] = array('value' => $value, 'label' => $label);
			}
			echo json_encode($choices);
			exit;
		} // end public function ajax_load_location_field_choices

		private function get_locations($city) {

			global $wpdb;
			if (!empty($city)) {

				// ACF key of ctiy field
				$field_key = "field_62b31cb801c61";
				$field = get_field_object($field_key);

				if( $field )
				{
						$posts = get_posts( array(
					      'post_type' 			=> 'location',
					      'posts_per_page'	=> -1,
								'meta_key' 				=> 'city',
								'orderby' 				=> 'street',
								'order' 					=> 'ASC',
								'meta_query' => array(
								    'relation' => 'AND',
								    array(
								        'key'     => 'city',
								        'value'   => $city,
								        'compare' => '='
								    )
								)
							)
						);

					  if( $posts ) {
							$choices = array('' => '-- Choose a Location. Location not listed? Use "Add New Location" to create it. --');
							foreach( $posts as $post ) {
			            $choices[$post->ID] = $post->post_title.' -- '.$post->street.' -- '.$post->postcode;
			        }
						}
						else {
							$choices = array('' => '-- No location for that city. Please use the link above "Add New Location" to create a location and switch city to get it listed. --');
						}
				}

				return $choices;
			}
		} // end private function get_locations

		private function get_addresses($address) {

			global $wpdb;
			if (!empty($address)) {

				$street = get_post_meta($address,'street',true);
				$postcode = get_post_meta($address,'postcode',true);
				$choices[$address] = $street.' -- '.$postcode;
				
				return $choices;
			}
		} // end private function get_locations

		private function get_cities($city) {

			global $wpdb;

			// ACF key of ctiy field
			$field_key = "field_62b31cb801c61";
			$field = get_field_object($field_key);

			if( $field )
			{
				$tags = get_tags(array(
					'taxonomy' => 'location_tag',
					'orderby' => 'name'
				));
				
				if( $tags ) {
					$choices = array('' => '-- Choose a City. --');
					foreach( $tags as $tag ) {
						$choices[$tag->slug] = $tag->name;
					}
				}
				else {
					$choices = array('' => '-- No location for that city. Please use the link above "Add New Location" to create a location and switch city to get it listed. --');
				}
			}

			return $choices;
	} // end private function get_cities

	} // end class my_acf_extension

?>
