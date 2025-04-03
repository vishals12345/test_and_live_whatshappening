<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template Name: Custom Test
 * The template for displaying pages
 *
 * Do not overload this file directly. Instead have a look at templates/single.php file in us-core plugin folder:
 * you should find all the needed hooks there.
 */


	acf_form_head();
	get_header();
	?>
	<main id="page-content" class="l-main">
		<section class="l-section">
			<div class="l-section-h i-cf">

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'content' );
			?>
			<section class="l-section">
			<?php
			if (is_user_logged_in() && ( current_user_can('member') || current_user_can('administrator') )) {

					$current_user_id = get_current_user_id();
					acf_form([
						'field_groups' => [154],
						'updated_message' => __("Post updated", 'acf')
					]);
			}
			?>
			</section>
			<?php
		}
		?>
	</div>
</section>
	</main>
	<?php
	get_footer();
?>
