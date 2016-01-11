<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DocBlock
 */

do_action( 'tha_html_before' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head><?php

do_action( 'tha_head_top' );

?><meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php

wp_head();

do_action( 'tha_head_bottom' );

?></head>

<body <?php body_class(); ?>><?php

do_action( 'tha_body_top' );

	?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'dpd-2015' ); ?></a>
	<div id="page" class="site"><?php

	do_action( 'tha_header_before' );

	?><header id="masthead" class="site-header" role="banner"><?php

		do_action( 'tha_header_top' );

		?><div class="wrap wrap-header">
			<div class="site-branding"><?php

			if ( is_front_page() && is_home() ) {

				?><h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1><?php

			} else {

				?><p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p><?php

			}

			$description = get_bloginfo( 'description', 'display' );

			if ( $description || is_customize_preview() ) {

				?><p class="site-description"><?php $description; /* WPCS: xss ok. */ ?></p><?php

			}

			?></div><!-- .site-branding --><?php

			get_template_part( 'menus/menu', 'primary' );

		?></div><!-- .header_wrap --><?php

		do_action( 'tha_header_bottom' );

	?></header><!-- #masthead --><?php

	do_action( 'tha_header_after' );

	do_action( 'tha_content_before' );

	?><div id="content" class="site-content"><?php

		do_action( 'tha_content_top' );

		?><div class="wrap wrap-content">
			<div class="breadcrumbs">
				<div class="wrap-crumbs"><?php

					do_action( 'dpd_2015_breadcrumbs' );

				?></div><!-- .wrap-crumbs -->
			</div><!-- .breadcrumbs -->