<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

// Actions after theme activation
add_action( 'admin_init', 'us_theme_activation', 99 );
function us_theme_activation() {
	global $pagenow;
	if ( is_admin() AND $pagenow == 'themes.php' AND isset( $_GET['activated'] ) ) {
		// Set menu
		$user = wp_get_current_user();
		update_user_option( $user->ID, US_THEMENAME . '_cpt_in_menu_set', FALSE, TRUE );

		// Redirect to About the Theme page
		header( 'Location: ' . admin_url( 'admin.php?page=us-setup-wizard' ) );
	}
}

// Hide some our metaboxes on Menus admin page
add_action( 'admin_head', 'us_include_cpt_to_menu', 99 );
function us_include_cpt_to_menu() {
	global $pagenow;
	if ( is_admin() AND $pagenow == 'nav-menus.php' ) {
		$already_set = get_user_option( US_THEMENAME . '_cpt_in_menu_set' );

		if ( ! $already_set ) {
			$hidden_meta_boxes = get_user_option( 'metaboxhidden_nav-menus' );

			if ( ! is_array( $hidden_meta_boxes ) ) {
				$hidden_meta_boxes = array();
			}

			if ( $hidden_meta_boxes !== FALSE ) {
				if ( ( $key = array_search( 'add-post-type-us_portfolio', $hidden_meta_boxes ) ) !== FALSE AND isset( $hidden_meta_boxes[ $key ] ) ) {
					unset( $hidden_meta_boxes[ $key ] );
				}
				if ( ( $key = array_search( 'add-us_portfolio_category', $hidden_meta_boxes ) ) === FALSE ) {
					$hidden_meta_boxes[] = 'add-us_portfolio_category';
				}
				if ( ( $key = array_search( 'add-us_portfolio_tag', $hidden_meta_boxes ) ) === FALSE ) {
					$hidden_meta_boxes[] = 'add-us_portfolio_tag';
				}

				$user = wp_get_current_user();
				update_user_option( $user->ID, 'metaboxhidden_nav-menus', $hidden_meta_boxes, TRUE );
				update_user_option( $user->ID, US_THEMENAME . '_cpt_in_menu_set', TRUE, TRUE );
			}
		}
	}
}

/*
 * Custom CSS for admin pages
 */
if ( ! function_exists( 'us_admin_print_styles' ) ) {
	add_action( 'admin_print_styles', 'us_admin_print_styles', 12 );
	function us_admin_print_styles() {
		if ( defined( 'US_CORE_VERSION' ) ) {

			// Enqueue admin CSS files separately, when US_DEV is set
			if ( defined( 'US_DEV' ) ) {
				foreach ( us_config( 'assets-admin.css', array() ) as $key => $admin_css_file ) {
					wp_enqueue_style( 'us-dev-' . $key, US_CORE_URI . $admin_css_file, array(), US_CORE_VERSION );
				}
			} else {
				wp_enqueue_style( 'us-core-admin', US_CORE_URI . '/admin/css/us-admin.min.css', array(), US_CORE_VERSION );
			}
		}

		global $us_template_directory_uri, $pagenow;

		// List of allowed backend pages for theme styles and fonts
		$allowed_pages = array(
			'us-theme-options',
			'us-home',
			'us-setup-wizard',
			'us-addons',
		);

		$allowed_pagenow = array(
			'post.php',
			'post-new.php',
			'nav-menus.php',
			'term.php',
		);
		
		if (
			in_array( $pagenow, $allowed_pagenow )
			OR (
				isset( $_GET['page'] )
				AND in_array( $_GET['page'], $allowed_pages )
			)
		) {
			wp_enqueue_style( 'us-theme-admin', $us_template_directory_uri . '/common/admin/css/theme-admin.css', array(), US_THEMEVERSION );
			wp_enqueue_style( 'us-font-awesome', $us_template_directory_uri . '/common/css/base/fontawesome.css', array(), US_THEMEVERSION );
			wp_enqueue_style( 'us-font-awesome-duotone', $us_template_directory_uri . '/common/css/base/fontawesome-duotone.css', array(), US_THEMEVERSION );
			wp_enqueue_style( 'us-setup-wizard', $us_template_directory_uri . '/common/admin/css/setup-wizard.css', array(), US_THEMEVERSION );

			// Init setup-wizard js
			wp_enqueue_script( 'us-setup-wizard', $us_template_directory_uri . '/common/admin/js/setup-wizard.js', array(), US_THEMEVERSION, true );
		}

		do_action( 'us_theme_icon' );
	}
}

// Enqueue in footer to override WPBakery builder admin styles
if ( ! function_exists( 'us_admin_print_styles_footer' ) ) {
	add_action( 'admin_footer', 'us_admin_print_styles_footer', 12 );
	function us_admin_print_styles_footer() {
		if ( defined( 'US_CORE_VERSION' ) ) {
			wp_enqueue_style( 'us-admin-js-composer', US_CORE_URI . '/admin/css/us-admin-js-composer.css', array(), US_CORE_VERSION );
		}
	}
}

/*
 * Custom Icon for admin menu
 */
if ( ! function_exists( 'us_theme_icon' ) ) {
	add_action( 'us_theme_icon', 'us_theme_icon', 10 );
	function us_theme_icon() {
		if (
			defined( 'US_CORE_VERSION' )
			AND us_get_option( 'white_label' )
			AND $icon_id = us_get_option( 'white_label_theme_icon' )
		) {
			$img_url = wp_get_attachment_image_url( $icon_id, 'thumbnail' );
		}

		// If image is not set, use the default icon
		if ( empty( $img_url ) ) {
			global $us_template_directory_uri;
			$img_url = $us_template_directory_uri . '/img/us-core.png';
		}
		?>
		<style>
			.us-wizard-templates.for_colors .us-wizard-step-description span::before,
			.us-wizard-templates.for_fonts .us-wizard-step-description span::before,
			.menu-icon-generic.toplevel_page_us-theme-options .wp-menu-image,
			.menu-icon-generic.toplevel_page_us-home .wp-menu-image {
				background: url(<?php echo esc_url( $img_url ) ?>) no-repeat center 6px / 22px auto !important;
				}
			.menu-icon-generic.toplevel_page_us-theme-options .wp-menu-image:before,
			.menu-icon-generic.toplevel_page_us-home .wp-menu-image:before {
				display: none;
				}
			<?php if ( empty( $icon_id ) ) : ?>
			#toplevel_page_edit-post_type-us_header.wp-has-submenu .wp-menu-image:before {
				color: #24d5b1 !important;
				}
			<?php endif ?>
		</style>
		<?php
	}
}
