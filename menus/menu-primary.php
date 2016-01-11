<?php
/**
 * Template part for displaying post excerpts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package DocBlock
 */

?><nav id="site-navigation" class="main-navigation" role="navigation">
	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'dpd-2015' ); ?></button><?php

		$args['menu_id'] 		= 'primary-menu';
		$args['theme_location'] = 'primary';

		wp_nav_menu( $args );

?></nav><!-- #site-navigation -->