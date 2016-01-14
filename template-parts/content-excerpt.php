<?php
/**
 * Template part for displaying post excerpts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package DPD_2015
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php

	/**
	 * The tha_entry_top action hook
	 */
	do_action( 'tha_entry_top' );

	?><header class="entry-header justcontent"><?php

		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

		if ( 'post' == get_post_type() ) :

			?><div class="entry-meta"><?php

				dpd_2015_posted_on();

			?></div><!-- .entry-meta --><?php

		endif;

	?></header><!-- .entry-header --><?php

	/**
	 * The tha_entry_content_before action hook
	 */
	do_action( 'tha_entry_content_before' );

	?><div class="entry-content"><?php

			the_excerpt();

	?></div><!-- .entry-content --><?php

	/**
	 * The tha_entry_content_after action hook
	 */
	do_action( 'tha_entry_content_after' );

	?><footer class="entry-footer"><?php

		dpd_2015_entry_footer();

	?></footer><!-- .entry-footer --><?php

	/**
	 * The tha_entry_bottom action hook
	 */
	do_action( 'tha_entry_bottom' );

?></article><!-- #post-## -->