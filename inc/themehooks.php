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
		add_action( 'dpd_2015_header_content', array( $this, 'menu_primary' ), 25 );

		add_action( 'tha_body_top', array( $this, 'analytics_code' ) );
		add_action( 'tha_body_top', array( $this, 'add_hidden_search' ) );

		add_action( 'dpd_2015_wrap_content', array( $this, 'breadcrumbs' ) );

		add_action( 'tha_content_bottom', array( $this, 'site_info_and_copyright' ), 10 );
		add_action( 'tha_content_bottom', array( $this, 'menu_quick_links' ), 15 );

		add_action( 'tha_entry_after', array( $this, 'comments_section' ), 10 );

	} // loader()

	/**
	 * Adds a hidden search field
	 *
	 * @hooked 		tha_body_top
	 *
	 * @return 		mixed 			The HTML markup for a search field
	 */
	public function add_hidden_search() {

		?><div aria-hidden="true" class="hidden-search-top" id="hidden-search-top">
			<div class="wrap"><?php

			get_search_form();

			?></div>
		</div><?php

	} // add_hidden_search()

	/**
	 * Inserts Google Tag manager code after body tag
	 * @return 	mixed 		The inserted Google Tag Manager code
	 */
	public function analytics_code() {

		$tag = get_theme_mod( 'tag_manager' );

		if ( ! empty( $tag ) ) {

			echo $tag;

		}

	} // analytics_code()

	/**
	 * Returns the appropriate breadcrumbs.
	 *
	 * @hooked		dpd_2015_wrap_content
	 *
	 * @return 		mixed 				WooCommerce breadcrumbs, then Yoast breadcrumbs
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

					echo woocommerce_breadcrumb( $args );

				} elseif ( function_exists( 'yoast_breadcrumb' ) ) {

					echo yoast_breadcrumb();

				}

			?></div><!-- .wrap-crumbs -->
		</div><!-- .breadcrumbs --><?php

	} // breadcrumbs()

	/**
	 * Adds the comments section after an entry.
	 *
	 * If comments are open or we have at least one comment, load up the comment template.
	 *
	 * @hooked 		tha_entry_after 		10
	 * @return 		mixed 					The comments section
	 */
	public function comments_section() {

		if ( is_archive()
			|| is_home()
			|| is_search()
			|| ! comments_open()
			|| get_comments_number() <= 0
		) { return; }

		comments_template();

	} // comments_section

	public function header_button() {

		?><button class="topmenu-toggle" aria-controls="top-header-menu" aria-expanded="false"><?php esc_html_e( 'Site Links', 'dpd-2015' ); ?></button><?php

	} // header_button()

	/**
	 * Adds the email subscription form to the header
	 *
	 * @hooked 		dpd_2015_header_content		20
	 *
	 * @return 		mixed 						Email subscription form
	 */
	public function header_email_subscription() {

		//

	} // header_email_subscription()

	/**
	 * Adds the search form to the header
	 *
	 * @hooked 		dpd_2015_header_content		15
	 *
	 * @return 		mixed 						Search form
	 */
	public function header_search() {

		get_search_form();

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

		$logo = $dpd_2015_themekit->get_customizer_media_info( 'site_logo', 'full' );

		?><div class="site-branding"><?php

		if ( is_front_page() && is_home() ) {

			?><h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo ); ?>"></a></h1><?php

		} else {

			?><p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo ); ?>"></a></p><?php

		}

		?></div><!-- .site-branding --><?php

	} // header_site_branding()

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
			$menu['container_class'] 	= 'menu homepage-buttons';
			$menu['depth'] 				= 1;
			$menu['fallback_cb'] 		= '';
			$menu['menu_id'] 			= 'menu-homepage-buttons-items';
			$menu['menu_class'] 		= 'menu-items';
			$args['theme_location'] 	= 'homepage-buttons';

			wp_nav_menu( $args );

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

		?><nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'dpd-2015' ); ?></button><?php

				$args['menu_id'] 		= 'primary-menu';
				$args['theme_location'] = 'primary';

				wp_nav_menu( $args );

		?></nav><!-- #site-navigation --><?php

	} // menu_primary()

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

		$menu['theme_location']		= 'quick-links';
		$menu['container'] 			= 'div';
		$menu['container_id'] 		= 'menu-quick-links';
		$menu['container_class'] 	= 'menu nav-quick-links';
		$menu['menu_id'] 			= 'menu-quick-links-items';
		$menu['menu_class'] 		= 'menu-items';
		$menu['depth'] 				= 1;
		$menu['fallback_cb'] 		= '';

		?><h2><?php esc_html_e( 'Quick Links', 'dpd-2015' ); ?></h2><?php

		wp_nav_menu( $menu );

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
	 * Returns the featured for the page.
	 *
	 * @hooked 		tha_header_after 		15
	 *
	 * @return 		mixed 					The featured image
	 */
	public function page_featured_image() {

		return;

	} // page_featured_image()

	/**
	 * Returns the site info and copyright
	 *
	 * @hooked		tha_content_bottom 		10
	 *
	 * @return 		mixed 					The site info and copyright
	 */
	public function site_info_and_copyright() {

		if ( ! is_front_page() ) { return; }

		?><div class="site-info">
				<div class="copyright">&copy <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url(), 'dpd-2015' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></div>
				<div class="credits"><?php printf( esc_html__( 'Site created by %1$s', 'dpd-2015' ), '<a href="https://dccmarketing.com/" rel="nofollow" target="_blank">DCC Marketing</a>' ); ?></div>
			</div><!-- .site-info -->
		</div><!-- .wrap-footer --><?php

	} // site_info_and_copyright()

} // class

/**
 * Make an instance so its ready to be used
 */
$dpd_2015_themehooks = new dpd_2015_Themehooks();
