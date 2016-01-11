<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package DPD_2015
 */

get_header();

	?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php

		do_action( 'tha_content_while_before' );

		while ( have_posts() ) : the_post();

			do_action( 'tha_entry_before' );

			get_template_part( 'template-parts/content', get_post_format() );

			do_action( 'tha_entry_after' );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {

				comments_template();

			}

		endwhile; // End of the loop.

		do_action( 'tha_content_while_after' );

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_sidebar();
get_footer();