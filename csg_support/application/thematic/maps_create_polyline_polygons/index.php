<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" type="text/css" href="include.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Wolfgang Pichler" />
<meta name="URL" content="http://www.wolfpil.de" />

<!-- See also the official example at:
  http://gmaps-samples.googlecode.com/svn/trunk/poly/area_length.html -->

<title>Switch between Polylines and Polylgons</title>

<style type="text/css">

v\:* { /* Only for IE */
	behavior:url(#default#VML);
}

body { height: 600px; }

h3 { margin-left: 10px; }

#map { position: absolute;
	top: 50px;
	left: 15px;
	width: 550px;
	height: 400px;
}

#descr { position:absolute;
	top:40px;
	left: 580px;
	width: 250px;
}


.button { display: block;
	width: 180px;
	border: 1px Solid #565;
	background-color:#F5F5F5;
        padding: 3px;
        text-decoration: none;
	font-size:smaller;
}

.button:hover { background-color: white; }

.tooltip { text-align: center;
	opacity: .70;
	-moz-opacity:.70;
	filter:Alpha(opacity=70);
	white-space: nowrap;
	margin: 0;
	padding: 2px 0.5ex;
	border: 1px solid #000;
	font-weight: bold;
	font-size: 9pt;
	font-family: Verdana;
	background-color: #fff;
}

</style>

<script src="http://maps.google.com/maps?file=api&amp;v=2.173&amp;sensor=false&amp;key=ABQIAAAA2WT7TMv_xtS7n749NKN8_BTzklmoEiq7IrZu1grXvam2fjRdBxSECUF_HD9hdNmJCsuG47IvwV3Vgw" type="text/javascript">
</script>

</head>

<body onload="buildMap()" onunload="GUnload()">

<h3>Switch between Polylines and Polygons</h3>

<div id="map"> </div>

<form id="f" action="">
<table id="descr" border="0" cellspacing="10" cellpadding="1">
<tr><td>
Click on the map to set markers and polylines or polygons.
</td></tr>
<tr><td><DIV id="status"></DIV></td></tr>
<tr><td>
<DIV id="div_points" style="display:none;"></DIV>
<textarea name="txt_points" id="txt_points" cols="50" rows="20" ></textarea>
<div class="button"><input type="radio" name="mode" checked="checked" onclick="toggleMode()" /> Polyline Mode<br />

<input type="radio" name="mode" onclick="toggleMode()" /> Polygon Mode
</div>
</td></tr><tr><td>

<a href="#" class="button" style="text-align:center" onclick="clearMap();return false;">Clear Map</a>
</td></tr><tr><td style="padding-right:19px; height:30px;">
<span class="include"><a href="index.php">Back</a></span>
</td></tr>
</table></form>

 <br/>


<script type="text/javascript">
//<![CDATA[

// Global variables
var map, poly;
var count = 0;
var points = new Array();
var markers = new Array();
var icon_url ="http://labs.google.com/ridefinder/images/";
var tooltip;
var report= document.getElementById("status");

var mp = new Array();





function addIcon(icon) { // Add icon properties

 icon.shadow= icon_url + "mm_20_shadow.png";
 icon.iconSize = new GSize(12, 20);
 icon.shadowSize = new GSize(22, 20);
 icon.iconAnchor = new GPoint(6, 20);
 icon.infoWindowAnchor = new GPoint(5, 1);
}


function showTooltip(marker) { // Display tooltips

 tooltip.innerHTML = marker.tooltip;
 tooltip.style.display = "block";

 // Tooltip transparency specially for IE
 if(typeof(tooltip.style.filter) == "string") {
 tooltip.style.filter = "alpha(opacity:70)";
 }

 var currtype = map.getCurrentMapType().getProjection();
 var point= currtype.fromLatLngToPixel(map.fromDivPixelToLatLng(new GPoint(0,0),true),map.getZoom());
 var offset= currtype.fromLatLngToPixel(marker.getLatLng(),map.getZoom());
 var anchor = marker.getIcon().iconAnchor;
 var width = marker.getIcon().iconSize.width + 6;
// var height = tooltip.clientHeight +18;
 var height = 10;
 var pos = new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(offset.x - point.x - anchor.x + width, offset.y - point.y -anchor.y - height));
 pos.apply(tooltip);
}


function buildMap() {

 var container = document.getElementById("map");
 map = new GMap2(container, {draggableCursor:"auto", draggingCursor:"move"});
map.addControl(new GLargeMapControl());
map.addControl(new GOverviewMapControl());
map.addControl(new GScaleControl());
map.addControl(new GMapTypeControl());
//map.addControl(new GGoogleBar());

 // Add a div element for toolips
 tooltip = document.createElement("div");
 tooltip.className = "tooltip";
 map.getPane(G_MAP_MARKER_PANE).appendChild(tooltip);

 // Load initial map and a bunch of controls
 map.setCenter(new GLatLng(14.200488387358332,100.634765625), 7);
 map.addControl(new GLargeMapControl3D()); // Zoom control
 map.addMapType(G_PHYSICAL_MAP);
 // Create a hierarchical map type control
 var hierarchy = new GHierarchicalMapTypeControl();
 // make Hybrid the Satellite default
 hierarchy.addRelationship(G_SATELLITE_MAP, G_HYBRID_MAP, "Labels", true);
 // add the control to the map
 map.addControl(hierarchy);

 map.addControl(new GScaleControl()); // Scale bar
 map.disableDoubleClickZoom();
 addMapPoint();
 // Add listener for the click event
 GEvent.addListener(map, "click", leftClick);

}

