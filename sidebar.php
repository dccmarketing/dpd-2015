<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DPD_2015
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) { return; }

do_action( 'tha_sidebars_before' );

?><aside id="secondary" class="widget-area" role="complementary"><?php

	do_action( 'tha_sidebar_top' );

	dynamic_sidebar( 'sidebar-1' );

	do_action( 'tha_sidebar_bottom' );

?></aside><!-- #secondary --><?php

do_action( 'tha_sidebars_after' );