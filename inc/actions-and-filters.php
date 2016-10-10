<?php

/**
 * A class of helpful theme functions
 *
 * @package DPD_2015
 * @author Slushman <chris@slushman.com>
 */
class dpd_2015_Actions_and_Filters {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	}

	/**
	 * Loads all filter and action calls
	 *
	 * @return [type] [description]
	 */
	private function loader() {

		add_action( 'init', array( $this, 'disable_emojis' ) );
		add_action( 'after_setup_theme', array( $this, 'more_setup' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'more_scripts_and_styles' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'login_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts_and_styles' ) );
		add_filter( 'post_mime_types', array( $this, 'add_mime_types' ) );
		add_filter( 'upload_mimes', array( $this, 'custom_upload_mimes' ) );
		add_filter( 'body_class', array( $this, 'page_body_classes' ) );
		add_action( 'wp_head', array( $this, 'background_images' ) );
		add_action( 'wp_head', array( $this, 'featured_images' ) );
		add_action( 'wp_head', array( $this, 'programs_menu_images' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_read_more' ) );
		add_filter( 'mce_buttons_2', array( $this, 'add_editor_buttons' ) );
		add_filter( 'wpseo_breadcrumb_single_link', array( $this, 'unlink_private_pages' ), 10, 2 );
		add_filter( 'wp_seo_get_bc_title', array( $this, 'remove_private' ) );
		add_filter( 'manage_page_posts_columns', array( $this, 'page_template_column_head' ), 10 );
		add_action( 'manage_page_posts_custom_column', array( $this, 'page_template_column_content' ), 10, 2 );
		add_filter( 'get_search_form', array( $this, 'make_search_button_a_button' ) );
		add_filter( 'style_loader_src', array( $this, 'remove_cssjs_ver' ), 10, 2 );
		add_filter( 'script_loader_src', array( $this, 'remove_cssjs_ver' ), 10, 2 );
		add_filter( 'embed_oembed_html', array( $this, 'youtube_add_id_attribute' ), 99, 4 );
		add_action( 'wp_enqueue_scripts', array( $this, 'deregister_styles_and_scripts' ), 999 );
		add_filter( 'sm_category-text', array( $this, 'change_simplemap_category_text' ), 99, 1 );
		add_filter( 'sm_tag-text', array( $this, 'change_simplemap_tag_text' ), 99, 1 );
		add_filter( 'sm-search-label-search', array( $this, 'change_simplemap_search_btn_text' ), 99, 1 );
		add_shortcode( 'biketrails', array( $this, 'bike_trails' ) );

	} // loader()

	/**
	 * Removes and deregisters stylesheets and scripts from the system.
	 */
	public function deregister_styles_and_scripts() {

		wp_dequeue_style( 'rpt' );
		wp_deregister_style( 'rpt' );

	} // deregister_styles_and_scripts()

	/**
	 * Additional theme setup
	 * @return 	void
	 */
	public function more_setup() {

		register_nav_menus( array(
			'social' => esc_html__( 'Social Links', 'dpd-2015' )
		) );

		add_theme_support( 'yoast-seo-breadcrumbs' );

	} // more_setup()

	/**
	 * Enqueues scripts and styles for the admin
	 */
	public function admin_scripts_and_styles( $hook ) {

		wp_enqueue_style( 'dpd-2015-admin', get_stylesheet_directory_uri() . '/admin.css' );

	} // admin_scripts_and_styles()

	/**
	 * Enqueues additional scripts and styles
	 *
	 * @return 	void
	 */
	public function more_scripts_and_styles() {

		wp_enqueue_style( 'dashicons' );
		wp_enqueue_script( 'enquire', '//cdnjs.cloudflare.com/ajax/libs/enquire.js/2.1.2/enquire.min.js', array(), '20150804', true );
		wp_enqueue_script( 'dpd-2015-public', get_template_directory_uri() . '/assets/js/public.min.js', array( 'jquery', 'enquire' ), '20161010', true );
		wp_enqueue_style( 'dpd-2015-fonts', $this->fonts_url(), array(), null );

	} // more_scripts_and_styles()

	/**
	 * Enqueues scripts and styles for the login page
	 *
	 * @return 	void
	 */
	function login_scripts() {

		wp_enqueue_style( 'dpd-2015-login', get_stylesheet_directory_uri() . '/login.css', 10, 2 );

	} // login_scripts()




	/**
	 * Add core editor buttons that are disabled by default
	 */
	function add_editor_buttons( $buttons ) {

		$buttons[] = 'superscript';
		$buttons[] = 'subscript';

		return $buttons;

	} // add_editor_buttons()

	/**
	 * Adds PDF as a filter for the Media Library
	 *
	 * @param 	array 		$post_mime_types 		The current MIME types
	 * @return 	array 								The modified MIME types
	 */
	public function add_mime_types( $post_mime_types ) {

	    $post_mime_types['application/pdf'] = array( esc_html__( 'PDFs', 'dpd-2015' ), esc_html__( 'Manage PDFs', 'dpd-2015' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
	    $post_mime_types['text/x-vcard'] = array( esc_html__( 'vCards', 'dpd-2015' ), esc_html__( 'Manage vCards', 'dpd-2015' ), _n_noop( 'vCard <span class="count">(%s)</span>', 'vCards <span class="count">(%s)</span>' ) );

	    return $post_mime_types;

	} // add_mime_types

	/**
	 * Creates a style tag in the header with the background image
	 *
	 * @return 		mixed 		HTML style markup
	 */
	public function background_images() {

		global $dpd_2015_themekit;

		$image = $dpd_2015_themekit->get_customizer_media_info( 'site_bg_image', array( 'full' ) );

		if ( empty( $image ) ) { return; }

		?><style>
			@media screen and (min-width:768px){
				.site-content{background-image:url(<?php echo esc_url( $image ); ?>);
			}
		</style><!-- Background Images --><?php

	} // background_images()

	/**
	 * Displays the interactive bike trails map
	 *
	 * @return 		mixed 		HTML markup
	 */
	public function bike_trails() {

		?><div class="biketrails">
			<img id="bike_r1_c1" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r1_c1.jpg" name="bike_r1_c1" />
			<img id="bike_r2_c1" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r2_c1.jpg" name="bike_r2_c1" />
			<a class="fancybox-youtube" href="http://youtu.be/UXnqTPG-LoA" id="bike_r2_c3"><img id="bike_r2_c3" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r2_c3.jpg" name="bike_r2_c3" /></a>
			<img id="bike_r2_c5" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r2_c5.jpg" name="bike_r2_c5" />
			<a class="fancybox-youtube" href="http://youtu.be/VEAPEaC7cfk" id="bike_r3_c3"><img id="bike_r3_c3" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r3_c3.jpg" name="bike_r3_c3" /></a>
			<img id="bike_r3_c4" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r3_c4.jpg" name="bike_r3_c4" />
			<a class="fancybox-youtube" href="http://youtu.be/Zx9hzbllHxI" id="bike_r4_c3"><img id="bike_r4_c3" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r4_c3.jpg" name="bike_r4_c3" /></a>
			<img id="bike_r5_c1" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r5_c1.jpg" name="bike_r5_c1" />
			<a class="fancybox-youtube" href="http://youtu.be/R5GwuzouELk" id="bike_r5_c2"><img id="bike_r5_c2" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r5_c2.jpg" name="bike_r5_c2" /></a>
			<a class="fancybox-youtube" href="http://youtu.be/Idm0xE-M3s8" id="bike_r5_c3"><img id="bike_r5_c3" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r5_c3.jpg" name="bike_r5_c3" /></a>
			<a class="fancybox-youtube" href="http://youtu.be/0nn-TkDNgPY" id="bike_r6_c5"><img id="bike_r6_c5" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r6_c5.jpg" name="bike_r6_c5" /></a>
			<img id="bike_r6_c6" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r6_c6.jpg" name="bike_r6_c6" />
			<img id="bike_r7_c3" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r7_c3.jpg" name="bike_r7_c3" />
			<img id="bike_r8_c5" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r8_c5.jpg" name="bike_r8_c5" />
			<img id="bike_r9_c2" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/biketrails/bike_r9_c2.jpg" name="bike_r9_c2" />
		</div><?php

	} // bike_trails()

	/**
	 * Changes the category label on the search form.
	 *
	 * @param 		string 		$label 		The current singular text
	 *
	 * @return 		string 					The modified singular text
	 */
	public function change_simplemap_category_text( $label ) {

		return __( 'Type ', 'dpd-2015' );

	} // change_simplemap_category_text()

	/**
	 * Changes the submit button label on the search form.
	 *
	 * @param 		string 		$label 		The current button text
	 *
	 * @return 		string 					The modified button text
	 */
	public function change_simplemap_search_btn_text( $label ) {

		return __( 'Filter Results', 'dpd-2015' );

	} // change_simplemap_search_btn_text()

	/**
	 * Changes the tag label on the search form.
	 *
	 * @param 		string 		$label 		The current singular text
	 *
	 * @return 		string 					The modified singular text
	 */
	public function change_simplemap_tag_text( $label ) {

		return __( 'Amenties ', 'dpd-2015' );

	} // change_simplemap_tag_text()

	/**
	 * Adds support for additional MIME types to WordPress
	 *
	 * @param 		array 		$existing_mimes 			The existing MIME types
	 * @return 		array 									The modified MIME types
	 */
	public function custom_upload_mimes( $existing_mimes = array() ) {

		// add your extension to the array
		$existing_mimes['vcf'] = 'text/x-vcard';

		return $existing_mimes;

	} // custom_upload_mimes()

	/**
	 * Removes WordPress emoji support everywhere
	 */
	function disable_emojis() {

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	} // disable_emojis()

	/**
	 * Limits excerpt length
	 *
	 * @param 	int 		$length 			The current word length of the excerpt
	 * @return 	int 							The word length of the excerpt
	 */
	public function excerpt_length( $length ) {

		if ( is_home() || is_front_page() ) {

			return 30;

		}

		return $length;

	} // excerpt_length()

	/**
	 * Customizes the "Read More" text for excerpts
	 *
	 * @global   			$post 		The post object
	 * @param 	mixed 		$more 		The current "read more"
	 * @return 	mixed 					The modifed "read more"
	 */
	public function excerpt_read_more( $more ) {

		global $post;

		$return = sprintf( '... <a class="moretag read-more" href="%s">', esc_url( get_permalink( $post->ID ) ) );
		$return .= esc_html__( 'See more', 'dpd-2015' );
		$return .= '<span class="screen-reader-text">';
		$return .= sprintf( esc_html__( ' about %s', 'dpd-2015' ), $post->post_title );
		$return .= '</span></a>';

		return $return;

	} // excerpt_read_more()

	/**
	 * Adds style tag for featured images to pages.
	 *
	 * @return 		mixed 		HTML style markup
	 */
	public function featured_images() {

		if ( ! is_page() || is_front_page() ) { return; }

		global $dpd_2015_themekit;

		$output = '';
		$image 	= $dpd_2015_themekit->get_thumbnail_url( get_the_ID(), 'full' );

		if ( ! $image ) {

			$image = $dpd_2015_themekit->get_customizer_media_info( 'site_feat_image', array( 'full' ) );

		}

		if ( empty( $image ) ) { return; }

		?><style>
			@media screen and (min-width:768px){
				.feat-img{background-image:url(<?php echo esc_url( $image ); ?>);
			}
		</style><!-- Featured Images --><?php

	} // featured_images()

	/**
	 * Properly encode a font URLs to enqueue a Google font
	 *
	 * @return 	mixed 		A properly formatted, translated URL for a Google font
	 */
	public function fonts_url() {

		$return 	= '';
		$families 	= '';
		$fonts[] 	= array( 'font' => 'Lato', 'weights' => '400,700,300,700italic,900italic', 'translate' => esc_html_x( 'on', 'Lato font: on or off', 'dpd-2015' ) );

		foreach ( $fonts as $font ) {

			if ( 'off' == $font['translate'] ) { continue; }

			$families[] = $font['font'] . ':' . $font['weights'];

		}

		if ( ! empty( $families ) ) {

			$query_args['family'] 	= urlencode( implode( '|', $families ) );
			$query_args['subset'] 	= urlencode( 'latin' );
			$return 				= add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		}

		return $return;

	} // fonts_url()

	/**
	 * Converts the search input button to an HTML5 button element
	 *
	 * @hook 		get_search_form
	 *
	 * @param 		mixed  		$form 			The current form HTML
	 * @return 		mixed 						The modified form HTML
	 */
	public function make_search_button_a_button( $form ) {

		$form = '<form action="' . esc_url( home_url( '/' ) ) . '" class="search-form" method="get" role="search" >
				<label class="screen-reader-text" for="site-search">' . _x( 'Search for:', 'label' ) . '</label>
				<input class="search-field" id="site-search" name="s" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" title="' . esc_attr_x( 'Search for:', 'label' ) . '" type="search" value="' . get_search_query() . '"  />
				<button type="submit" class="search-submit">
					<span class="screen-reader-text">'. esc_attr_x( 'Search', 'submit button' ) .'</span>
					<span class="dashicons dashicons-search"></span>
				</button>
			</form>';

		return $form;

	} // make_search_button_a_button()

	/**
	 * Adds classes to the body tag.
	 *
	 * @global 	$post						The $post object
	 * @param 	array 		$classes 		Classes for the body element.
	 * @return 	array 						The modified body class array
	 */
	public function page_body_classes( $classes ) {

		global $post;

		if ( empty( $post->post_content ) ) {

			$classes[] = 'content-none';

		} else {

			$classes[] = $post->post_name;

		}

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {

			$classes[] = 'group-blog';

		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {

			$classes[] = 'hfeed';

		}

		return $classes;

	} // page_body_classes()

	/**
	 * The content for each column cell
	 *
	 * @return 	mixed 		The cell content
	 */
	public function page_template_column_content( $column_name, $post_ID ) {

		if ( 'page_template' !== $column_name ) { return; }

		$slug 		= get_page_template_slug( $post_ID );
		$templates 	= get_page_templates();
		$name 		= array_search( $slug, $templates );

		if ( ! empty( $name ) ) {

			echo '<span class="name-template">' . $name . '</span>';

		} else {

			echo '<span class="name-template">' . esc_html( 'Default', 'dpd-2015' ) . '</span>';

		}

	} // page_template_column_content()

	/**
	 * Adds the page template column to the columns on the page listings
	 *
	 * @param 	array 		$defaults 			The current column names
	 * @return 	array           				The modified column names
	 */
	public function page_template_column_head( $defaults ) {

		$defaults['page_template'] = esc_html( 'Page Template', 'dpd-2015' );

	    return $defaults;

	} // page_template_column_head()

	/**
	 * Adds style tag for programs menu item background images.
	 *
	 * @return 		mixed 		HTML style markup
	 */
	public function programs_menu_images() {

		if ( ! is_front_page() ) { return; }

		if ( is_multisite() && ! is_main_site() ) {

			switch_to_blog(1);

		}

		$menu_items = wp_get_nav_menu_items( 'programs-menu' );

		if ( empty( $menu_items ) ) { return; }

		?><style><?php

		foreach ( $menu_items as $menu_item ) {

			$bgID = get_post_meta( $menu_item->ID, 'menu-item-bg-img', true );

			if ( empty( $bgID ) && ! is_int( $bgID ) ) { continue; }

			$imgURL = wp_get_attachment_url( $bgID );

			echo '.nav-programs li.' . $menu_item->classes[1] . '{background-image:url(' . esc_url( $imgURL ) . ');}';

		}

		?></style><!-- Program Menu BGs --><?php

		restore_current_blog();

	} // programs_menu_images()

	/**
	 * Removes query strings from static resources
	 * to increase Pingdom and GTMatrix scores.
	 *
	 * Does not remove query strings from Google Font calls.
	 *
	 * @param 	string 		$src 			The resource URL
	 * @return 	string 						The modifed resource URL
	 */
	function remove_cssjs_ver( $src ) {

		if ( empty( $src ) ) { return; }
		if ( strpos( $src, 'https://fonts.googleapis.com' ) ) { return; }

		if ( strpos( $src, '?ver=' ) ) {

			$src = remove_query_arg( 'ver', $src );

		}

		return $src;

	} // remove_cssjs_ver()

	/**
	 * Removes the "Private" text from the private pages in the breadcrumbs
	 *
	 * @param 	string 		$text 			The breadcrumb text
	 * @return 	string 						The modified breadcrumb text
	 */
	public function remove_private( $text ) {

		$check = stripos( $text, 'Private: ' );

		if ( is_int( $check ) ) {

			$text = str_replace( 'Private: ', '', $text );

		}

		return $text;

	} // remove_private()

	/**
	 * Unlinks breadcrumbs that are private pages
	 *
	 * @param 	mixed 		$output 		The HTML output for the breadcrumb
	 * @param 	array 		$link 			Array of link info
	 * @return 	mixed 						The modified link output
	 */
	public function unlink_private_pages( $output, $link ) {

		if ( ! isset( $link['url'] ) || empty( $link['url'] ) ) { return $output; }

		$id 		= url_to_postid( $link['url'] );
		$options 	= WPSEO_Options::get_all();

		if ( $options['breadcrumbs-home'] !== $link['text'] && 0 === $id ) {

			$output = '<span rel="v:child" typeof="v:Breadcrumb">' . $link['text'] . '</span>';

		}

		return $output;

	} // unlink_private_pages()

	/**
	 * Adds the video ID as the ID attribute on the iframe
	 *
	 * @param 		string 		$html 			The current oembed HTML
	 * @param 		string 		$url 			The oembed URL
	 * @param 		array 		$attr 			The oembed attributes
	 * @param 		int 		$post_id 		The post ID
	 * @return 		string 						The modified oembed HTML
	 */
	public function youtube_add_id_attribute( $html, $url, $attr, $post_id ) {

		$check = strpos( $url, 'youtu' );

		if ( ! $check ) { return $html; }

		if ( strpos( $url, 'watch?v=' ) > 0 ) {

			$id = explode( 'watch?v=', $url );

		} else {

			$id = explode( '.be/', $url );

		}

		$html = str_replace( 'allowfullscreen>', 'allowfullscreen id="video-' . $id[1] . '">', $html );

		return $html;

	} // youtube_add_id_attribute

} // class

/**
 * Make an instance so its ready to be used
 */
$dpd_2015_actions_and_filters = new dpd_2015_Actions_and_Filters();
