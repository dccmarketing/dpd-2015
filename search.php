<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package DPD_2015
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php

		if ( have_posts() ) :

			?><header class="page-header">
				<h1 class="page-title"><?php

					printf( esc_html__( 'Search Results for: %s', 'dpd-2015' ), '<span>' . get_search_query() . '</span>' );

				?></h1>
			</header><!-- .page-header --><?php

			/**
			 * The tha_content_while_before action hook
			 */
			do_action( 'tha_content_while_before' );

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * The tha_entry_before action hook
				 */
				do_action( 'tha_entry_before' );

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

				/**
				 * The tha_entry_after action hook
				 *
				 * @hooked 		comments_section 		10
				 */
				do_action( 'tha_entry_after' );

			endwhile;

			/**
			 * The tha_content_while_after action hook
			 */
			do_action( 'tha_content_while_after' );

			the_posts_navigation();

		else :

			/**
			 * The tha_entry_before action hook
			 */
			do_action( 'tha_entry_before' );

			get_template_part( 'template-parts/content', 'none' );

			/**
			 * The tha_entry_after action hook
			 *
			 * @hooked 		comments_section 		10
			 */
			do_action( 'tha_entry_after' );

		endif;

		?></main><!-- #main -->
	</section><!-- #primary --><?php

get_sidebar();
get_footer();