(function($) {
	
	if( $("#st-ace-editor").length > 0 ) {
		var editor1 = ace.edit("st-ace-editor");
		var textarea = $('textarea[name="custom_css"]').hide();
		editor1.getSession().setValue(textarea.val());
		editor1.getSession().on('change', function(){
			if( $('.st-tabs-alert').length == 0 ) {
				$('.st-tabs').addClass( 'st-tabs-alert' );
			}
			textarea.val(editor1.getSession().getValue());
		});

		editor1.setTheme("ace/theme/tomorrow_night_eighties");
		editor1.session.setMode("ace/mode/css");
		editor1.setOption("minLines", 30);
		editor1.setOption("maxLines", 30);
	}

}(jQuery));