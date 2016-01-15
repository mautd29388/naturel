(function($) {
	"use strict";

	$(document).ready(function($){
		var $page_template = $("select[name='page_template']");
		
		// Show/hide metaboxes on page load
		if ( $page_template.length > 0 ) displayMetaboxesPageTemplate();
		
		$page_template.change(function() {
			displayMetaboxesPageTemplate();
		});
	
		function displayMetaboxesPageTemplate() {
			// Hide all post format metaboxes
			$(custom_metabox.ids).hide();
			// Get current post format
			var selectedVal = $("select[name='page_template'] option:selected").val();
	
			// If exists, fade in current post format metabox
			if (custom_metabox.formats[selectedVal])
				$("#" + custom_metabox.formats[selectedVal]).fadeIn();
		}
	});
	
})(jQuery);