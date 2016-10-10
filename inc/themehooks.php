<?php

/**
 * A class of methods using hooks in the theme.
 *
 * @package DPD_2015
 * @author Slushman <chris@slushman.com>
 */
class dpd_2015_Themehooks {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	}

	/**
	 * Loads all filter and action calls
	 */
	private function loader() {

		add_action( 'tha_header_before', array( $this, 'menu_top_header' ), 10 );
		add_action( 'tha_header_before', array( $this, 'menu_social' ), 15 );
		add_action( 'tha_header_before', array( $this, 'header_button' ), 20 );

		add_action( 'tha_header_after', array( $this, 'homepage_slider' ), 10 );
		add_action( 'tha_header_after', array( $this, 'page_featured_image' ), 15 );
		add_action( 'tha_header_after', array( $this, 'menu_homepage_buttons' ), 20 );

		add_action( 'dpd_2015_header_content', array( $this, 'header_site_branding' ), 10 );
		add_action( 'dpd_2015_header_content', array( $this, 'header_search' ), 15 );
		add_action( 'dpd_2015_header_content', array( $this, 'header_email_subscription' ), 20 );

		add_action( 'tha_header_bottom', array( $this, 'menu_primary' ), 10 );

		add_action( 'tha_body_top', array( $this, 'analytics_code' ), 10 );

		add_action( 'dpd_2015_wrap_content', array( $this, 'breadcrumbs' ) );

		add_action( 'tha_content_while_before', array( $this, 'archive_page_title' ) );
		add_action( 'tha_content_while_before', array( $this, 'index_page_title' ) );
		add_action( 'tha_content_while_before', array( $this, 'search_page_title' ) );

		add_action( 'tha_content_while_after', array( $this, 'posts_nav' ) );

		add_action( 'tha_content_top', array( $this, 'content_top_bg' ), 10 );
		add_action( 'tha_content_top', array( $this, 'menu_programs' ), 12 );
		add_action( 'tha_content_top', array( $this, 'content_top_wrap' ), 15 );

		add_action( 'tha_content_bottom', array( $this, 'content_bottom' ) );
		add_action( 'tha_content_bottom', array( $this, 'content_after' ) );

		add_action( 'tha_entry_before', array( $this, 'home_events' ), 10 );
		add_action( 'tha_entry_before', array( $this, 'home_news' ), 15 );
		add_action( 'tha_entry_before', array( $this, 'site_info_and_copyright' ), 20 );
		add_action( 'tha_entry_before', array( $this, 'menu_quick_links' ), 25 );

		add_action( 'tha_entry_top', array( $this, 'page_title' ) );
		add_action( 'tha_entry_top', array( $this, 'none_found_title' ) );

		add_action( 'entry_header', array( $this, 'content_entry_title' ), 10 );
		add_action( 'entry_header', array( $this, 'content_entry_meta' ), 15 );

		add_action( 'tha_entry_content_after', array( $this, 'entry_footer' ) );
		add_action( 'tha_entry_content_after', array( $this, 'page_entry_footer' ) );

		add_action( 'tha_entry_after', array( $this, 'posts_nav' ), 10 );
		add_action( 'tha_entry_after', array( $this, 'comments_section' ), 20 );

		add_action( 'dpd_2015_footer_content', array( $this, 'footer_logo' ), 10 );

		add_action( 'dpd_2015_404_before', array( $this, 'four_04_title' ), 10 );

		add_action( 'dpd_2015_404_content', array( $this, 'add_search' ), 10 );
		add_action( 'dpd_2015_404_content', array( $this, 'four_04_posts_widget' ), 15 );
		add_action( 'dpd_2015_404_content', array( $this, 'four_04_categories' ), 20 );
		add_action( 'dpd_2015_404_content', array( $this, 'four_04_archives' ), 25 );
		add_action( 'dpd_2015_404_content', array( $this, 'four_04_tag_cloud' ), 30 );

		add_filter( 'dpd-2015-board-events', array( $this, 'board_events' ), 10, 2 );

	} // loader()

	/**
	 * Adds a search form
	 *
	 * @hooked 		dpd_2015_404_content 		15
	 *
	 * @return 		mixed 		Search form markup
	 */
	public function add_search() {

		get_search_form();

	} // add_search()

	/**
	 * Inserts Google Tag manager code after body tag
	 *
	 * @hooked 		tha_body_top 		10
	 *
	 * @return 		mixed 				The inserted Google Tag Manager code
	 */
	public function analytics_code() {

		$tag = get_theme_mod( 'tag_manager' );

		if ( ! empty( $tag ) ) {

			echo '<!-- Google Tag Manager -->';
			echo $tag;
			echo '<!-- Google Tag Manager -->';

		}

	} // analytics_code()

	/**
	 * Adds the page title to an archive page
	 *
	 * @return 		mixed 			The archive page title
	 */
	public function archive_page_title() {

		if ( ! is_archive() ) { return; }

		?><header class="page-header"><?php

			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );

		?></header><!-- .page-header --><?php

	} // archive_page_title()

	/**
	 * Adds the board events custom event display
	 *
	 * @param 		array 		$events 	Event objects
	 * @param 		array 		$args 		Shortcode args
	 *
	 * @return 		mixed 					Event output
	 */
	public function board_events( $events, $args ) {

		?><section class="events-section"><?php

			if ( empty( $events ) ) :

				?><p class="no-events-msg"><?php

					esc_html_e( $args['message'], 'dpd-2015' );

				?></p><?php

			else :

				global $post;

				?><div class="event-header">
					<span><?php esc_html_e( 'Meeting Date', 'dpd-2015' ); ?></span>
					<span><?php esc_html_e( 'Agenda', 'dpd-2015' ); ?></span>
					<span><?php esc_html_e( 'Minutes', 'dpd-2015' ); ?></span>
				</div>
				<ul class="events"><?php

				foreach ( $events as $post ) {

					setup_postdata( $post );

					$fields = get_fields( $post->ID );

					?><li class="event">
						<span class="event-title"><?php the_title(); ?></span><?php

						if ( ! empty( $fields['agenda'] ) ) {

							?><a class="event-agenda" href="<?php echo esc_url( $fields['agenda'] ); ?>"><?php esc_html_e( 'Agenda', 'dpd-2015' ); ?></a><?php

						}

						if ( ! empty( $fields['minutes'] ) ) {

							?><a class="event-minutes" href="<?php echo esc_url( $fields['minutes'] ); ?>"><?php esc_html_e( 'Minutes', 'dpd-2015' ); ?></a><?php

						}

					?></li><?php

				} // foreach

				wp_reset_postdata();

				?></ul><?php

			endif;

		?></section><?php

	} // board_events()

	/**
	 * Returns the appropriate breadcrumbs.
	 *
	 * @hooked		dpd_2015_wrap_content
	 *
	 * @return 		mixed 						WooCommerce breadcrumbs, then Yoast breadcrumbs
	 */
	public function breadcrumbs() {

		if ( is_front_page() ) { return; }

		?><div class="breadcrumbs">
			<div class="wrap-crumbs"><?php

				if ( function_exists( 'woocommerce_breadcrumb' ) ) {

					$args['after'] 			= '</span>';
					$args['before'] 		= '<span rel="v:child" typeof="v:Breadcrumb">';
					$args['delimiter'] 		= '&nbsp;>&nbsp;';
					$args['home'] 			= esc_html_x( 'Home', 'breadcrumb', 'dpd-2015' );
					$args['wrap_after'] 	= '</span></span></nav>';
					$args['wrap_before'] 	= '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '><span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb">';

					woocommerce_breadcrumb( $args );

				} elseif ( function_exists( 'yoast_breadcrumb' ) ) {

					yoast_breadcrumb();

				}

			?></div><!-- .wrap-crumbs -->
		</div><!-- .breadcrumbs --><?php

	} // breadcrumbs()

	/**
	 * Adds the comments section after an entry.
	 *
	 * If comments are open or we have at least one comment, load up the comment template.
	 *
	 * @hooked 		tha_entry_after 		20
	 *
	 * @return 		mixed 					The comments section
	 */
	public function comments_section() {

		if ( is_archive()
			|| is_home()
			|| is_search()
			|| ! is_single()
			|| ! comments_open()
			|| get_comments_number() <= 0
		) { return; }

		comments_template();

	} // comments_section()

	/**
	 * Adds the closing wrap-content tag
	 *
	 * @hooked 			tha_content_bottom
	 *
	 * @return 			mixed 					HTML markup
	 */
	public function content_bottom() {

		?></div ><!-- .wrap-content --><?php

	} // content_bottom()

	/**
	 * Adds markup just below the content
	 *
	 * @hooked 		tha_content_after
	 *
	 * @return 		mixed 		HTML markup
	 */
	public function content_after() {

		?></div><!-- .content-bg --><?php

	} // content_after()

	/**
	 * Adds the entry meta to the entry header
	 *
	 * @return 		mixed 			The entry meta
	 */
	public function content_entry_meta() {

		if ( 'post' != get_post_type()
			|| is_search()
			|| ! is_single()
		) { return; }

		?><div class="entry-meta"><?php

			dpd_2015_posted_on();

		?></div><!-- .entry-meta --><?php

	} // content_entry_meta()

	/**
	 * Adds the entry title to the entry header
	 *
	 * @return 		mixed 			The entry title
	 */
	public function content_entry_title() {

		if ( is_single() ) {

			the_title( '<h1 class="entry-title">', '</h1>' );

		} else {

			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		}

	} // content_entry_title()

	/**
	 * Adds markup just above the content
	 *
	 * @hooked 		tha_content_top
	 *
	 * @return 		mixed 		HTML markup
	 */
	public function content_top_bg() {

		?><div class="content-bg"><?php

	} // content_top_bg()

	/**
	 * Adds markup just above the content
	 *
	 * @hooked 		tha_content_top
	 *
	 * @return 		mixed 		HTML markup
	 */
	public function content_top_wrap() {

		?><div class="wrap wrap-content"><?php

	} // content_top_wrap()

	/**
	 * Adds the entry footer
	 *
	 * @return 		mixed 			The entry footer
	 */
	public function entry_footer() {

		if ( 'post' != get_post_type()
			|| is_search()
			|| ! is_single()
		) { return; }

		?><footer class="entry-footer"><?php

			dpd_2015_entry_footer();

		?></footer><!-- .entry-footer --><?php

	} // entry_footer()

	/**
	 * Adds the footer logo
	 *
	 * @hooked 			dpd_2015_footer_content
	 *
	 * @return  		mixed 						The footer logo markup
	 */
	public function footer_logo() {

		global $dpd_2015_themekit;

		$logo = $dpd_2015_themekit->get_customizer_media_info( 'footer_logo' );

		if ( empty( $logo ) ) { return; }

		foreach ( array( 'medium', 'full' ) as $size ) {

			if ( array_key_exists( $size, $logo['sizes'] ) ) {

				$image = $logo['sizes'][$size]['url'];
				break;

			}

		}

		?><img alt="<?php esc_attr_e( $logo['alt'], 'dpd-2015' ); ?>" class="footer-logo" src="<?php echo esc_url( $image ); ?>"><?php

	} // footer_logo()

	/**
	 * Adds the  to the 404 page content.
	 *
	 * @hooked 		dpd_2015_404_content		25
	 *
	 * @return 		mixed 							Markup for the archives
	 */
	public function four_04_archives() {

		/* translators: %1$s: smiley */
		$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'dpd-2015' ), convert_smilies( ':)' ) ) . '</p>';

		the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

	} // four_04_archives()

	/**
	 * Adds the  to the 404 page content.
	 *
	 * @hooked 		dpd_2015_404_content		20
	 *
	 * @return 		mixed 							The categories widget
	 */
	public function four_04_categories() {

		if ( ! dpd_2015_categorized_blog() ) { return; }

		?><div class="widget widget_categories">
			<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'dpd-2015' ); ?></h2>
			<ul><?php

				wp_list_categories( array(
					'orderby'    => 'count',
					'order'      => 'DESC',
					'show_count' => 1,
					'title_li'   => '',
					'number'     => 10,
				) );

			?></ul>
		</div><!-- .widget --><?php

	} // four_04_categories()

	/**
	 * Adds the Recent Posts widget to the 404 page.
	 *
	 * @hooked 		dpd_2015_404_content 		15
	 *
	 * @return 		mixed 							The Recent Posts widget
	 */
	public function four_04_posts_widget() {

		the_widget( 'WP_Widget_Recent_Posts' );

	} // four_04_posts_widget()

	/**
	 * Adds the  to the 404 page content.
	 *
	 * @hooked 		dpd_2015_404_content		30
	 *
	 * @return 		mixed 							The tag cloud widget
	 */
	public function four_04_tag_cloud() {

		the_widget( 'WP_Widget_Tag_Cloud' );

	} // four_04_tag_cloud()

	/**
	 * The 404 page title markup
	 *
	 * @hooked 		dpd_2015_404_content 		10
	 *
	 * @return 		mixed 							The 440 page title
	 */
	public function four_04_title() {

		if ( ! is_404() ) { return; }

		?><header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'dpd-2015' ); ?></h1>
		</header><!-- .page-header -->
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'dpd-2015' ); ?></p><?php

	} // four_04_title()

 	/**
 	 * Displays the Top Menu "Site Links" button on mobile
 	 *
 	 * @hooked  		tha_header_before			20
 	 *
 	 * @return 			mixed 						The mobile toggle button markup
 	 */
	public function header_button() {

		?><button class="topmenu-toggle" aria-controls="top-header-menu" aria-expanded="false"><span class="dashicons dashicons-menu"></span><?php esc_html_e( 'Site Links', 'dpd-2015' ); ?></button><?php

	} // header_button()

	/**
	 * Adds the email subscription form to the header
	 *
	 * @hooked 		dpd_2015_header_content		20
	 *
	 * @return 		mixed 						Email subscription form
	 */
	public function header_email_subscription() {

		?><div class="email-form">
			<span class="email-subscription-label"><?php

				esc_html_e( get_theme_mod( 'email_subscription_label' ), 'dpd-2015' );

			?></span>
			<form class="cc-header" name="ccoptin" action="http://visitor.constantcontact.com/d.jsp" target="_blank" method="post">
				<input type="text" name="ea" id="frm_signup" />
				<input type="hidden" name="m" value="1102243239112">
				<input type="hidden" name="p" value="oi">
			</form>
		</div><?php

	} // header_email_subscription()

	/**
	 * Adds the search form to the header
	 *
	 * @hooked 		dpd_2015_header_content		15
	 *
	 * @return 		mixed 						Search form
	 */
	public function header_search() {

		?><div class="header-search"><?php

		get_search_form();

		?></div><?php

	} // header_search()

	/**
	 * Adds the site branding to the header
	 *
	 * @hooked 		dpd_2015_header_content		10
	 *
	 * @return 		mixed 						Site branding
	 */
	public function header_site_branding() {

		global $dpd_2015_themekit;

		$logo = $dpd_2015_themekit->get_customizer_media_info( 'site_logo', array( 'full' ) );

		?><div class="site-branding"><?php

		if ( is_front_page() && is_home() ) {

			?><h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo ); ?>"></a></h1><?php

		} else {

			?><p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo ); ?>"></a></p><?php

		}

		?></div><!-- .site-branding --><?php

	} // header_site_branding()

	/**
	 * Adds event listings to the home page content area
	 *
	 * @hooked 		home_content 		10
	 *
	 * @return 		mixed 				Event listings
	 */
	public function home_events() {

		if ( ! is_front_page() ) { return; }
		if ( ! function_exists( 'tribe_get_events' ) ) { return; }

		$event_args['posts_per_page'] 	= 5;
		$event_args['start_date'] 		= current_time( 'Y-m-d' );
		$siteevents 					= tribe_get_events( $event_args );

		if ( ! is_main_site() && empty( $siteevents ) ) {

			switch_to_blog(1);

			$events = tribe_get_events( $event_args );

		} else {

			$events = $siteevents;

		}

		?><section class="events-section">
			<h2 id="home-events-heading"><?php esc_html_e( get_theme_mod( 'events_heading' ), 'dpd-2015'); ?></h2><?php

			if ( empty( $events ) ) :

				?><p class="no-events-msg"><?php

					esc_html_e( get_theme_mod( 'no_events_message' ), 'dpd-2015' );

				?></p><?php

			else :

				global $post;

				?><ul class="events"><?php

				foreach ( $events as $post ) {

					setup_postdata( $post );

					?><li class="event">
						<span class="dashicons dashicons-calendar-alt"></span>
						<span class="event-date"><?php echo tribe_get_start_date(); ?></span>
						<a class="event-title" href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
					</li><?php

				} // foreach

				wp_reset_postdata();

				?></ul><?php

			endif;

			?><p><?php

				if ( is_main_site() && empty( $siteevents ) ) {

					restore_current_blog();

				}

				?><a class="all-events-link" href="<?php echo esc_url( tribe_get_events_link() ); ?>"><?php esc_html_e( get_theme_mod( 'events_link_text' ), 'dpd-2015' ); ?></a><?php

				if ( ! is_main_site() ) {

					switch_to_blog(1);

					?><a class="dpd-events-link" href="<?php echo esc_url( tribe_get_events_link() ); ?>"><?php esc_html_e( 'View Park District Events', 'dpd-2015' ); ?></a><?php

					restore_current_blog();

				}

			?></p>
		</section><?php

	} // home_events()

	/**
	 * Adds news listings to the home page content area
	 *
	 * @hooked 		home_content 		15
	 *
	 * @return 		mixed 				News listings
	 */
	public function home_news() {

		if ( ! is_front_page() ) { return; }

		global $dpd_2015_themekit;

		$args['posts_per_page'] = 2;

		$sitenews = $dpd_2015_themekit->get_posts( 'post', $args, 'home' );

		if ( ! is_main_site() && empty( $sitenews ) ) {

			switch_to_blog(1);

			$news = $dpd_2015_themekit->get_posts( 'post', $args, 'home' );

		} else {

			$news = $sitenews;

		}

		global $post;

		?><section class="news-section">
			<h2 id="home-news-heading"><?php esc_html_e( get_theme_mod( 'news_heading' ), 'dpd-2015'); ?></h2><?php

			if ( empty( $news ) ) :

				?><p class="no-news-msg"><?php

					esc_html_e( get_theme_mod( 'no_news_message' ), 'dpd-2015' );

				?></p><?php

			else :

				?><ul class="news"><?php

				foreach ( $news->posts as $post ) {

					setup_postdata( $post );

					?><li class="news-post">
						<div class="news-date">
							<span class="news-month"><?php echo get_the_date( 'M' ); ?></span>
							<span class="news-day"><?php echo get_the_date( 'd' ); ?></span>
						</div>
						<div class="news-info">
							<p class="news-title">
								<a class="" href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
							</p>
							<p class="news-content"><?php echo get_the_excerpt(); ?></p>
						</div>
					</li><?php

				} // foreach

				wp_reset_postdata();

				?></ul><?php

			endif;

			?><p><?php

				if ( is_main_site() && empty( $sitenews ) ) {

					restore_current_blog();

				}

				?><a class="all-news-link" href="<?php echo esc_url( $dpd_2015_themekit->get_posts_page() ); ?>"><?php esc_html_e( get_theme_mod( 'news_link_text' ), 'dpd-2015' ); ?></a><?php

				if ( ! is_main_site() ) {

					switch_to_blog(1);

					?><a class="dpd-news-link" href="<?php echo esc_url( $dpd_2015_themekit->get_posts_page() ); ?>"><?php esc_html_e( 'View Park District News', 'dpd-2015' ); ?></a><?php

					restore_current_blog();

				}

			?></p>
		</section><?php

	} // home_news()

	/**
	 * Adds a slider to the homepage
	 *
	 * @hooked 		tha_header_after 		10
	 *
	 * @return 		mixed 					Soliloquy slider
	 */
	public function homepage_slider() {

		if ( ! is_front_page() ) { return; }

		if ( function_exists( 'soliloquy' ) ) { soliloquy( 'home', 'slug' ); }

	} // homepage_slider()

	/**
	 * Adds the page title to the index page
	 *
	 * @return 		mixed 			The index page title
	 */
	public function index_page_title() {

		if ( ! is_home() ) { return; }

		?><header>
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header><?php

	} // index_page_title()

	/**
	 * Adds the homepage buttons menu
	 *
	 * @hooked 		tha_header_after 		20
	 *
	 * @return 		mixed 					The homepage buttons menu
	 */
	public function menu_homepage_buttons() {

		if ( ! is_front_page() ) { return; }
		if ( ! has_nav_menu( 'homepage-buttons' ) ) { return; }

		?><nav id="homepage-buttons-menu" class="homepage-buttons-menu" role="navigation"><?php

			$menu['container'] 			= 'div';
			$menu['container_id'] 		= 'menu-homepage-buttons';
			$menu['container_class'] 	= 'menu homepage-buttons wrap';
			$menu['depth'] 				= 1;
			$menu['fallback_cb'] 		= '';
			$menu['menu_id'] 			= 'menu-homepage-buttons-items';
			$menu['menu_class'] 		= 'menu-items';
			$menu['theme_location'] 	= 'homepage-buttons';

			wp_nav_menu( $menu );

		?></nav><!-- homepage-buttons-menu --><?php

	} // menu_homepage_buttons()

	/**
	 * Adds the main menu to the header
	 *
	 * @hooked 		dpd_2015_header_content		25
	 *
	 * @return 		mixed 						Main nav menu
	 */
	public function menu_primary() {

		if ( ! has_nav_menu( 'primary' ) ) { return; }

		?><nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="dashicons dashicons-menu"></span><?php esc_html_e( 'Main Menu', 'dpd-2015' );
			?></button><?php

				$args['menu_id'] 		= 'primary-menu';
				$args['theme_location'] = 'primary';
				$args['walker']  		= new Main_Menu_Walker();

				wp_nav_menu( $args );

		?></nav><!-- #site-navigation --><?php

	} // menu_primary()

	/**
	 * Adds the program links just inside the content wrapper on the home page.
	 *
	 * @hooked 		dpd_2015_wrap_content			10
	 *
	 * @return 		mixed 							The programs menu
	 */
	public function menu_programs() {

		if ( ! is_front_page() ) { return; }
		if ( ! has_nav_menu( 'programs' ) ) { return; }

		$menu['theme_location']		= 'programs';
		$menu['container'] 			= 'div';
		$menu['container_id'] 		= 'menu-programs';
		$menu['container_class'] 	= 'menu nav-programs';
		$menu['menu_id'] 			= 'menu-programs-items';
		$menu['menu_class'] 		= 'menu-items';
		$menu['depth'] 				= 1;
		$menu['fallback_cb'] 		= '';

		wp_nav_menu( $menu );

	} // menu_programs()

	/**
	 * Returns the quick links menu
	 *
	 * @hooked		tha_content_bottom 		15
	 *
	 * @return 		mixed 					The quick links menu
	 */
	public function menu_quick_links() {

		if ( ! is_front_page() ) { return; }
		if ( ! has_nav_menu( 'quick-links' ) ) { return; }

		?><section class="quick-links-section">
			<h2 id="quick-links-heading"><?php esc_html_e( get_theme_mod( 'quick_links_heading' ), 'dpd-2015' ); ?></h2><?php

			$menu['theme_location']		= 'quick-links';
			$menu['container'] 			= 'div';
			$menu['container_id'] 		= 'menu-quick-links';
			$menu['container_class'] 	= 'menu nav-quick-links';
			$menu['menu_id'] 			= 'menu-quick-links-items';
			$menu['menu_class'] 		= 'menu-items';
			$menu['depth'] 				= 1;
			$menu['fallback_cb'] 		= '';

			wp_nav_menu( $menu );

		?></section><?php

	} // menu_quick_links()

	/**
	 * Adds the Social Links Menu
	 *
	 * @hooked 		tha_header_before 		15
	 *
	 * @return 		mixed 					The social link menu
	 */
	public function menu_social() {

		if ( ! has_nav_menu( 'social' ) ) { return; }

		$menu['theme_location']		= 'social';
		$menu['container'] 			= 'div';
		$menu['container_id'] 		= 'menu-social-media';
		$menu['container_class'] 	= 'menu nav-social';
		$menu['menu_id'] 			= 'menu-social-media-items';
		$menu['menu_class'] 		= 'menu-items';
		$menu['depth'] 				= 1;
		$menu['fallback_cb'] 		= '';

		wp_nav_menu( $menu );

	} // menu_social()

	/**
	 * Adds the Top Header Menu
	 *
	 * @hooked 		tha_header_before 		10
	 *
	 * @return 		mixed 					The top header menu
	 */
	public function menu_top_header() {

		if ( ! has_nav_menu( 'top-header' ) ) { return; }

		$menu['container'] 			= 'nav';
		$menu['container_id'] 		= 'top-header-menu';
		$menu['container_class'] 	= 'menu top-header-menu';
		$menu['depth'] 				= 1;
		$menu['fallback_cb'] 		= '';
		$menu['menu_id'] 			= 'menu-top-header-items';
		$menu['menu_class'] 		= 'menu-items';
		$menu['theme_location'] 	= 'top-header';

		wp_nav_menu( $menu );

	} // menu_top_header()

	/**
	 * Adds the page title for the none-found results
	 *
	 * @return [type] [description]
	 */
	public function none_found_title() {

		if ( in_the_loop() ) { return; }

		?><header class="page-header contentnone">
			<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'dpd-2015' ); ?></h1>
		</header><!-- .page-header --><?php

	} // none_found_title()

	/**
	 * Adds the entry footer for pages
	 *
	 * @return 		mixed 		Page entry footer
	 */
	public function page_entry_footer() {

		if ( ! is_page() ) { return; }

		?><footer class="entry-footer"><?php

			edit_post_link( esc_html__( 'Edit', 'dpd-2015' ), '<span class="edit-link">', '</span>' );

		?></footer><!-- .entry-footer --><?php

	} // page_entry_footer()

	/**
	 * Returns the featured for the page.
	 *
	 * @hooked 		tha_header_after 		15
	 *
	 * @return 		mixed 					The featured image
	 */
	public function page_featured_image() {

		if ( ! is_page() || is_front_page() ) { return; }

		global $dpd_2015_themekit;

		$ftimg = $dpd_2015_themekit->get_thumbnail_url( get_the_ID(), 'full' );

		if ( ! $ftimg ) {

			$ftimg = $dpd_2015_themekit->get_customizer_media_info( 'site_feat_image', array( 'full' ) );

		}

		if ( empty( $ftimg ) ) { return; }

		?><div class="feat-img"></div><?php

	} // page_featured_image()

	/**
	 * Adds the page title to a page
	 *
	 * @return 		mixed 		The page title
	 */
	public function page_title() {

		if ( ! is_page() ) { return; }

		?><header class="page-header contentpage"><?php

			the_title( '<h1 class="page-title">', '</h1>' );

		?></header><!-- .entry-header --><?php

	} // page_title()

	/**
	 * Adds the posts navigation
	 *
	 * @return 		mixed 			The posts navigation
	 */
	public function posts_nav() {

		if ( ! is_search()
			|| ! is_home()
			|| ! is_archive()
		) { return; }

		the_posts_navigation();

	} // posts_nav()

	/**
	 * Adds the page title to the search results archive page
	 *
	 * @return 		mixed 			The search results page title
	 */
	public function search_page_title() {

		if ( ! is_search() ) { return; }

		?><header class="page-header">
			<h1 class="page-title"><?php

				printf( esc_html__( 'Search Results for: %s', 'dpd-2015' ), '<span>' . get_search_query() . '</span>' );

			?></h1>
		</header><!-- .page-header --><?php

	} // search_page_title()

	/**
	 * Returns the site info and copyright
	 *
	 * @hooked		tha_content_bottom 		10
	 *
	 * @return 		mixed 					The site info and copyright
	 */
	public function site_info_and_copyright() {

		if ( ! is_front_page() ) { return; }

		global $dpd_2015_themekit;

		$heading = get_theme_mod( 'site_info_heading' );

		?><section class="site-copyright">
			<h2><?php esc_html_e( 'Site Copyright', 'dpd-2015' ); ?></h2>
			<div class="copyright">&copy <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url(), 'dpd-2015' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></div>
			<div class="line1">
				<ul><?php

					$addy1 = get_theme_mod( 'address_1' );

					if ( ! empty( $addy1 ) ) {

						?><li class="address1"><?php echo esc_html( $addy1, 'dpd-2015' ); ?></li><?php

					}

					$city 	= get_theme_mod( 'city' );
					$state 	= get_theme_mod( 'us_state' );
					$zip 	= get_theme_mod( 'zip_code' );

					if ( ! empty( $city ) && ! empty( $state ) && ! empty( $zip ) ) {

						?><li>
							<span class="city"><?php echo esc_html( $city, 'dpd-2015' ) . ', '; ?></span>
							<span class="state"><?php echo esc_html( $state, 'dpd-2015' ) . ' '; ?></span>
							<span class="zip"><?php echo esc_html( $zip, 'dpd-2015' ); ?></span>
						</li><?php

					}

				?></ul>
			</div>
			<div>
				<ul><?php

				$phone = get_theme_mod( 'phone_number' );

				if ( ! empty( $phone ) ) {

					?><li class="phone-number"><?php

						echo $dpd_2015_themekit->make_phone_link( $phone );

					?></li><?php

				}

				?></ul>
			</div>
			<div><?php

			$link = get_theme_mod( 'footer_page_link' );
			$text = get_theme_mod( 'footer_link_text' );

			if ( ! empty( $link ) && ! empty( $text ) ) {

				?><a class="footer-page-link" href="<?php echo esc_url( get_permalink( $link ) ); ?>"><?php esc_html_e( $text, 'dpd-2015' ); ?></a><?php

			}

			?></div>
			<div class="credits"><?php printf( esc_html__( 'Site designed and developed by %1$s', 'dpd-2015' ), '<a href="https://dccmarketing.com/" rel="nofollow" target="_blank">DCC Marketing</a>' ); ?></div>
		</section><!-- .site-info --><?php

	} // site_info_and_copyright()

} // class

/**
 * Make an instance so its ready to be used
 */
$dpd_2015_themehooks = new dpd_2015_Themehooks();