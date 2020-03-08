(function($) {

	'use strict';

	var button = 'slimTranslate-menus-button',
		spinner = '<span class="spinner is-active"></span>',
		spinner_center = '<span class="spinner is-active st-modal-loading"></span>',
		modal = '<div class="st-modal"><div class="st-modal-body"><div class="st-modal-box"><a class="st-modal-close"></a><div class="st-modal-show">' + spinner_center + '</div></div></div></div>',
		data;



	/**
	 * clicking modal toggle
	 */
	$(document).on( 'click', '.st-modal-toggle', function() {
		
		/**
		 * prepare variables that needed
		 */
		var e = this,
			$e = $(e),
			attr = $e.attr('data-transfer'),
			login = $e.attr('data-login'),
			ver = $e.attr('data-ver');
		
		/**
		 * showing modal
		 */
		$('body').addClass( 'st-modal-open' );
		$('body').append( modal );
		
		/**
		 * if data that needed don't exist, then
		 * progress will terminated.
		 */
		if( typeof ver == typeof undefined || typeof attr == typeof undefined || login != 1 ) {
			return false;
		}
		
		/**
		 * preparing ajax data
		 */
		data = {
			'action'	: 'slimTranslate_ajax_' + attr,
			'ver'		: ver
		};
		
		/**
		 * processing ajax
		 */
		jQuery.post( slim_translate.ajax_url, data, function(r) {
			if( ( r != '' || r != 0 || r != '0' ) && $('.st-modal-show').length > 0 ) {
				$('.st-modal-show').html( r );
				if( $e.parent().attr('id') == 'slimTranslate-widgets-button' ) {
					st_admin_widgets( e );
				}
			}
		});

		return false;

	}); // modal toggle



	/**
	 * closing modal
	 */
	$(document).on( 'click', '.st-modal-close', function() {
		$('body').removeClass( 'st-modal-open' );
		$('.st-modal').remove();
		return false;
	});



	/**
	 * checking the texts inside widgets
	 */
	function st_admin_widgets( e ) {
		var sidebars = 'widgets-right',
			$s = $(sidebars),
			texts = [];
		
		// active widgets
		$.each( $('#widgets-right input:not([type="hidden"]):not([type="radio"]):not([type="checkbox"]):not([type="password"]):not([type="number"]):not([type="submit"])'), function() {
			texts.push( $(this).val() );
		});
		$.each( $('#widgets-right textarea'), function() {
			texts.push( $(this).val() );
		});
		// inactive widgets
		$.each( $('#wp_inactive_widgets input:not([type="hidden"]):not([type="radio"]):not([type="checkbox"]):not([type="password"]):not([type="number"]):not([type="submit"])'), function() {
			texts.push( $(this).val() );
		});
		$.each( $('#wp_inactive_widgets textarea'), function() {
			texts.push( $(this).val() );
		});
		$.each( texts, function( $var, $val ) {
			$('#form-nav-widgets').find('textarea.st-translate-item-first[data-value="' + $val + '"]').addClass( 'st-translate-item-keep' );
		});
		$('#form-nav-widgets').find('textarea.st-translate-item-first:not(.st-translate-item-keep)').closest( 'tr' ).remove();		
	}



	/**
	 * widgets tabs
	 */
	$(document).on( 'click', '.slim-tab-item.slim-tab-item-widget', function() {
		var e = this,
			$e = $(e),
			lang = $e.attr('data-language');
		$('.st-table-translate').fadeOut(100);
		$('.st-table-translate').fadeIn(100);
		setTimeout( function() {
			$e.closest('.slim-edit-tabs-modal').children().removeClass('active');
			$e.addClass('active');
			$('.st-table-translate').find('.st-translate-item').removeClass('active');
			$('.st-table-translate').find('.st-translate-item[data-language="' + lang + '"]').addClass('active');
		}, 100 );
		return false;
	});




	/**
	 * dismiss modal notice
	 */
	$(document).on( 'click', '.st-notice-dismiss', function() {
		$(this).closest('.notice').slideUp();
		return false;
	} );



	/**
	 * save nav menus
	 */
	$(document).on( 'submit', '#form-nav-widgets', function() {
		var e = this,
			$e = $(e),
			lang = $e.attr('data-language');
		$e.find('.close-button').before( spinner );
		$e.find('.submit-button').attr( 'disabled', '' );
		$e.find('.submit-button').addClass( 'disabled' );
		jQuery.post( slim_translate.ajax_url, $e.serialize() , function(r) {
			$('.st-modal-notice').html(r);
			$('.st-modal-notice').children('.notice').slideDown();
			$e.find('.spinner').remove();
			$e.find('.submit-button').removeAttr( 'disabled' );
			$e.find('.submit-button').removeClass( 'disabled' );
		});
		return false;
	} );

})(jQuery);