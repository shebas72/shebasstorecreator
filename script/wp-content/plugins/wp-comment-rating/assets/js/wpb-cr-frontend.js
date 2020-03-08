jQuery( document ).ready( function () {
	"use strict";

	/* Prevent multiple clicks */
	var wpbcr_clicked = false;

	jQuery( document ).on( 'click', '.wpb-comment-rating a', (function ( e ) {
		e.preventDefault();

		/* Prevent multiple clicks */
		if ( true == wpbcr_clicked ) {
			return false;
		}

		wpbcr_clicked = true;

		var thisObj = jQuery( this );

		var whereto = thisObj.data( 'wpbcr_whereto' );

		var id = parseInt( thisObj.data( 'wpbcr_id' ) );

		var rate_up = jQuery( this ).hasClass( 'wpbcr-rate-up' );

		var new_rating;

		jQuery.ajax( {
			'url'       : WPBAjaxCommentRating.ajaxurl,
			'type'      : 'GET',
			'dataType'  : 'json',
			'data'      : {
				'action'     : WPBAjaxCommentRating.a,
				'whereto'    : whereto,
				'wpbcr_id'   : id,
				'wpbcr_nonce': WPBAjaxCommentRating.nonce
			},
			'beforeSend': function () {
				thisObj.parent().find( '.wpbcr-loader' ).show( 1 );
			},
			'complete'  : function () {
				thisObj.parent().find( '.wpbcr-loader' ).hide( 1 );
				wpbcr_clicked = false;
			},
			'success'   : function ( response ) {

				if ( true == response.success ) {
					var current_rating = parseInt( thisObj.parent().find( '.wpbcr-r' ).text() );
					if ( rate_up ) {
						new_rating = current_rating + 1;
					} else {
						new_rating = current_rating - 1;
					}

					thisObj.parent().find( '.wpbcr-r' ).text( new_rating );
				} else {
					if ( typeof response.data.message !== "undefined" ) {
						alert( response.data.message );
					} else {
						alert( response );
					}
				}
			}
		} );

		return false;
	}) );


} );