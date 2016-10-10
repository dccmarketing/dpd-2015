<?php
/**
 * Template part for displaying posts.
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

	?><div class="entry-content"><?php

			/* translators: %s: Name of current post */
			the_content( sprintf(
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'dpd-2015' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dpd-2015' ),
				'after'  => '</div>',
			) );

	?></div><!-- .entry-content --><?php

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