/**
 * Handles previewing text for the buy a brick form.
 */
( function() {
	
	var line1, line2, line3, line4, brick1, brick2, brick3, brick4, preview, sizer;
	
	sizer = document.querySelector( '.brick-size-select' );
	if ( ! sizer ) { return; }
	
	preview = document.querySelector( '.preview-brick' );
	
	line1 = document.querySelector( '#field_brick-text-line-1' );
	line2 = document.querySelector( '#field_brick-text-line-2' );
	line3 = document.querySelector( '#field_brick-text-line-3' );
	line4 = document.querySelector( '#field_brick-text-line-4' );
	
	brick1 = document.querySelector( '.brick-text-1' );
	brick2 = document.querySelector( '.brick-text-2' );
	brick3 = document.querySelector( '.brick-text-3' );
	brick4 = document.querySelector( '.brick-text-4' );
	
	function add_text( event ) {
		
		var target = getEventTarget( event );
		
		if ( line1 === target ) {
			
			brick1.textContent = this.value;
			
		} else if ( line2 === target ) {
			
			brick2.textContent = this.value;
			
		} else if ( line3 === target ) {
			
			brick3.textContent = this.value;
			
		} else if ( line4 === target ) {
			
			brick4.textContent = this.value;
			
		}
		
	} // add_text()
	
	/**
	 * Returns the event target.
	 *
	 * @param 		object 		event 		The event.
	 * @return 		object 		target 		The event target.
	 */
	function getEventTarget( event ) {

		event = event || window.event;

		return event.target || event.srcElement;

	} // getEventTarget()
	
	function showBrick( event ) {
		
		var target 		= getEventTarget( event );
		var bgclass 	= target.value;
		
		preview.classList = '';
		preview.classList.add( 'preview-brick' );
		preview.classList.add( target.value );
		
	} // showBrick()
	
	line1.addEventListener( 'keyup', add_text );
	line2.addEventListener( 'keyup', add_text );
	line3.addEventListener( 'keyup', add_text );
	line4.addEventListener( 'keyup', add_text );
	sizer.addEventListener( 'click', showBrick );
	
})();