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

				/**
				 * The home_content action hook
				 *
				 * @hooked 		home_events						10
				 * @hooked 		home_news 						15
				 * @hooked 		site_info_and_copyright 		20
				 * @hooked 		menu_quick_links 				25
				 */
				do_action( 'dpd_2015_home_content' );

				/**
				 * The tha_entry_after action hook
				 */
				do_action( 'tha_entry_after' );

			endwhile; // End of the loop.

			/**
			 * The tha_content_while_after action hook
			 */
			do_action( 'tha_content_while_after' );

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();