function addMapPoint(){
	// Red marker icon
	var icon = new GIcon();
	icon.image = icon_url + "mm_20_red.png";
	addIcon(icon);
	for(var n = 0; n < mp.length; n++) {
		//alert(mp[n]);
		count = n;

		arrp = mp[n].split(',');
		var point = new GLatLng(arrp[1], arrp[0]);

		  // Make markers draggable
		  var marker = new GMarker(point, {icon:icon, draggable:true, bouncy:false, dragCrossMove:true});
		  map.addOverlay(marker);
		  marker.content = count;
		  markers.push(marker);
		  marker.tooltip = "Point "+n+"="+point;

		  GEvent.addListener(marker, "mouseover", function() {
		   showTooltip(marker);
		  });

		  GEvent.addListener(marker, "mouseout", function() {
		   tooltip.style.display = "none";
		  });

		  // Drag listener
		  GEvent.addListener(marker, "drag", function() {
		   tooltip.style.display= "none";
		   drawOverlay();
		  });

		  // Click listener to remove a marker
		  GEvent.addListener(marker, "click", function() {
		   tooltip.style.display = "none";

		  // Find out which marker to remove
		  /*for(var n = 0; n < markers.length; n++) {
		   if(markers[n] == marker) {
			map.removeOverlay(markers[n]);
			break;
		   }
		  }*/

		  // Shorten array of markers and adjust counter
		  markers.splice(n, 1);
		  if(markers.length == 0) {
			count = 0;
		  }
		   else {
			count = markers[markers.length-1].content;
			drawOverlay();
		  }
		  });
		 drawOverlay();
	}
}

function leftClick(overlay, point) {

 if(point) {
  count++;

  // Red marker icon
  var icon = new GIcon();
  icon.image = icon_url + "mm_20_red.png";
  addIcon(icon);

  // Make markers draggable
  var marker = new GMarker(point, {icon:icon, draggable:true, bouncy:false, dragCrossMove:true});
  map.addOverlay(marker);
  marker.content = count;
  markers.push(marker);
  marker.tooltip = "Point "+ count;

  GEvent.addListener(marker, "mouseover", function() {
   showTooltip(marker);
  });

  GEvent.addListener(marker, "mouseout", function() {
   tooltip.style.display = "none";
  });

  // Drag listener
  GEvent.addListener(marker, "drag", function() {
   tooltip.style.display= "none";
   drawOverlay();
  });

  // Click listener to remove a marker
  GEvent.addListener(marker, "click", function() {
   tooltip.style.display = "none";

  // Find out which marker to remove
 /* for(var n = 0; n < markers.length; n++) {
   if(markers[n] == marker) {
    map.removeOverlay(markers[n]);
    break;
   }
  }*/

  // Shorten array of markers and adjust counter
  markers.splice(n, 1);
  if(markers.length == 0) {
    count = 0;
  }
   else {
    count = markers[markers.length-1].content;
    drawOverlay();
  }
  });
 drawOverlay();
 }
}


function toggleMode() {

 if(markers.length > 1) drawOverlay();
}


function drawOverlay(){

 // Check radio button
 var lineMode = document.forms["f"].elements["mode"][0].checked;
 var txt_points = "";
 if (poly) { map.removeOverlay(poly); }
 points.length = 0;

 for (i = 0; i < markers.length; i++) {
  points.push(markers[i].getLatLng());
  txt_points += markers[i].getLatLng().lng()+","+markers[i].getLatLng().lat()+",800.000 ";
 }
 document.getElementById("txt_points").innerHTML = txt_points;
 document.getElementById("div_points").innerHTML = points;
 if (lineMode) {
   // Polyline mode
   poly = new GPolyline(points, "#ff0000", 2, .9);
   var length = poly.getLength()/1000;
   var unit = " km";
   report.innerHTML = "Total line length:<br> " + length.toFixed(3) + unit;
  }
  else {
   // Polygon mode
   points.push(markers[0].getLatLng());
   poly = new GPolygon(points, "#ff0000", 2, .9, "#ff0000", .2);
   var area = poly.getArea()/(1000*1000);
   var unit = " km&sup2;";
   report.innerHTML = "Area of polygon:<br> " + area.toFixed(3) + unit;
  }
  map.addOverlay(poly);

}


function clearMap() {

 // Clear current map and reset globals
 map.clearOverlays();
 points.length = 0;
 markers.length = 0;
 count = 0;
 report.innerHTML = "&nbsp;";
 document.getElementById("txt_points").innerHTML ="";
}

//]]>
</script>

</body>
</html>
