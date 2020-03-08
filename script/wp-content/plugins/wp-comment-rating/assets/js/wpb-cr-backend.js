jQuery(document).ready(function () {
	"use strict";

	jQuery('.wpbcr-list-icons span').click(function () {
		jQuery(this).parent().parent().parent().parent().find('.wpbcr-list-icon').val(jQuery(this).data('icon_name'));

		jQuery(this).parent().find('span').removeClass('wpbcr-list-icon-selected');
		jQuery(this).addClass('wpbcr-list-icon-selected');
	});

	jQuery('#vote_up_icon, #vote_down_icon').each(function () {
		var val = jQuery(this).val();
		jQuery(this).parent().parent().parent().find('.wpbcr-icon-' + val).addClass('wpbcr-list-icon-selected');
	});


});