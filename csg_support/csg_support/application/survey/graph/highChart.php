<?php
/**
 * @comment 	Chart pie
 * @projectCode
 * @tor 	   
 * @package		core
 * @author		Phada Woodtikarn(phada@sapphire.co.th)
 * @created    	14/09/2014
 * @access     	public
 */
function getPie($graphdiv,$title,$categories,$sliced,$name,$data,$pie3D){
	if($pie3D=='true'){
	$text3D = ',options3d: {
				enabled: true,
				alpha: 45,
				beta: 0
				}';
	$text3D_2 = 'depth: 35,';
	$text3D_3 = 'credits: {
				enabled: false
				},';
	}else{
		$text3D = '';
		$text3D_2 = '';
		$text3D_3 = '';
	}
	$show = $graphdiv;
	$ui = "
		<script>
			$(function () {
			$('#".$show."').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,//null,
					plotShadow: false".$text3D."
				},
					title: {
					text: '".$title."'
				},".$text3D_3."
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y} คน</b><br>ร้อยละ: <b>{point.percentage:.2f} %</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',".$text3D_2."
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>', //{point.percentage:.1f}
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
				type: 'pie',
				name: '".$categories."',
				data: [
		";
	$name = explode(',',$name);
	$data = explode(',',$data);
	$sliced = explode(',',$sliced);
	for($i=0;$i<count($name);$i++){
		if($i!=0){$ui .= ",";
	}
	$ui .= "
		{
			name: '".$name[$i]."',
			y: ".$data[$i].",
			sliced: ".$sliced[$i].",
			selected: ".$sliced[$i]."
		}
	";
	}
	$ui .= "   
				]
				}]
				});
			});
		</script>
	";	
	return $ui;
} 
?>
<!doctype html>
<html>
<head>
<meta charset="TIS-620">
<title>HighChart</title>
<script language="javascript" src="../../js/jquery-1.10.1.min.js"></script>
<script language="javascript" src="../../js/highcharts4.js"></script>
<script language="javascript" src="../../js/highcharts-3d.js"></script>
<script>
	window.parent.document.getElementById('rpb_iframe').style.height="450px";
	window.parent.document.getElementById('rpb_iframe').style.width="550px";
</script>
<style>
@font-face {
    font-family: 'Thai Sans Neue Regular';
    src: url('../font/ThaiSansNeue-Regular.otf');
    src: url('../font/ThaiSansNeue-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
.highcharts-container svg text{
	font-family:Thai Sans Neue Regular !important;
}
.highcharts-title{
	font-size:22px !important;
}
.highcharts-container{
	font-family:Thai Sans Neue Regular !important;
}
.highcharts-data-labels g text tspan{
	font-size:16px !important;
}
.highcharts-tooltip text tspan{
    font-size:16px !important;
}
</style>
</head>
<body>
<?php
$connect = mysql_connect('localhost','family_admin','F@m!ly[0vE');
if(!$connect){
	echo "Not connect";
	die();
}
mysql_select_db('question_project',$connect);
mysql_query('SET NAMES TIS620');
if(isset($_GET['chart']) && $_GET['chart'] == 'NM1'){
	$sql = 'SELECT
				district,
				SUM(count_member) as Total
			FROM
				view_NM1
			GROUP BY
				district_id
			ORDER BY
				district_id';
	$sqlTotal = 'SELECT
					SUM(count_member) as Total
				FROM
					view_NM1';
}else{
	$sql = 'SELECT
				district,
				SUM(amount_total) as Total
			FROM
				view_NM2
			GROUP BY
				district_id
			ORDER BY
				district_id';
	$sqlTotal = 'SELECT 
					SUM(amount_total) as Total
				FROM
					view_NM2';
}
$sumAll = 1;
$sumall = '';
$name = '';
$data = '';
/*$result = mysql_query($sqlTotal);
if($result){
	while($row = mysql_fetch_assoc($result)){
		$sumAll = $row['Total']	;
	}
}*/
$result = mysql_query($sql);
if($result){
	while($row = mysql_fetch_assoc($result)){
		//$name .= ','.$row['district'].' '.number_format(($row['Total']/$sumAll * 100),2)."%";
		$name .= ','.$row['district'];
		$data .= ','.$row['Total'];
	}
}

$name = substr($name,1);
$data = substr($data,1);
if($data == '0,0,0,0,0,0,0'){
	echo getPie('graphdiv','จำนวนสมาชิกในครัวเรือนที่อยู่ในสภาวะลำบาก','จำนวน','false,false,false,false,false,false,false',$name,$data,'false');
}else{
	echo getPie('graphdiv','จำนวนสมาชิกในครัวเรือนที่อยู่ในสภาวะลำบาก','จำนวน','false,false,false,false,false,false,false',$name,$data,'true');
}
?>
<div id="graphdiv" style="width:500px;height:400px;"></div>
</body>
</html>