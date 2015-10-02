var xml = [];
var infowindow;

function addpoint(parr){
		for (var i = 0; i < parr.length; i++) { 
			 parr[i].setMap(map);
		}
 }
	
 function addpolygon(poly){ 
		poly.setMap(map);
 }
	
 function removepoint(parr){
		for (var i = 0; i < parr.length; i++) { 
			parr[i].setMap(null);
		}
 }
	
 function removepolygon(poly){
		poly.setMap(null);
 }
 
 function createMarker(name, identify, icon, latlng, width, height) {
	 var width = (width)?width:670;
	 var height = (height)?height:300;
    var marker = new google.maps.Marker({position: latlng, icon:icon, title:name, map: map});
	var str_html = '<table width="'+width+'" border="0" cellspacing="1" cellpadding="2"><tr><td>'+name+'</td></tr><tr><td><iframe src="'+identify+'" width="'+width+'" height="'+height+'" frameborder="0"></iframe></td></tr></table>';
    google.maps.event.addListener(marker, "click", function() {
      if (infowindow) infowindow.close();
      infowindow = new google.maps.InfoWindow({content: str_html});
      infowindow.open(map, marker);
    });
    return marker;
  }