<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DocBlock
 */

		?></div><!-- .wrap --><?php

		do_action( 'tha_content_bottom' );

	?></div><!-- #content --><?php

	do_action( 'tha_content_after' );

	do_action( 'after_content' );

	do_action( 'tha_footer_before' );

	?><footer id="colophon" class="site-footer" role="contentinfo"><?php

		do_action( 'tha_footer_top' );

		?><div class="wrap wrap-footer">
			<div class="site-info">
				<div class="copyright">&copy <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url(), 'text-domain' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></div>
				<div class="credits"><?php printf( esc_html__( 'Site created by %1$s', 'text-domain' ), '<a href="https://dccmarketing.com/" target="_blank">DCC Marketing</a>' ); ?></div>
			</div><!-- .site-info -->
		</div><!-- .wrap-footer --><?php

		do_action( 'tha_footer_bottom' );

	?></footer><!-- #colophon --><?php

	do_action( 'tha_footer_after' );

?></div><!-- #page --><?php

wp_footer();

do_action( 'tha_body_bottom' );

?></body>
</html>