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

	?><header class="page-header contentpage"><?php

		the_title( '<h1 class="page-title">', '</h1>' );

	?></header><!-- .entry-header --><?php

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
	 */
	do_action( 'tha_entry_content_after' );

	?><footer class="entry-footer"><?php

		edit_post_link( esc_html__( 'Edit', 'dpd-2015' ), '<span class="edit-link">', '</span>' );

	?></footer><!-- .entry-footer --><?php

	/**
	 * The tha_entry_bottom action hook
	 */
	do_action( 'tha_entry_bottom' );

?></article><!-- #post-## -->