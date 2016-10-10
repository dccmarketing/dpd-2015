<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DPD_2015
 */

			/**
			 * The tha_content_bottom action hook
			 */
			do_action( 'tha_content_bottom' );

			/**
			 * The tha_footer_before action hook
			 */
			do_action( 'tha_footer_before' );

			?><footer id="colophon" class="site-footer" role="contentinfo"><?php

				/**
				 * The tha_footer_top action hook
				 */
				do_action( 'tha_footer_top' );

				?><div class="wrap wrap-footer"><?php

					/**
					 * The dpd_2015_footer_content action hook
					 */
					do_action( 'dpd_2015_footer_content' );

				?></div><!-- .wrap-footer --><?php

				/**
				 * The tha_footer_bottom action hook
				 */
				do_action( 'tha_footer_bottom' );

			?></footer><!-- #colophon --><?php

		/**
		 * The tha_content_after action hook
		 */
		do_action( 'tha_content_after' );

	?></div><!-- #content --><?php

	/**
	 * The tha_footer_after action hook
	 */
	do_action( 'tha_footer_after' );

?></div><!-- #page --><?php

wp_footer();

/**
 * The tha_body_bottom action hook
 */
do_action( 'tha_body_bottom' );

?></body>
</html>