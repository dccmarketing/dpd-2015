<?php
/**
 * Template used for displaying page content in page.php
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

	/**
	 * The tha_entry_content_before action hook
	 */
	do_action( 'tha_entry_content_before' );

	?><div class="page-content"><?php

		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dpd-2015' ),
			'after'  => '</div>',
		) );

	?></div><!-- .entry-content --><?php

	/**
	 * The tha_entry_content_after action hook
	 *
	 * @hooked 			page_entry_footer
	 */
	do_action( 'tha_entry_content_after' );

	/**
	 * The tha_entry_bottom action hook
	 */
	do_action( 'tha_entry_bottom' );

?></article><!-- #post-## -->