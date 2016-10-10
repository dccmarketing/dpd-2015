<?php
/**
 * DPD 2015 Customizer
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @link 		https://codex.wordpress.org/Theme_Customization_API
 * @since 		1.0.0
 * @package  	DocBlock
 */

// Register panels, sections, and controls
add_action( 'customize_register', 'dpd_2015_register_panels' );
add_action( 'customize_register', 'dpd_2015_register_sections' );
add_action( 'customize_register', 'dpd_2015_register_fields' );

// Output custom CSS to live site
add_action( 'wp_head', 'dpd_2015_header_output' );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', 'dpd_2015_live_preview' );

/**
 * Registers custom panels for the Customizer
 *
 * @see			add_action( 'customize_register', $func )
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 */
function dpd_2015_register_panels( $wp_customize ) {

	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for DPD 2015', 'dpd-2015' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'dpd-2015' ),
		)
	);

	// Programs Menu Panel
	/*$wp_customize->add_panel( 'programs_menu',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Links to the subsites', 'dpd-2015' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Programs Menu', 'dpd-2015' ),
		)
	);*/

	/*
	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for DPD 2015', 'dpd-2015' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'dpd-2015' ),
		)
	);
	*/

} // dpd_2015_register_panels()

/**
 * Registers custom sections for the Customizer
 *
 * Existing sections:
 *
 * Slug 				Priority 		Title
 *
 * title_tagline 		20 				Site Identity
 * colors 				40				Colors
 * header_image 		60				Header Image
 * background_image 	80				Background Image
 * nav 					100 			Navigation
 * widgets 				110 			Widgets
 * static_front_page 	120 			Static Front Page
 * default 				160 			all others
 *
 * @see			add_action( 'customize_register', $func )
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 */
function dpd_2015_register_sections( $wp_customize ) {

	// Images Section
	$wp_customize->add_section( 'images_section',
		array(
			'capability' 	=> 'edit_theme_options',
			'description' 	=> esc_html__( 'Images for DPD 2015', 'dpd-2015' ),
			'panel' 		=> 'theme_options',
			'priority' 		=> 10,
			'title' 		=> esc_html__( 'Images', 'dpd-2015' )
		)
	);

	// Home Section
	$wp_customize->add_section( 'home_section',
		array(
			'capability' 	=> 'edit_theme_options',
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'panel' 		=> 'theme_options',
			'priority' 		=> 10,
			'title' 		=> esc_html__( 'Home Page', 'dpd-2015' )
		)
	);

	// Contact Info Section
	$wp_customize->add_section( 'contact_info',
		array(
			'capability' 	=> 'edit_theme_options',
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'panel' 		=> 'theme_options',
			'priority' 		=> 10,
			'title' 		=> esc_html__( 'Contact Info', 'dpd-2015' )
		)
	);



	/*$menus = dpd_2015_programs_menu();

	foreach ( $menus as $menu ) {

		$title = str_replace( '_', ' ', $menu );

		// Contact Info Section
		$wp_customize->add_section( $menu,
			array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'panel' 		=> 'programs_menu',
				'priority' 		=> 10,
				'title' 		=> esc_html__( ucwords( $title ), 'dpd-2015' )
			)
		);

	} // foreach*/


	/*
	// New Section
	$wp_customize->add_section( 'new_section',
		array(
			'capability' 	=> 'edit_theme_options',
			'description' 	=> esc_html__( 'New Customizer Section', 'dpd-2015' ),
			'panel' 		=> 'theme_options',
			'priority' 		=> 10,
			'title' 		=> esc_html__( 'New Section', 'dpd-2015' )
		)
	);
	*/

} // dpd_2015_register_sections()

