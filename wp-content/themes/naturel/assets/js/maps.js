
	
	$map_canvas = document.getElementById("map-canvas");

	if ( typeof mtheme_maps !== "undefined" && $map_canvas != null) {
		
		function m_wedding_initialize() {
			
			var grayStyles = [ /*{
				featureType : "all",
				stylers : [ {
					saturation : -100
				}, {
					lightness : 47
				}, {
					gamma : 0.34
				} ]
			},*/ ];
			
			var $LatLng = mtheme_maps.LatLng.split(", "); 
			
			var mapOptions = {
				center : new google.maps.LatLng($LatLng[0], $LatLng[1]),
				zoom : parseInt(mtheme_maps.zoom),
				styles : grayStyles,
			};
			
			var map = new google.maps.Map(document.getElementById("map-canvas"),
					mapOptions);
			
			var marker = new google.maps.Marker({
				map : map,
				position : map.getCenter(),
				icon: mtheme_maps.icon,

			});
		
			var infowindow = new google.maps.InfoWindow();
			infowindow.setContent(mtheme_maps.desc_contact);
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
			}); 
		}
		
		google.maps.event.addDomListener(window, 'load', m_wedding_initialize());
	}	
	
