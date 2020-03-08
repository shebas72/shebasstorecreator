(function($) {

	'use strict';

	$(document).on( 'change', '.st-detect-change', function() {
		$('.st-tabs').addClass( 'st-tabs-alert' );
	});

	$(document).on( 'keyup', '.st-detect-keyup', function() {
		$('.st-tabs').addClass( 'st-tabs-alert' );
	});

	$(document).on( 'click', '.st-detect-click', function() {
		$('.st-tabs').addClass( 'st-tabs-alert' );
	});

	$(document).on( 'click', '.st-tabs-alert', function() {
		var $confirm = confirm( slim_translate.areyousure );
		if( !$confirm ) {
			return false;
		}
	});



	/**
	 * modify the forms => POST
	 */
	$('#title').removeAttr( 'name' );
	$('#content').removeAttr( 'name' );
	$('#excerpt').removeAttr( 'name' );
	$(document).on( 'click', '.slim-tab-item.slim-tab-item-post', function() {
		// copy the text
		slim_translate_content();
		slim_translate_excerpt();
		// changing tabs
		$(this).parent().children().removeClass('active');
		$(this).addClass('active');
		$(this).blur();
		// changing titles
		var target = $(this).attr('data-title-target'),
			$target = $( '#' + target );
		$('#title').val( $target.val() );
		// changing contents
		var content,
			editor = tinyMCE.get('content');
		target = $(this).attr('data-content-target');
		$target = $( '#' + target );
		if( editor && $('#wp-content-wrap.html-active #content').length == 0 ) {
			editor.setContent( $target.val() );
		} else {
			$('#content').val( $target.val() );
		}
		// changing excerpt
		if( $('#excerpt').length > 0 ) {
			var editor_excerpt = tinyMCE.get('excerpt');
			target = $(this).attr('data-excerpt-target');
			$target = $( '#' + target );
			if( editor_excerpt && $('#wp-excerpt-wrap.html-active #excerpt').length == 0 ) {
				editor_excerpt.setContent( $target.val() );
			} else {
				$('#excerpt').val( $target.val() );
			}
		}
		return false;
	});
	
	// title keyup
	$(document).on( 'change, keyup', '#title', function() {
		var title = $('.slim-tab-item.slim-tab-item-post.active').attr('data-title-target'),
			$title = $( '#' + title );
		$title.val( $(this).val() );
		return false;
	});

	// submit
	$(document).on( 'change, keyup', '#wp-content-wrap', function() {
		// copy the text to each textarea
		slim_translate_content();
	});
	$(document).on( 'change, keyup', '#wp-excerpt-wrap', function() {
		// copy the text to each textarea
		slim_translate_excerpt();
	});
	$(document).on( 'submit', 'form#post', function() {
		// copy the text to each textarea
		slim_translate_content();
		slim_translate_excerpt();
		slim_translate_copy_all();
	});

	function slim_translate_content() {
		// changing titles
		var target = $('.slim-tab-item.slim-tab-item-post.active').attr('data-content-target'),
			$target = $( '#' + target ),
			content,
			editor = tinyMCE.get('content');
		if( !editor || $('#content[aria-hidden="false"]').length > 0 ) {
			content = $('#content').val();
		} else {
			content = editor.getContent();
		}
		$target.val( content );
	}

	function slim_translate_excerpt() {
		// changing titles
		var target = $('.slim-tab-item.slim-tab-item-post.active').attr('data-excerpt-target'),
			$target = $( '#' + target ),
			excerpt,
			editor = tinyMCE.get('excerpt');
		if( (!editor || $('#excerpt[aria-hidden="false"]').length > 0) || $('#excerpt.wp-editor-area').length == 0 ) {
			excerpt = $('#excerpt').val();
		} else {
			excerpt = editor.getContent();
		}
		$target.val( excerpt );
	}

	function slim_translate_copy_all() {
		// changing titles
		var $title_default		= $('.st-title-translate-default'),
			$title_items		= $('.st-title-translate-item'),
			$content_default	= $('.st-content-translate-default'),
			$content_items		= $('.st-content-translate-item'),
			$excerpt_default	= $('.st-excerpt-translate-default'),
			$excerpt_items		= $('.st-excerpt-translate-item'),
			$editor_content = tinyMCE.get('content'),
			translations = '';

		// changing content
		$title_items.each( function(e) {
			return translations += $(this).val();
		});
		$content_items.each( function(e) {
			return translations += $(this).val();
		});
		if( $excerpt_items.length > 0 ) {
			$excerpt_items.each( function(e) {
				return translations += $(this).val();
			});
		}
		$content_default.val( $content_default.val() + '<!-- SLIMTRANSLATEw54$30oqd3 --><div style="display: none !important;">' + translations + '</div>' );
	}



	/**
	 * modify the forms => TERM
	 */
	$('body.term-php #name').removeAttr( 'name' );
	$('body.term-php #description').removeAttr( 'name' );
	$(document).on( 'click', '.slim-tab-item.slim-tab-item-term', function() {
		// changing tabs
		$(this).parent().children().removeClass('active');
		$(this).addClass('active');
		$(this).blur();
		// changing titles
		var target = $(this).attr('data-title-target'),
			$target = $( '#' + target );
		$('body.term-php #name').val( $target.val() );

		target = $(this).attr('data-content-target');
		$target = $( '#' + target );
		$('body.term-php #description').val( $target.val() );
		return false;
	});
	
	// title keyup
	$(document).on( 'change, keyup', 'body.term-php #name', function() {
		var title = $('.slim-tab-item.slim-tab-item-term.active').attr('data-title-target'),
			$title = $( '#' + title );
		$title.val( $(this).val() );
		return false;
	});
	
	// description keyup
	$(document).on( 'change, keyup', 'body.term-php #description', function() {
		var title = $('.slim-tab-item.slim-tab-item-term.active').attr('data-content-target'),
			$title = $( '#' + title );
		$title.val( $(this).val() );
		return false;
	});

})(jQuery);