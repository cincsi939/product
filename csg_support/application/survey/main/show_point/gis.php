<?
/**
* @comment GIS
* @projectCode PS56DSDPW04
* @tor  -
* @package core
* @author Jakrit Monkong
* @access private
* @created 28/07/2014
*/
include('../../lib/class.function.php');
include "../dataxml.php";
$getidcard = $_GET['id'];
$dataA = $_GET['x'];
$dataB = $_GET['y'];
$name = $xml->Position1->NodeData1." ".$xml->Position1->NodeData4." ".$xml->Position1->NodeData5;
$picture= $xml->Position1->NodeData42->DataImage;
$gender = $showgender;
$address = $showaddress;
$money = $showmoney;

?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="util.js"></script>
<script type="text/javascript" src="util_control.js"></script>
	<script language="javascript">
	var xml = [];
	var all_markers = [];
	
	
	function addlayerXML(obj){
	 var url = 'xml_files/data_xml.php?id=<? echo $getidcard;?>&x=<? echo $dataA;?>&y=<? echo $dataB;?>';
	if(!xml[url]){
			
			downloadUrl(url, function(data) {
				
				xml[url] = data;
				all_markers[url] = [];
			  	var markers = data.documentElement.getElementsByTagName("marker");
			  
			 	for (var i = 0; i < markers.length; i++) {
					var latlng = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),
											parseFloat(markers[i].getAttribute("lng")));
					all_markers[url][i] = createMarker(markers[i].getAttribute("name"), markers[i].getAttribute("identify"), markers[i].getAttribute("icon"), latlng);
				
			   }
			 });
	}else{
		if(obj.checked){
				addpoint(all_markers[url]);
				
		}else{
				removepoint(all_markers[url]);
		}
	}
}

	
 function initialize() {
    var myLatlng = new google.maps.LatLng(<? echo $dataA;?>,<? echo $dataB;?>);
    var myOptions = {
      zoom: 15,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	addlayerXML(document.getElementById("data_xml_danger"));
  }
	/*
========== On Load Map ===========
*/
google.maps.event.addDomListener(window, 'load', initialize);

	</script>
 <input type="checkbox" id="data_xml_danger" name="data_xml_danger" onClick="addlayerXML(this);" style="display:none;" />
<div id="map_canvas" style="height:480px; width:99%; border:1px #CCC solid;"></div>
		