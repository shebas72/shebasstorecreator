jQuery( document ).ready( function () {
	"use strict";

	jQuery( document ).on( 'click', '.button.wpcr-upgrade', function ( e ) {
		e.preventDefault();

		if ( true !== window.confirm( 'Do you confirm that you have made a backup of your database? If yes, please confirm to proceed.' ) ) {
			return false;
		}

		jQuery( this ).addClass( 'installing' ).attr( 'disabled', true );

		jQuery( '.wpcr-upgrade-bar' ).css( 'display', 'block' );

		wpbcr_upgrade();
	} );

	function wpbcr_upgrade() {
		var nonce = jQuery( '.button.wpcr-upgrade' ).data( 'nonce' );

		jQuery.ajax( ajaxurl, {
			'beforeSend': function () {
			},
			'complete':   function () {
			},
			'timeout':    0,
			'dataType':   'json',
			'type':       'POST',
			'data':       {
				'_wpnonce': nonce,
				'action':   'wpcr_ajax_upgrade'
			}
		} ).done( function ( response ) {

			if ( 'success' in response && response.success && 'data' in response ) {
				if ( response.data.total > 0 ) {
					var percent = parseInt( parseInt( response.data.done ) * 100 / parseInt( response.data.total ) );

					jQuery( '.wpcr-upgrade-bar-inner' ).css( 'width', percent + '%' );

					wpbcr_upgrade();
				} else {
					jQuery( '.wpcr-upgrade-bar-inner' ).css( 'width', '100%' );
					jQuery( '.button.wpcr-upgrade' ).replaceWith( '<p>All done.</p>' );
				}
			} else {
				window.console.error( response );
			}
		} );
	}
} );
