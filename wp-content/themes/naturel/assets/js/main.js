(function($) {
	"use strict";
	
	$( window ).load(function() {
		
		$('body.loadpage:before').hide();
		if ( $('body').hasClass('loadpage') ) {
			$('body').removeClass('loadpage');
		}
		
		// Top Banner 
		$( window ).scroll( function() {
			if ( $('body').hasClass('hideBanner') ) {
				$('body').removeClass('hideBanner');
				$(this).scrollTop(0);
			}
		});
		
	});
	
	
	$(document).ready(function() {
		
		// Mega menu
		mtheme_mage_menu();
		
		// Custom Select
		mtheme_custom_select($('.woocommerce-ordering select'));
		
		// Load Filter Products
		$('.woocommerce').on('click', '.products .view-mode a', function(e) {
			
			e.preventDefault();
			
			var $this 	= $(this),
				$url	= '',
				$parent = $this.parents('.view-mode'); 
			
			if ( $this.hasClass('active') )
				return false;
			
			$url = $this.attr('href');
			
			mtheme_filter_products( $url, $this );
			
		});
		$('.woocommerce').on('click', '.woocommerce.widget_layered_nav a', function(e) {
			
			e.preventDefault();
			
			var $this 	= $(this),
				$url	= '',
			
			$url = $this.attr('href');
			
			mtheme_filter_products( $url, $this );
			
		});
		$('.woocommerce').on( 'submit', '.woocommerce.widget_price_filter form, form.woocommerce-ordering', function(e) {
			e.preventDefault();
			
			mtheme_filter_products( '?' + $(this).serialize(), $(this) );
		});
		// End Filter
		
		
		$('.mtheme-post-type').find('.gallery-flickity').each(function(){
			var $flickity = $(this);
			
			$flickity.imagesLoaded(function() {
				$flickity.flickity({
					contain: true,
					imagesLoaded: true,
					freeScroll: false,
					cellAlign: 'left',
					wrapAround: true,
					prevNextButtons: true,
					pageDots: false
				});
				
				
			});
		})
		
		
		// Sidebar Floating
		$('.sidebar-floating').on('click', '.floating-button', function(e) {
			e.preventDefault();
			
			$('.sidebar-floating').toggleClass('active');
		});
		
		
		// Products Tab
		$('.mTheme-products-tab').each( function(){
			var $this 			=  $(this),
				$tabs			= '',
				$tab_content 	= '',
				$active			= '',
				$parent 		= $this.parent();
			
			$tabs 		= '<div class="mtheme-products-tabs"><ul class="nav nav-tabs"></ul><div class="tab-content"></div></div>';
		
			if ( $parent.children('.mtheme-products-tabs').length < 1 ) {
				$parent.append($tabs);
				$active = 'active';
			} else{
				$active = '';
			}
			
			$parent.find('.mtheme-products-tabs .nav-tabs').append('<li class="'+ $active +'"><a data-toggle="tab" href="#'+ $this.attr('id') +'">'+ $this.find('.wpb_heading').html() +'</a></li>');
			$parent.find('.mtheme-products-tabs .tab-content').append('<div id="'+ $this.attr('id') +'" class="tab-pane '+ $active +'"><div class="mtheme-products-inner">'+ $this.find('.mtheme-products-inner').html() +'</div></div>');

			$this.remove();
		});
		
		
	});
	
	// Custom select
	function mtheme_custom_select( $elements ) {
		// Iterate over each select element
		$elements.each(function () {

		    // Cache the number of options
		    var $this = $(this),
		        numberOfOptions = $(this).children('option').length;

		    // Hides the select element
		    $this.addClass('s-hidden');

		    // Wrap the select element in a div
		    $this.wrap('<div class="select"></div>');

		    // Insert a styled div to sit over the top of the hidden select element
		    $this.after('<div class="styledSelect"></div>');

		    // Cache the styled div
		    var $styledSelect = $this.next('div.styledSelect');

		    // Show the first select option in the styled div
		    $styledSelect.text($this.children('option:selected').text());

		    // Insert an unordered list after the styled div and also cache the list
		    var $list = $('<ul />', {
		        'class': 'options'
		    }).insertAfter($styledSelect);

		    // Insert a list item into the unordered list for each select option
		    for (var i = 0; i < numberOfOptions; i++) {
		        $('<li />', {
		            text: $this.children('option').eq(i).text(),
		            rel: $this.children('option').eq(i).val()
		        }).appendTo($list);
		    }

		    // Cache the list items
		    var $listItems = $list.children('li');

		    // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
		    $styledSelect.click(function (e) {
		        e.stopPropagation();
		        $('div.styledSelect.active').each(function () {
		            $(this).removeClass('active').next('ul.options').hide();
		        });
		        $(this).toggleClass('active').next('ul.options').toggle();
		    });

		    // Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
		    // Updates the select element to have the value of the equivalent option
		    $listItems.click(function (e) {
		        e.stopPropagation();
		        $styledSelect.text($(this).text()).removeClass('active');
		        $list.hide();
		        /* alert($this.val()); Uncomment this for demonstration! */
		        $this.val($(this).attr('rel'));
		        
		        if ( $this.parents('.woocommerce-ordering').length > 0 ) {
		        	$this.closest( 'form' ).submit();
		        }
		    });

		    // Hides the unordered list when clicking outside of it
		    $(document).click(function () {
		        $styledSelect.removeClass('active');
		        $list.hide();
		    });

		});
	}
	
	// Mega menu
	function mtheme_mage_menu() {
		
		var $mega = $('.mega-menu-wrap'),
			position_left = 0;
		
		$mega.each( function() {
			
			var $this = $(this);

			if ( $this.hasClass('full-width') ) {
				position_left = $this.offset().left - ($(window).innerWidth() - $this.innerWidth())/2;
				$this.css({
		            'left': -position_left
		        });
				
			} else if ( $this.hasClass('pos-center') ) {
				position_left = $this.innerWidth()/2;
				$this.css({
		            'left': -position_left
		        });
			}
		});
	}
	
	// Filter Products
	function mtheme_filter_products( $url, $element ) {
		
		var $products = $('body').find('.products'),
			$data = '';
		
		window.history.pushState({path:$url},'',$url);
		
		$( document ).ajaxStart(function() {
			$('body').addClass('loadding');
		});
		$( document ).ajaxStop(function() {
			$('body').removeClass('loadding');
		});
		
		$.ajax({
			url: $url,
			data: $data, 
			cache: false,
		}).done(function( html ) {
			
			// Change Content
			$products.html($(html).find('.products').html());
			
			// Change widget layered nav
			$('body').find('.woocommerce.widget_layered_nav').each(function() {
				$(this).html($(html).find('#' + $(this).attr('id')).html());
			}); 
			
			// Change widget price filter
			$('body').find('.woocommerce.widget_price_filter').each(function() {
				$(this).find('.price_label').nextAll('input').remove();
				$(this).find('.price_label').after($(html).find('#' + $(this).attr('id') + ' .price_label').nextAll('input'));
				
				if ( $products.find('.view-mode .active').length > 0 ) {
					$(this).find('.price_label').after('<input type="hidden" value="'+ $products.find('.view-mode .active').attr('data-view') +'" name="view">');
				}
			});
			
			// Custom Select
			mtheme_custom_select($('.woocommerce-ordering select'));
			
		})
		.fail(function() {
			location.reload();
		})
	}
	
})(jQuery);
