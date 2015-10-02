<?php
$nochecklogin=true;
header("Content-Type: text/html; charset=TIS-620");
include("../../../config/config_epm.inc.php");
include('service_function.php');
$focus = $_GET['focus'];
$zoom = ($_GET['zoom'] != '')?$_GET['zoom']:'6';
$center = ($focus != '')?$focus:'14.954730603695,102.110529076134';
$width = ($_GET['width'] != '')?$_GET['width']:'';
$height = ($_GET['height'] != '')?$_GET['height']:'';
$emblem = 'n';

$arr_rate = array(50, 70,90,100);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title>GIS</title>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="util.js"></script>
<script type="text/javascript" src="util_control.js?run=<?echo date('Ymdhis');?>"></script>
<script type="text/javascript">
function checkAll(id){
	var tagMeta = document.getElementById(id).getElementsByTagName( 'input' );
	for(i=0;i<tagMeta.length;i++){
		if(tagMeta[i].type == 'checkbox' ){
			addlayerXML(document.getElementById(tagMeta[i].id));
		}
	}
}
</script>
<script type="text/javascript">
var hrefurl = '<?php echo $hrefurl;?>';
var type_page = '<?php echo $type_page;?>';
var map;
var all_markers = [];
var all_polygons = [];
var all_polygonMap = [];
var xml = [];
  function initialize() {
    var myLatlng = new google.maps.LatLng(<?php echo $center;?>);
    var myOptions = {
      zoom: <?php echo $zoom;?>,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		checkAll('categories');
		infoWindow.open(map);
  }

  function addlayerXML(obj){
	 var url = obj.value;
	if(!xml[url]){

			downloadUrl(url, function(data) {
				xml[url] = data;
				all_markers[url] = [];
				all_polygons[url] = Array();
				all_polygonMap[url] = Array();
			  	var markers = data.documentElement.getElementsByTagName("marker");

			 	for (var i = 0; i < markers.length; i++) {
					var latlng = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),
											parseFloat(markers[i].getAttribute("lng")));
					//alert(markers[i].getAttribute("identify"));
					//alert(markers[i].getAttribute("mapid"));
					all_markers[url][i] = createMarker(markers[i].getAttribute("name"), markers[i].getAttribute("identify"), markers[i].getAttribute("icon"), latlng,230,70);
					if(markers[i].getAttribute("shape")){
							var plarr = markers[i].getAttribute("shape").split(" ");
							//alert(plarr);
							for(var is=0;is<plarr.length;is++){
								var pll = plarr[is].split(',');
								//alert(pll);
								all_polygons[url][is] = new google.maps.LatLng(parseFloat(pll[1]), parseFloat(pll[0]));
							}
							//alert(all_polygons[obj.name]);
							all_polygonMap[url] = new google.maps.Polygon({
							  paths: all_polygons[url],
							  strokeColor: markers[i].getAttribute("boder_color"),
							  strokeOpacity: 0.8,
							  strokeWeight: 1,
							  fillColor: markers[i].getAttribute("shape_color"),
							  fillOpacity: markers[i].getAttribute("shape_opacity")
							});

							//addpolygon(all_polygonMap[obj.name]);
							all_polygonMap[url].setMap(map);
					}
			   }
			 });
	}else{
		if(obj.checked){
				addpoint(all_markers[url]);
				if(all_polygons[url].length>0){
					addpolygon(all_polygonMap[url]);
				}
				//all_polygonMap[obj.name].setMap(map);
		}else{
				removepoint(all_markers[url]);
				if(all_polygons[url].length>0){
					removepolygon(all_polygonMap[url]);
				}

		}
	}

}

/*
========== On Load Map ===========
*/
google.maps.event.addDomListener(window, 'load', initialize);

</script>
<style type="text/css">
	.mapTitle{
		<?php
		if($emblem != ''){
			if($emblem == 'n'){
				echo 'display:none;';
			}
		}
		?>
		z-index:1;
		position:absolute;
		text-align:center;
		top:45px;
		<?php
		if($width != ''){
			echo 'left:'.($width-155).'px;';
		}else{
			echo 'right:5px;';
		}
		?>
		color:#000000;
		width:75px;
		padding:0px;
		margin:0px;
		font-size:10px;
		border:#999 1px solid;
		background-color:#FFFFFF;
		/*font-weight:bold;left:0px;left:230px;*/
	}

</style>
<style>
      html, body, #map_canvas {
        margin: 0;
        padding: 0;
		<?php
		if($width != '' || $height != ''){
			if($width != ''){
				echo 'width:'.$width.'px;';
			}else{
				echo 'width:100%;';
			}

			if($height != ''){
				echo 'height:'.$height.'px;';
			}else{
				echo 'height:100%;';
			}
		}else{
		?>
			width:100%;
        	height: 100%;
		<?php
		}
		?>

      }
    </style>
</head>
<body style="background-color:#FFF; margin-left:0px; margin-top:0px; margin-right:0px;">
<div id="map_canvas" ></div>
<!--<?php echo $width;?>px<?php echo $height;?>px-->

<table border="0" cellspacing="0" cellpadding="0" style="" class="mapTitle">
        <tr  style="background-color:#333; color:#FFF;">
                 <td align="center" colspan="2">�ѭ�ѡɳ�</td>
         </tr>
         <tr>
                 <td width="25" align="center">
                 <img src="images/google_maps_marker.png"  width="20"/>
                 </td>
                 <td align="left">�ش�ԡѴ</td>
         </tr>
         <tr >
                 <td align="center">
                 <DIV style="background-color:#EEE;>">&nbsp;</DIV>
                 </td>
                 <td align="left">&nbsp;N/A</td>
         </tr>
          <tr >
                 <td align="center">
                 <?php $shape_color = getColor(100, 49); ?>
                 <DIV style="background-color:<?php echo $shape_color;?>">&nbsp;&nbsp;</DIV>
                 </td>
                 <td align="left">&nbsp;&lt; <?php echo $arr_rate[0];?>%</td>
         </tr>
         <?php
		 if($arrSetRate){
		 	foreach($arrSetRate as $kr=>$rate){
				$shape_color = getColor(100, $arr_rate[$kr]);
         ?>
         <tr >
                 <td align="center">
                 <DIV style="background-color:<?php echo $shape_color;?>">&nbsp;&nbsp;</DIV>
                 </td>
                 <td align="left">&nbsp;<?php echo ($arr_rate[$kr]<100)?'&gt;':'&nbsp;';?> <?php echo $arr_rate[$kr];?>%</td>
         </tr>
         <?php
		 	}
		 }
		 ?>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="2" id="categories" style="display:none;">
<tr>
    <td>
<input type="checkbox" id="xml" name="xml" value="xml.map_org_service.php?ac=<?php echo time();?>"  checked="checked"  onClick="addlayerXML(this);" />
</td>
</tr>
</table>
</body>
</html>
