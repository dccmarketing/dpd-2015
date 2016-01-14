/**
 * hidden-site-links.js
 *
 * Handles toggling the appearance of the top header menu on mobile.
 */
( function() {

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {

		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {

				if ( -1 !== self.className.indexOf( 'focus' ) ) {

					self.className = self.className.replace( ' focus', '' );

				} else {

					self.className += ' focus';

				}

			}

			self = self.parentElement;
		}
	}

	var container, topmenu, button, headertop;

	container = document.getElementsByClassName( 'wrap-topheader' )[0];
	if ( ! container ) { return; }

	topmenu = document.getElementById( 'top-header-menu' );
	if ( ! topmenu ) { return; }

	headertop = document.getElementById( 'header-top' );
	if ( ! headertop ) { return; }

	button = container.getElementsByClassName( 'topmenu-toggle' )[0];
	if ( ! button ) { return; }

	topmenu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof topmenu ) {

		button.style.display = 'none';

		return;

	}

	topmenu.setAttribute( 'aria-hidden', 'true' );

	button.onclick = function() {

		if ( -1 !== headertop.className.indexOf( 'toggled' ) ) {

			headertop.className = headertop.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			topmenu.setAttribute( 'aria-expanded', 'false' );

		} else {

			headertop.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			topmenu.setAttribute( 'aria-expanded', 'true' );

		}

	};

} )();