/**
 * Registers controls/fields for the Customizer
 *
 * Note: To enable instant preview, we have to actually write a bit of custom
 * javascript. See live_preview() for more.
 *
 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
 * 		'transport' => 'postMessage'
 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
 *
 * @see			add_action( 'customize_register', $func )
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 */
function dpd_2015_register_fields( $wp_customize ) {

	// Enable live preview JS for default fields
	$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';



	// Site Identity Section Fields

	// Google Tag Manager Field
	$wp_customize->add_setting(
		'tag_manager',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'tag_manager',
		array(
			'description' 	=> esc_html__( 'Paste in the Google Tag Manager code here. Do not include the comment tags!', 'dpd-2015' ),
			'label' => esc_html__( 'Google Tag Manager', 'dpd-2015' ),
			'priority' => 90,
			'section' => 'title_tagline',
			'settings' => 'tag_manager',
			'type' => 'textarea'
		)
	);
	$wp_customize->get_setting( 'tag_manager' )->transport = 'postMessage';



	// Site Images Fields

	// Site Logo Field
	// Returns the image ID, not a URL
	$wp_customize->add_setting(
		'site_logo',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'site_logo',
			array(
				'description' 	=> esc_html__( 'Maximum size is 238px by 106px.', 'dpd-2015' ),
				'label' => esc_html__( 'Site logo', 'dpd-2015' ),
				'mime_type' => '',
				'priority' => 10,
				'section' => 'images_section',
				'settings' => 'site_logo'
			)
		)
	);
	$wp_customize->get_setting( 'site_logo' )->transport = 'postMessage';

	// Site Featured Image Field
	// Returns the image ID, not a URL
	$wp_customize->add_setting(
		'site_feat_image',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'site_feat_image',
			array(
				'description' 	=> esc_html__( 'Minimum size is 1200px by 200px. It can be taller, but you will only see the center 200px of the image.', 'dpd-2015' ),
				'label' => esc_html__( 'Site featured image', 'dpd-2015' ),
				'mime_type' => '',
				'priority' => 10,
				'section' => 'images_section',
				'settings' => 'site_feat_image'
			)
		)
	);
	$wp_customize->get_setting( 'site_feat_image' )->transport = 'postMessage';

	// Site BG Image Field
	// Returns the image ID, not a URL
	$wp_customize->add_setting(
		'site_bg_image',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'site_bg_image',
			array(
				'description' 	=> esc_html__( 'Minimum size is 1500px by 1100 px. Taller is better.', 'dpd-2015' ),
				'label' => esc_html__( 'Site background image', 'dpd-2015' ),
				'mime_type' => '',
				'priority' => 10,
				'section' => 'images_section',
				'settings' => 'site_bg_image'
			)
		)
	);
	$wp_customize->get_setting( 'site_bg_image' )->transport = 'postMessage';

	// Footer Logo Field
	// Returns the image ID, not a URL
	$wp_customize->add_setting(
		'footer_logo',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'footer_logo',
			array(
				'description' 	=> esc_html__( 'Maximum size is 300px by 300px.', 'dpd-2015' ),
				'label' => esc_html__( 'Footer logo', 'dpd-2015' ),
				'mime_type' => '',
				'priority' => 10,
				'section' => 'images_section',
				'settings' => 'footer_logo'
			)
		)
	);
	$wp_customize->get_setting( 'footer_logo' )->transport = 'postMessage';





	// Email Subscription Label Field
	$wp_customize->add_setting(
		'email_subscription_label',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'email_subscription_label',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Email Subscription Label', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'email_subscription_label',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'email_subscription_label' )->transport = 'postMessage';



	// Events Heading Field
	$wp_customize->add_setting(
		'events_heading',
		array(
			'default'  	=> 'Event Calendar',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'events_heading',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Events Heading', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'events_heading',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'events_heading' )->transport = 'postMessage';



	// No Events Message Field
	$wp_customize->add_setting(
		'no_events_message',
		array(
			'default'  	=> 'There are no upcoming events.',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'no_events_message',
		array(
			'description' 	=> esc_html__( 'This message displays on the homepage if there are no events on the calendar.', 'dpd-2015' ),
			'label'  	=> esc_html__( 'No Events Message', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'no_events_message',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'no_events_message' )->transport = 'postMessage';

	// Events Link Text Field
	$wp_customize->add_setting(
		'events_link_text',
		array(
			'default'  	=> 'View All Events',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'events_link_text',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Events Link Text', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'events_link_text',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'events_link_text' )->transport = 'postMessage';



	// News Heading Field
	$wp_customize->add_setting(
		'news_heading',
		array(
			'default'  	=> 'News',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'news_heading',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'News Heading', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'news_heading',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'news_heading' )->transport = 'postMessage';



	// No News Message Field
	$wp_customize->add_setting(
		'no_news_message',
		array(
			'default'  	=> 'There is no news at this time.',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'no_news_message',
		array(
			'description' 	=> esc_html__( 'This message displays on the homepage if there are no news posts.', 'dpd-2015' ),
			'label'  	=> esc_html__( 'No News Message', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'no_news_message',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'no_news_message' )->transport = 'postMessage';



	// News Link Text Field
	$wp_customize->add_setting(
		'news_link_text',
		array(
			'default'  	=> 'View All News',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'news_link_text',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'News Link Text', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'news_link_text',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'news_link_text' )->transport = 'postMessage';



	// Quick Links Heading Field
	$wp_customize->add_setting(
		'quick_links_heading',
		array(
			'default'  	=> 'Quick Links',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'quick_links_heading',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Quick Links Heading', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'quick_links_heading',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'quick_links_heading' )->transport = 'postMessage';

	// Footer Page Select Field
	// Returns a page ID
	$wp_customize->add_setting(
		'footer_page_link',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'footer_page_link',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Footer Link', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'home_section',
			'settings' => 'footer_page_link',
			'type' => 'dropdown-pages'
		)
	);
	$wp_customize->get_setting( 'footer_page_link' )->transport = 'postMessage';

	// Footer Link Text Field
	$wp_customize->add_setting(
		'footer_link_text',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'footer_link_text',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Footer Link Text', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'home_section',
			'settings' 	=> 'footer_link_text',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'footer_link_text' )->transport = 'postMessage';




	// Contact Info Section Fields

	// Address 1 Field
	$wp_customize->add_setting(
		'address_1',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'address_1',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Address Line 1', 'dpd-2015' ),
			'priority' => 200,
			'section'  	=> 'contact_info',
			'settings' 	=> 'address_1',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'address_1' )->transport = 'postMessage';

	// City Field
	$wp_customize->add_setting(
		'city',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'city',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'City', 'dpd-2015' ),
			'priority' => 220,
			'section'  	=> 'contact_info',
			'settings' 	=> 'city',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'city' )->transport = 'postMessage';

	// US States Select Field
	$wp_customize->add_setting(
		'us_state',
		array(
			'default'  	=> 'IL',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'us_state',
		array(
			'choices' => array(
				'AL' => esc_html__( 'Alabama', 'dpd-2015' ),
				'AK' => esc_html__( 'Alaska', 'dpd-2015' ),
				'AZ' => esc_html__( 'Arizona', 'dpd-2015' ),
				'AR' => esc_html__( 'Arkansas', 'dpd-2015' ),
				'CA' => esc_html__( 'California', 'dpd-2015' ),
				'CO' => esc_html__( 'Colorado', 'dpd-2015' ),
				'CT' => esc_html__( 'Connecticut', 'dpd-2015' ),
				'DE' => esc_html__( 'Delaware', 'dpd-2015' ),
				'DC' => esc_html__( 'District of Columbia', 'dpd-2015' ),
				'FL' => esc_html__( 'Florida', 'dpd-2015' ),
				'GA' => esc_html__( 'Georgia', 'dpd-2015' ),
				'HI' => esc_html__( 'Hawaii', 'dpd-2015' ),
				'ID' => esc_html__( 'Idaho', 'dpd-2015' ),
				'IL' => esc_html__( 'Illinois', 'dpd-2015' ),
				'IN' => esc_html__( 'Indiana', 'dpd-2015' ),
				'IA' => esc_html__( 'Iowa', 'dpd-2015' ),
				'KS' => esc_html__( 'Kansas', 'dpd-2015' ),
				'KY' => esc_html__( 'Kentucky', 'dpd-2015' ),
				'LA' => esc_html__( 'Louisiana', 'dpd-2015' ),
				'ME' => esc_html__( 'Maine', 'dpd-2015' ),
				'MD' => esc_html__( 'Maryland', 'dpd-2015' ),
				'MA' => esc_html__( 'Massachusetts', 'dpd-2015' ),
				'MI' => esc_html__( 'Michigan', 'dpd-2015' ),
				'MN' => esc_html__( 'Minnesota', 'dpd-2015' ),
				'MS' => esc_html__( 'Mississippi', 'dpd-2015' ),
				'MO' => esc_html__( 'Missouri', 'dpd-2015' ),
				'MT' => esc_html__( 'Montana', 'dpd-2015' ),
				'NE' => esc_html__( 'Nebraska', 'dpd-2015' ),
				'NV' => esc_html__( 'Nevada', 'dpd-2015' ),
				'NH' => esc_html__( 'New Hampshire', 'dpd-2015' ),
				'NJ' => esc_html__( 'New Jersey', 'dpd-2015' ),
				'NM' => esc_html__( 'New Mexico', 'dpd-2015' ),
				'NY' => esc_html__( 'New York', 'dpd-2015' ),
				'NC' => esc_html__( 'North Carolina', 'dpd-2015' ),
				'ND' => esc_html__( 'North Dakota', 'dpd-2015' ),
				'OH' => esc_html__( 'Ohio', 'dpd-2015' ),
				'OK' => esc_html__( 'Oklahoma', 'dpd-2015' ),
				'OR' => esc_html__( 'Oregon', 'dpd-2015' ),
				'PA' => esc_html__( 'Pennsylvania', 'dpd-2015' ),
				'RI' => esc_html__( 'Rhode Island', 'dpd-2015' ),
				'SC' => esc_html__( 'South Carolina', 'dpd-2015' ),
				'SD' => esc_html__( 'South Dakota', 'dpd-2015' ),
				'TN' => esc_html__( 'Tennessee', 'dpd-2015' ),
				'TX' => esc_html__( 'Texas', 'dpd-2015' ),
				'UT' => esc_html__( 'Utah', 'dpd-2015' ),
				'VT' => esc_html__( 'Vermont', 'dpd-2015' ),
				'VA' => esc_html__( 'Virginia', 'dpd-2015' ),
				'WA' => esc_html__( 'Washington', 'dpd-2015' ),
				'WV' => esc_html__( 'West Virginia', 'dpd-2015' ),
				'WI' => esc_html__( 'Wisconsin', 'dpd-2015' ),
				'WY' => esc_html__( 'Wyoming', 'dpd-2015' ),
				'AS' => esc_html__( 'American Samoa', 'dpd-2015' ),
				'AA' => esc_html__( 'Armed Forces America (except Canada)', 'dpd-2015' ),
				'AE' => esc_html__( 'Armed Forces Africa/Canada/Europe/Middle East', 'dpd-2015' ),
				'AP' => esc_html__( 'Armed Forces Pacific', 'dpd-2015' ),
				'FM' => esc_html__( 'Federated States of Micronesia', 'dpd-2015' ),
				'GU' => esc_html__( 'Guam', 'dpd-2015' ),
				'MH' => esc_html__( 'Marshall Islands', 'dpd-2015' ),
				'MP' => esc_html__( 'Northern Mariana Islands', 'dpd-2015' ),
				'PR' => esc_html__( 'Puerto Rico', 'dpd-2015' ),
				'PW' => esc_html__( 'Palau', 'dpd-2015' ),
				'VI' => esc_html__( 'Virgin Islands', 'dpd-2015' )
			),
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'State', 'dpd-2015' ),
			'priority' => 230,
			'section' => 'contact_info',
			'settings' => 'us_state',
			'type' => 'select'
		)
	);
	$wp_customize->get_setting( 'us_state' )->transport = 'postMessage';

	// Zip Code Field
	$wp_customize->add_setting(
		'zip_code',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'zip_code',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Zip Code', 'dpd-2015' ),
			'priority' => 240,
			'section'  	=> 'contact_info',
			'settings' 	=> 'zip_code',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'zip_code' )->transport = 'postMessage';

	// Phone Number Field
	$wp_customize->add_setting(
		'phone_number',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'phone_number',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Phone Number', 'dpd-2015' ),
			'priority' => 250,
			'section'  	=> 'contact_info',
			'settings' 	=> 'phone_number',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'phone_number' )->transport = 'postMessage';





	/*global $dpd_2015_themekit;
	$svgs 	= $dpd_2015_themekit->get_svg_list();
	$svgopt = array();
	$menus 	= dpd_2015_programs_menu();

	foreach ( $svgs as $key => $svg ) {

		$replaced = str_replace( '-', ' ', $key );

		$svgopt[$key] = ucwords( $replaced );

	} // foreach

	foreach ( $menus as $menu ) {

		// Label
		$wp_customize->add_setting(
			$menu . '_label',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			$menu . '_label',
			array(
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'label'  	=> esc_html__( 'Label', 'dpd-2015' ),
				'priority' => 10,
				'section'  	=> $menu,
				'settings' 	=> $menu . '_label',
				'type' 		=> 'text'
			)
		);
		$wp_customize->get_setting( $menu . '_label' )->transport = 'postMessage';



		// URL
		$wp_customize->add_setting(
			$menu . '_url',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			$menu . '_url',
			array(
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'label' => esc_html__( 'URL', 'dpd-2015' ),
				'priority' => 10,
				'section' => $menu,
				'settings' => $menu . '_url',
				'type' => 'url'
			)
		);
		$wp_customize->get_setting( $menu . '_url' )->transport = 'postMessage';



		// Icon
		$wp_customize->add_setting(
			$menu . '_icon',
			array(
				'default'  	=> 'choice1',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			$menu . '_icon',
			array(
				'choices' => $svgopt,
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'label' => esc_html__( 'Icon', 'dpd-2015' ),
				'priority' => 10,
				'section' => $menu,
				'settings' => $menu . '_icon',
				'type' => 'select'
			)
		);
		$wp_customize->get_setting( $menu . '_icon' )->transport = 'postMessage';



		// Background Image
		// Returns the image ID, not a URL
		$wp_customize->add_setting(
			$menu . '_bg_img',
			array(
				'default' => '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				$menu . '_bg_img',
				array(
					'description' 	=> esc_html__( '', 'dpd-2015' ),
					'label' => esc_html__( 'Background Image', 'dpd-2015' ),
					'mime_type' => '',
					'priority' => 10,
					'section' => $menu,
					'settings' => $menu . '_bg_img'
				)
			)
		);
		$wp_customize->get_setting( $menu . '_bg_img' )->transport = 'postMessage';



		// Background Color
		$wp_customize->add_setting(
			$menu . '_color',
			array(
				'default'  	=> '#020202',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$menu . '_color',
				array(
					'description' 	=> esc_html__( '', 'dpd-2015' ),
					'label' => esc_html__( 'Background Color', 'dpd-2015' ),
					'priority' => 10,
					'section' => $menu,
					'settings' => $menu . '_color'
				)
			)
		);
		$wp_customize->get_setting( $menu . '_color' )->transport = 'postMessage';

	} // foreach*/







	/*
	// Fields & Controls

	// Text Field
	$wp_customize->add_setting(
		'text_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'text_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label'  	=> esc_html__( 'Text Field', 'dpd-2015' ),
			'priority' => 10,
			'section'  	=> 'new_section',
			'settings' 	=> 'text_field',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'text_field' )->transport = 'postMessage';



	// URL Field
	$wp_customize->add_setting(
		'url_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'url_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'URL Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'url_field',
			'type' => 'url'
		)
	);
	$wp_customize->get_setting( 'url_field' )->transport = 'postMessage';



	// Email Field
	$wp_customize->add_setting(
		'email_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'email_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Email Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'email_field',
			'type' => 'email'
		)
	);
	$wp_customize->get_setting( 'email_field' )->transport = 'postMessage';

	// Date Field
	$wp_customize->add_setting(
		'date_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'date_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Date Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'date_field',
			'type' => 'date'
		)
	);
	$wp_customize->get_setting( 'date_field' )->transport = 'postMessage';


	// Checkbox Field
	$wp_customize->add_setting(
		'checkbox_field',
		array(
			'default'  	=> 'true',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'checkbox_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Checkbox Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'checkbox_field',
			'type' => 'checkbox'
		)
	);
	$wp_customize->get_setting( 'checkbox_field' )->transport = 'postMessage';




	// Password Field
	$wp_customize->add_setting(
		'password_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'password_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Password Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'password_field',
			'type' => 'password'
		)
	);
	$wp_customize->get_setting( 'password_field' )->transport = 'postMessage';



	// Radio Field
	$wp_customize->add_setting(
		'radio_field',
		array(
			'default'  	=> 'choice1',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'radio_field',
		array(
			'choices' => array(
				'choice1' => esc_html__( 'Choice 1', 'dpd-2015' ),
				'choice2' => esc_html__( 'Choice 2', 'dpd-2015' ),
				'choice3' => esc_html__( 'Choice 3', 'dpd-2015' )
			),
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Radio Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'radio_field',
			'type' => 'radio'
		)
	);
	$wp_customize->get_setting( 'radio_field' )->transport = 'postMessage';



	// Select Field
	$wp_customize->add_setting(
		'select_field',
		array(
			'default'  	=> 'choice1',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'select_field',
		array(
			'choices' => array(
				'choice1' => esc_html__( 'Choice 1', 'dpd-2015' ),
				'choice2' => esc_html__( 'Choice 2', 'dpd-2015' ),
				'choice3' => esc_html__( 'Choice 3', 'dpd-2015' )
			),
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Select Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'select_field',
			'type' => 'select'
		)
	);
	$wp_customize->get_setting( 'select_field' )->transport = 'postMessage';



	// Textarea Field
	$wp_customize->add_setting(
		'textarea_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'textarea_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Textarea Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'textarea_field',
			'type' => 'textarea'
		)
	);
	$wp_customize->get_setting( 'textarea_field' )->transport = 'postMessage';



	// Range Field
	$wp_customize->add_setting(
		'range_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'range_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'input_attrs' => array(
				'class' => 'range-field',
				'max' => 100,
				'min' => 0,
				'step' => 1,
				'style' => 'color: #020202'
			),
			'label' => esc_html__( 'Range Field', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'range_field',
			'type' => 'range'
		)
	);
	$wp_customize->get_setting( 'range_field' )->transport = 'postMessage';



	// Page Select Field
	// Returns the page ID
	$wp_customize->add_setting(
		'select_page_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'select_page_field',
		array(
			'description' 	=> esc_html__( '', 'dpd-2015' ),
			'label' => esc_html__( 'Select Page', 'dpd-2015' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'select_page_field',
			'type' => 'dropdown-pages'
		)
	);
	$wp_customize->get_setting( 'dropdown-pages' )->transport = 'postMessage';



	// Color Chooser Field
	$wp_customize->add_setting(
		'color_field',
		array(
			'default'  	=> '#ffffff',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'color_field',
			array(
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'label' => esc_html__( 'Color Field', 'dpd-2015' ),
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'color_field'
			)
		)
	);
	$wp_customize->get_setting( 'color_field' )->transport = 'postMessage';



	// File Upload Field
	$wp_customize->add_setting( 'file_upload' );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'file_upload',
			array(
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'label' => esc_html__( 'File Upload', 'dpd-2015' ),
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'file_upload'
			)
		)
	);



	// Image Upload Field
	$wp_customize->add_setting(
		'image_upload',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'image_upload',
			array(
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'label' => esc_html__( 'Image Field', 'dpd-2015' ),
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'image_upload'
			)
		)
	);
	$wp_customize->get_setting( 'image_upload' )->transport = 'postMessage';



	// Media Upload Field
	// Can be used for images
	// Returns the image ID, not a URL
	$wp_customize->add_setting(
		'media_upload',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'media_upload',
			array(
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'label' => esc_html__( 'Media Field', 'dpd-2015' ),
				'mime_type' => '',
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'media_upload'
			)
		)
	);
	$wp_customize->get_setting( 'media_upload' )->transport = 'postMessage';




	// Cropped Image Field
	$wp_customize->add_setting(
		'cropped_image',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'cropped_image',
			array(
				'description' 	=> esc_html__( '', 'dpd-2015' ),
				'flex_height' => '',
				'flex_width' => '',
				'height' => '1080',
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'cropped_image',
				width' => '1920'
			)
		)
	);
	$wp_customize->get_setting( 'cropped_image' )->transport = 'postMessage';
	*/

} // dpd_2015_register_fields()

/**
 * This will generate a line of CSS for use in header output. If the setting
 * ($mod_name) has no defined value, the CSS will not be output.
 *
 * @access 		public
 * @since 		1.0.0
 * @param 		string 		$selector 		CSS selector
 * @param 		string 		$style 			The name of the CSS *property* to modify
 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
 * @return 		string 						Returns a single line of CSS with selectors and a property.
 */
function dpd_2015_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

	$return = '';
	$mod 	= get_theme_mod( $mod_name );

	if ( ! empty( $mod ) ) {

		$return = sprintf('%s { %s:%s; }',
			$selector,
			$style,
			$prefix . $mod . $postfix
		);

		if ( $echo ) {

			echo $return;

		}

	}

	return $return;

} // dpd_2015_generate_css()

function dpd_2015_programs_menu() {

	return array( 'airport_menu', 'banquets_menu', 'disc_menu', 'golf_menu', 'lakeshore_menu', 'foundation_menu', 'zoo_menu' );

} // dpd_2015_programs_menu()

/**
 * This will output the custom WordPress settings to the live theme's WP head.
 *
 * Used by hook: 'wp_head'
 *
 * @access 		public
 * @see 		add_action( 'wp_head', $func )
 * @since 		1.0.0
 */
function dpd_2015_header_output() {

	global $dpd_2015_themekit;

	?><!-- Customizer CSS -->
	<style type="text/css"><?php

		$menus = dpd_2015_programs_menu();

		foreach ( $menus as $menu ) {

			$url = $dpd_2015_themekit->get_customizer_media_info( $menu . '_bg_img' );
			$class = str_replace( '_', '-', $menu );

			echo '.' . $class . '{ background-image: url( ' . esc_url( $url['url'] ) . ' ); }';

		} // foreach

		// pattern:
		// dpd_2015_generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
		//
		// background-image example:
		// dpd_2015_generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );


	?></style><!-- Customizer CSS --><?php

} // dpd_2015_header_output()

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Used by hook: 'customize_preview_init'
 *
 * @access 		public
 * @see 		add_action( 'customize_preview_init', $func )
 * @since 		1.0.0
 */
function dpd_2015_live_preview() {

	wp_enqueue_script( 'dpd_2015_customizer', get_template_directory_uri() . '/assets/js/customizer.min.js', array( 'jquery', 'customize-preview' ), '', true );

} // dpd_2015_live_preview()
