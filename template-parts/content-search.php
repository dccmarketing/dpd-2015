<?php
/**
 * Template part for displaying results in search pages.
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

	?><header class="page-header contentsearch"><?php

		/**
		 * The entry_header action hook
		 *
		 * @hooked 		content_entry_title 		10
		 * @hooked 		content_entry_meta 			15
		 */
		do_action( 'entry_header' );

	?></header><!-- .entry-header --><?php

	/**
	 * The tha_entry_content_before action hook
	 */
	do_action( 'tha_entry_content_before' );

	?><div class="entry-summary"><?php

		the_excerpt();

	?></div><!-- .entry-summary --><?php

	/**
	 * The tha_entry_content_after action hook
	 *
	 * @hooked 		entry_footer
	 */
	do_action( 'tha_entry_content_after' );

	/**
	 * The tha_entry_bottom action hook
	 */
	do_action( 'tha_entry_bottom' );

?></article><!-- #post-## -->