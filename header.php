<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DPD_2015
 */

/**
 * The tha_html_before action hook
 */
do_action( 'tha_html_before' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head><?php

/**
 * The tha_head_top action hook
 */
do_action( 'tha_head_top' );

?><meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php

wp_head();

/**
 * The tha_head_bottom action hook
 */
do_action( 'tha_head_bottom' );

?></head>

<body <?php body_class(); ?>><?php

/**
 * The tha_body_top action hook
 *
 * @hooked 		analytics_code
 * @hooked 		add_hidden_search
 */
do_action( 'tha_body_top' );

	?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'dpd-2015' ); ?></a>
	<div id="page" class="site">
		<div class="header-top" id="header-top">
			<div class="wrap wrap-topheader"><?php

			/**
			 * The tha_header_before action hook
			 *
			 * @hooked 		menu_top_header 	10
			 * @hooked 		menu_social 		15
			 */
			do_action( 'tha_header_before' );

			?></div>
		</div>
		<header id="masthead" class="site-header" role="banner"><?php

			/**
			 * The tha_header_top action hook
			 */
			do_action( 'tha_header_top' );

			?><div class="wrap wrap-header"><?php

				/**
				 * The dpd_2015_header_content action hook
				 *
				 * @hooked 		header_site_branding 		10
				 * @hooked 		header_search 				15
				 * @hooked 		header_email_subscription 	20
				 */
				do_action( 'dpd_2015_header_content' );

			?></div><!-- .header_wrap --><?php

			/**
			 * The tha_header_bottom action hook
			 *
			 * @hooked 		menu_primary 				10
			 */
			do_action( 'tha_header_bottom' );

		?></header><!-- #masthead --><?php

		/**
		 * The tha_header_after action hook
		 *
		 * @hooked 		homepage_slider 		10
		 * @hooked 		page_featured_image 	15
		 * @hooked 		menu_homepage_buttons 	20
		 */
		do_action( 'tha_header_after' );

		/**
		 * The tha_content_before action hook
		 */
		do_action( 'tha_content_before' );

		?><div id="content" class="site-content"><?php

			/**
			 * The tha_content_top action hook
			 *
			 * @hooked 		content_top_bg 			10
			 * @hooked 		program_links 			12
			 * @hooked 		content_top_wrap 		15
			 */
			do_action( 'tha_content_top' );

				/**
				 * The dpd_2015_wrap_content action hook
				 *
				 * @hooked 		breadcrumbs
				 */
				do_action( 'dpd_2015_wrap_content' );
