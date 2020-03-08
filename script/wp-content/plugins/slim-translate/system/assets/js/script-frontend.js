(function($) {
	
	$(document).on( 'click', '.st-translate-widget .st-toggle a', function() {
		if( $('.st-translate-widget.st-dropdown-active').length > 0 ) {
			$('.st-translate-widget .st-dropdown').fadeOut();
		} else {
			$('.st-translate-widget .st-dropdown').fadeIn();
		}
		$(this).closest('.st-translate-widget').toggleClass('st-dropdown-active');
		$(this).blur();
		return false;
	});

	$(document).on( 'click', 'body', function() {
		if( $('.st-translate-widget.st-dropdown-active').length > 0 ) {
			$('.st-translate-widget .st-dropdown').fadeOut();
			$('.st-translate-widget.st-dropdown-active').removeClass('st-dropdown-active');
		}
	});

})(jQuery);