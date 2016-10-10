<?php

/**
 * Class that creates shortcodes
 */
class DPD_2015_Shortcodes {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * Constructor
	 */
	public function __construct() {

		if ( ! function_exists( 'tribe_get_events' ) ) { return; }

		$this->loader();
		//$this->set_meta();

	} // __construct()

	private function loader() {

		add_shortcode( 'tecevents', array( $this, 'shortcode_tecevents' ) );

	} // loader()


	/**
	 * Returns a cache name based on the attributes.
	 *
	 * @param 	array 		$args 			The WP_Query args
	 * @param   string 		$cache 			Optional cache name
	 *
	 * @return 	string 						The cache name
	 */
	private function get_cache_name( $args, $cache = '' ) {

		$return = 'dpd_2015_events';

		if ( empty( $args ) ) { return $return; }

		if ( ! empty( $cache ) ) {

			$return = 'dpd_2015_' . $cache . '_events';

		}

		if ( ! empty( $args['cat'] ) ) {

			$return = 'dpd_2015_' . $cache . $args['cat'] . '_events';

		}

		return $return;

	} // get_cache_name()

	/**
	 * Returns the results of the WP_Query
	 *
	 * @param  array  $params [description]
	 * @param  string $cache  [description]
	 *
	 * @return [type]         [description]
	 */
	private function query( $params = array(), $cache = '' ) {

		$return 	= FALSE;
		$cache_name = $this->get_cache_name( $params, $cache );
		/*$return 	= wp_cache_get( $cache_name, 'dpd_2015_events' );*/

		if ( ! empty( $params['message'] ) ) {

			$emptymsg = $params['message'];

			unset( $params['message'] );

		}

		if ( false === $return ) {

			$args 	= apply_filters( 'dpd-2015-events-query-args', $this->set_args( $params ) );
			$query 	= new WP_Query( $args );

			if ( is_wp_error( $query ) && empty( $query ) ) {

				$return = esc_html__( $emptymsg, 'dpd-2015' );

			} else {

				wp_cache_set( $cache_name, $query, 'dpd_2015_events', 5 * MINUTE_IN_SECONDS );

				$return = $query->posts;

			}

		}

		return $return;

	} // query()

	/**
	 * Sets the args array for a WP_Query call
	 *
	 * @param 	array 		$params 		Array of shortcode parameters
	 *
	 * @return 	array 						An array of parameters for WP_Query
	 */
	private function set_args( $params ) {

		//if ( empty( $params ) ) { return; }

		$args = array();

		$args['no_found_rows']				= true;
		$args['order'] 						= $params['order'];
		$args['orderby'] 					= 'meta_value';
		$args['post_type'] 					= Tribe__Events__Main::POSTTYPE;
		$args['post_status'] 				= 'publish';
		$args['posts_per_page'] 			= absint( $params['limit'] );
		$args['update_post_term_cache'] 	= false;

		unset( $params['limit'] );
		unset( $params['order'] );

		if ( empty( $params ) ) { return $args; }

		if ( ! empty( $params['past'] ) ) {

			$args['eventDisplay'] = 'past';

			unset( $params['past'] );

		}

		foreach ( $params as $key => $param ) {

			if ( empty( $param ) ) {

				unset( $params[$key] );

			}

		}

		$args = wp_parse_args( $params, $args );

		return $args;

	} // set_args()

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'tribe_events' !== $post->post_type ) { return; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Processes the tec-events shortcode
	 *
	 * @param 		array 		$atts 			Shortcode attributes
	 *
	 * @return 		x 							x
	 */
	public function shortcode_tecevents( $atts ) {

		ob_start();

		$defaults 					= array();
		$defaults['cat'] 			= '';
		$defaults['display'] 		= array(); // details, time, venue, excerpt, etc
		$defaults['event_tax'] 		= '';
		$defaults['limit'] 			= 50;
		$defaults['message'] 		= 'There are no upcoming events at this time.';
		$defaults['order'] 			= 'ASC';
		$defaults['past'] 			= NULL;

		$args						= shortcode_atts( $defaults, $atts, 'tecevents' );
		$events 					= $this->query( $args );

		if ( is_array( $events ) || is_object( $events ) ) {

			apply_filters( 'dpd-2015-board-events', (array)$events, $args );

		} else {

			echo $events;

		}

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // shortcode_tecevents()

} // class

$dpd_2015_shortcodes = new DPD_2015_Shortcodes();
