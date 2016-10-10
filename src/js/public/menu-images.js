(function ($) {
	'use strict';

	$(function() {

		$( '.set-btn' ).on( 'click', function(e){

			e.preventDefault();
			e.stopPropagation();

			var item_id = $(this).attr('data-item-id');

			var uploader = wp.media({
				button: {
					text: menuImage.l10n.uploaderButtonText,
				},
				library: {
					type: 'image'
				},
				multiple: false,
				title: menuImage.l10n.uploaderTitle
			});

			uploader.on( 'select', function () {
				var attachment = uploader.state().get('selection').first().toJSON();

				if ( attachment.id ) {

					$('#menu-item-img-' + item_id + ' img').attr( 'src', attachment.sizes.thumbnail.url );
					$('#menu-item-img-' + item_id + ' .menu-bg-img-btn').text( menuImage.l10n.removeLabel );
					$('#menu-item-img-' + item_id + ' .remove-btn').toggleClass( 'hide' );
					$('#menu-item-img-' + item_id + ' .set-btn').toggleClass( 'hide' );
					$('#_menu-item-bg-img-' + item_id).val( attachment.id );

				} // End of image ID check

			}).open();

		});
	});

	$(function() {
		$('.remove-btn').on( 'click', function(e){

			e.preventDefault();
			e.stopPropagation();

			var item_id = $(this).attr('data-item-id');

			$('#menu-item-img-' + item_id + ' img').attr( 'src', '' );
			$('#menu-item-img-' + item_id + ' .menu-bg-img-btn').text( menuImage.l10n.setLabel );
			$('#menu-item-img-' + item_id + ' .remove-btn').toggleClass( 'hide' );
			$('#menu-item-img-' + item_id + ' .set-btn').toggleClass( 'hide' );
			$('#_menu-item-bg-img-' + item_id).val('');

		});
	});
})(jQuery);
