/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, a .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to,
				} );

			}
		} );
	} );



	// Home Page
	wp.customize( 'events_heading', function( value ) {
		value.bind( function( to ) {
			$( '#home-events-heading' ).text( to );
		} );
	} );

	wp.customize( 'no_events_message', function( value ) {
		value.bind( function( to ) {
			$( '.no-events-msg' ).text( to );
		} );
	} );

	wp.customize( 'news_heading', function( value ) {
		value.bind( function( to ) {
			$( '#home-news-heading' ).text( to );
		} );
	} );

	wp.customize( 'no_news_message', function( value ) {
		value.bind( function( to ) {
			$( '.no-news-msg' ).text( to );
		} );
	} );

	wp.customize( 'quick_links_heading', function( value ) {
		value.bind( function( to ) {
			$( '#quick-links-heading' ).text( to );
		} );
	} );

	wp.customize( 'email_subscription_label', function( value ) {
		value.bind( function( to ) {
			$( '.email-subscription-label' ).text( to );
		} );
	} );






/*
	wp.customize( 'text_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-title' ).text( to );
		} );
	} );

	// Doesn't work instantly, works after you go out of the field
	wp.customize( 'url_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-title a' ).attr( 'href', to );
		} );
	} );

	// Doesn't work instantly, works after you go out of the field
	wp.customize( 'email_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-title' ).text( to );
			//$( '.entry-title a' ).attr( 'href', 'mailto:'+to );
		} );
	} );

	wp.customize( 'date_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-date' ).text( to );
		} );
	} );

	wp.customize( 'checkbox_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-date' ).style.display( 'none' );
			if ( to ) {

			}
		} );
	} );

	wp.customize( 'color_field', function( value ) {
		value.bind( function( to ) {
			$( '.color_field' ).css( {
				'color': to,
			} );
		} );
	} );

	wp.customize( 'image_field', function( value ) {
		value.bind( function( to ) {
			$( '.image_field' ).css( {
				'color': to,
			} );
		} );
	} );
*/
} )( jQuery );
