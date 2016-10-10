<?php

/**
 * A class modifying The Events Calendar plugin.
 *
 * @package DPD_2015
 * @author Slushman <chris@slushman.com>
 */
class dpd_2015_The_Events_Calendar {

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

		add_action( 'tribe_events_after_the_event_title', array( $this, 'add_documents_to_board_meetings' ), 10 );
		add_filter( 'tribe_events_event_classes', array( $this, 'add_classes' ), 10, 1 );

	} // loader()

	public function add_classes( $classes ) {

		global $post;

		if ( dpd_2015_is_past_event( $post->ID ) ) {

			$classes[] = 'past-event';

		}

		return $classes;

	} // add_classes()

	/**
	 * Adds Agenda and Minutes document links to Board Meetings events in the list.
	 */
	public function add_documents_to_board_meetings() {

		$fields = get_fields( get_the_ID() );

		if ( ! empty( $fields['agenda'] ) ) {

			?><a class="event-agenda" href="<?php echo esc_url( $fields['agenda'] ); ?>"><?php esc_html_e( 'Agenda', 'dpd-2015' ); ?></a><?php

		}

		if ( ! empty( $fields['minutes'] ) ) {

			?><a class="event-minutes" href="<?php echo esc_url( $fields['minutes'] ); ?>"><?php esc_html_e( 'Minutes', 'dpd-2015' ); ?></a><?php

		}

	} // add_documents_to_board_meetings()

} // class

$dpd_2015_The_Events_Calendar = new dpd_2015_The_Events_Calendar();
