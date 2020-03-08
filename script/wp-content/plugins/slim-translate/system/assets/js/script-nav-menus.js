(function($) {

	'use strict';

	var button = 'slimTranslate-menus-button',
		spinner = '<span class="spinner is-active"></span>',
		spinner_center = '<span class="spinner is-active st-modal-loading"></span>',
		modal = '<div class="st-modal"><div class="st-modal-body"><div class="st-modal-box"><a class="st-modal-close"></a><div class="st-modal-show">' + spinner_center + '</div></div></div></div>',
		data;

	$('#nav-menus-frame').before( '<div id="' + button + '" class="slimTranslate-translate-button"><a data-transfer="nav-menus" data-login="' + slim_translate.translate_login + '" data-ver="' + slim_translate.translate_user + '" class="st-menu-button st-modal-toggle">' + slim_translate.translate_menu + '</a></div>' );



	/**
	 * nav-menus tabs
	 */
	$(document).on( 'click', '.slim-tab-item.slim-tab-item-menu', function() {
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
	 * save nav menus
	 */
	$(document).on( 'submit', '#form-nav-menus', function() {
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