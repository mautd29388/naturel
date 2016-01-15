(function ( $ ) {
	"use strict";
	
	window.mTheme_posttype = vc.shortcode_view.extend( {
		changeShortcodeParams: function ( model ) {
			var params;
			var icon;

			window.mTheme_posttype.__super__.changeShortcodeParams.call( this, model );
			params = model.get( 'params' );
			var $find = this.$el.find( '> .wpb_element_wrapper' );
			
			if ( _.isObject( params ) && _.isString( params.title ) && params.title.length > 0 ) {
				
				if ( $find.find('span').length > 0 ) {
					$find.find('span').html(params.title);
					
				} else {
					$("<span>"+ params.title +"</span>").appendTo($find);
				}
				
			} else {
				if ( $find.find('span').length > 0 ) {
					$find.find('span').html('');
				}
			}
		}
	} );
	
})( window.jQuery );