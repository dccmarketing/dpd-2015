<?php
/**
 * Template Name: Home page
 *
 * Description: The home page template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package DPD_2015
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php

			/**
			 * The tha_content_while_before action hook
			 */
			do_action( 'tha_content_while_before' );

			while ( have_posts() ) : the_post();

				/**
				 * The tha_entry_before action hook
				 */
				do_action( 'tha_entry_before' );

				get_template_part( 'template-parts/content', 'page' );

				/**
				 * The tha_entry_after action hook
				 *
				 * @hooked 		comments_section 		10
				 */
				do_action( 'tha_entry_after' );

			endwhile; // End of the loop.

			/**
			 * The tha_content_while_after action hook
			 */
			do_action( 'tha_content_while_after' );

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_sidebar();
get_footer();