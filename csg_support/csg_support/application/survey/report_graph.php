<?php
/**
* @comment dashboard แสดง graph สำหรับแสดงในรายงาน
* @projectCode P1
* @tor  -
* @package core
* @author Suwat.k
* @access private
* @created 08/09/2015
*/
session_start();
require_once('../../common/SMLcore/SMLcoreBack.php');
include("../../config/config_epm.inc.php");
// include("class/class.data_format.php");
// include("class/class.CheckAgePreName.php");

// include("function/function_report_graph.php"); # ข้อมูลรายงาน

// function แสดงผลค่าของกราฟ สามารถสร้างได้หลายรายงาน

function GetDataGrahp($id,$yy,$gid='',$part_id='',$areaid='',$prev_yy='',$cs_yy='',$cs_prev_yy=''){
	global $dbname;
	if($id == '440'){
	$sql = 'SELECT
				t1.area_part AS caption,
				t2.*
			FROM
				opp_master.area_part AS t1
			LEFT JOIN(
			SELECT
				Sum(t2.register_num) AS sum_all,
				t1.partid
			FROM
				 opp_master.area_part as t1
				 LEFT JOIN opp_data.report_eqmain as t2 ON t1.partid = t2.part_id AND t2.yy =  "'.$yy.'"
				 INNER JOIN (SELECT t1.yy, Sum(t1.register_num) AS num1 FROM
				 opp_data.report_eqmain AS t1 WHERE t1.yy = "'.$yy.'") AS t3 ON t2.yy = t3.yy
			GROUP BY t1.partid) AS t2 ON t1.partid = t2.t2.partid
			ORDER BY t1.partid';
	}
	
	if($id == '442'){
	$sql = 'SELECT
				 t1.mm_name AS caption,
				 t2.num1 AS sum_all
				FROM
					opp_data.month_config AS t1
				LEFT JOIN (
					SELECT
						(t2.mm * 1) AS mm,
						t2.yy1,
						Sum(

							IF (
								t2.register_num != "",
								t2.register_num,
								0
							)
						) AS num1,						
						t1.ccDigi
					FROM
						opp_master.ccaa AS t1
					LEFT JOIN opp_data.report_eqmain AS t2 ON t1.areaid = t2.area_id
					INNER JOIN opp_data.ccaa AS t3 ON CONCAT(
						SUBSTR(t1.ccDigi, 1, 5),
						"000"
					) = t3.ccDigi
					INNER JOIN (
						SELECT
							t1.yy,
							Sum(t1.register_num) AS num1
						FROM
							opp_data.report_eqmain AS t1
						WHERE
							t1.yy = "'.$yy.'"
						AND SUBSTR(t1.area_id, 1, 2) = "'.$areaid.'"
					) AS t3 ON t2.yy = t3.yy
					AND t2.yy = "'.$yy.'"
					WHERE
						SUBSTR(t1.ccDigi, 1, 2) = "'.$areaid.'"
					GROUP BY
						t2.yy1,
						t2.mm
				) AS t2 ON t1.mm_id = t2.mm
				ORDER BY
					orderby ASC';
	
	}
	
	if($id == '444'){
		$sql = 'SELECT
					t1.mm_name AS caption,
					t2.num1 AS sum_all
					FROM
					opp_data.month_config AS t1
					LEFT JOIN (
					SELECT
					(t2.mm*1) AS mm,
					t2.yy1,
					Sum(IF(t2.register_num !="",t2.register_num,0)) AS num1,
					t1.ccDigi
					FROM
					 opp_master.ccaa AS t1
					LEFT JOIN opp_data.report_eqmain AS t2 ON t1.areaid = t2.area_id
					INNER JOIN opp_data.ccaa AS t3 ON t1.ccDigi = t3.ccDigi
					INNER JOIN (SELECT
					t1.yy,
					Sum(t1.register_num) AS num1
					FROM
					opp_data.report_eqmain AS t1
					WHERE t1.yy = "'.$yy.'" AND SUBSTR(t1.area_id,1,4) = "'.$areaid.'"
					) AS t3 ON t2.yy = t3.yy AND t2.yy = "'.$yy.'"
					WHERE SUBSTR(t1.ccDigi,1,4) = "'.$areaid.'"
					GROUP BY t2.yy1, t2.mm) AS  t2 ON t1.mm_id = t2.mm
					ORDER BY
					orderby ASC';
	}
	
	if($id == '445'){
		$sql = 'SELECT
					t1.mm_name AS caption,
					t2.num1 AS sum_all
					FROM
					opp_data.month_config AS t1
					LEFT JOIN (
					SELECT
					(t2.mm*1) AS mm,
					t2.yy1,
					Sum(IF(t2.register_num !="",t2.register_num,0)) AS num1,
					t1.ccDigi
					FROM
					 opp_master.ccaa AS t1
					LEFT JOIN opp_data.report_eqmain AS t2 ON t1.areaid = t2.area_id
					INNER JOIN opp_data.ccaa AS t3 ON t1.ccDigi = t3.ccDigi
					INNER JOIN (SELECT
					t1.yy,
					Sum(t1.register_num) AS num1
					FROM
					opp_data.report_eqmain AS t1
					WHERE t1.yy =  "'.$yy.'" AND SUBSTR(t1.area_id,1,6) = "'.$areaid.'"
					) AS t3 ON t2.yy = t3.yy AND t2.yy = "'.$yy.'"
					WHERE SUBSTR(t1.ccDigi,1,6) = "'.$areaid.'"
					GROUP BY t2.yy1, t2.mm) AS  t2 ON t1.mm_id = t2.mm
					ORDER BY
					orderby ASC';
	
	}
	
	if($id == '446'){
		$sql =  'SELECT
					t1.mm_name AS caption,
					SUM(IF(t2.month_regis = t1.mm_id,1,0)) AS sum_all
					FROM
					opp_data.month_config AS t1
					LEFT JOIN 
					(SELECT
					t1.eq_gid,
					t2.num,
					SUBSTR(t1.eq_register_date,6,2)*1 AS month_regis
					FROM
					opp_data.eq_person AS t1
					INNER JOIN opp_master.month_name AS t2 ON t1.eq_b4preg_birthmonth = t2.num
					INNER JOIN opp_usermanager.org_staffgroup AS t3 ON t1.eq_gid = t3.gid
					WHERE
					t3.gid = "'.$gid.'" AND
					t1.eq_register_date BETWEEN "'.$cs_prev_yy.'-10-01" AND "'.$cs_yy.'-09-30") AS t2 ON t1.mm_id = t2.num
					LEFT JOIN
					(SELECT
					t3.gid,
					COUNT(t1.eq_idcard) AS numall,
					SUM(IF(t1.eq_b4preg_birthyear BETWEEN '.$prev_yy.' AND '.$yy.',1,0)) AS nummath,
					SUM(t1.eq_embryo_number) AS numchild
					FROM
					opp_data.eq_person AS t1
					INNER JOIN opp_master.month_name AS t2 ON t1.eq_b4preg_birthmonth = t2.num
					INNER JOIN opp_usermanager.org_staffgroup AS t3 ON t1.eq_gid = t3.gid
					WHERE t3.gid = "'.$gid.'" AND t1.eq_register_date BETWEEN "'.$cs_prev_yy.'-10-01" AND "'.$cs_yy.'-09-30") AS t3 ON t2.eq_gid = t3.gid
					GROUP BY t1.mm_id
					ORDER BY t1.orderby';
	
	
	}
	if($sql != ""){
		$result = mysql_db_query($dbname,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			$arr[$i]['caption'] =  $rs['caption'];
			$arr[$i]['value'] =  $rs['sum_all'];
			$i++;
		}
	}
	return $arr;
}

?>
<html>
<head>
<!--	<script type="text/javascript" src="./js/fancybox/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="./js/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./js/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./js/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" /> -->
	<script src="../../common/SMLcore/TheirParty/js/jquery-1.8.1.min.js"></script>
<script src="../../common/SMLcore/Plugin/HighCharts/highcharts.min.js"></script>
<script>
	function pieGender2( myID, data, h, w , fontSize){
		height = (h)?h:330;
		width = (w)?w:330;
		fontSize = (fontSize)?fontSize:16;
		fontSizePercent = fontSize/2;
		$('#'+myID).highcharts({
			chart: {
				type: 'pie',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				width: width
			},
			
			title: {
				text: ''
			},
			lang: {
			decimalPoint: ','
			},
			tooltip: {
				valueSuffix: 'คน',
				pointFormat: '{series.name}: <b>{point.y}</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						formatter: function() {
								return  '<b>' + this.point.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</b>';
						 },
						 style: {
								fontWeight: 'bold',
								fontSize: '14px'
							}
					},
					showInLegend: true
				}
			},
			series: [{
				type: 'pie',
				name: 'จำนวนผู้ลงทะเบียน',
				data: data
				/* Ex Data
				[
					['Firefox',   45.0],
					['IE',       26.8],
					{
						name: 'Chrome',
						y: 12.8,
						sliced: true,
						selected: true
					},
					['Safari',    8.5],
					['Opera',     6.2],
					['Others',   0.7]
				]
				*/
			}]
    	});
	}
</script>
<style>
.tbl_dashboard{
	 border : 1px solid #666;
	 border-radius: 5px 5px 5px 5px;
	 box-shadow: 3px 3px 5px #888888;
	 background-color:#444;
}

.img_icon{
	border : 1px solid #9C0;
	 border-radius: 3px 3px 3px 3px;
	 box-shadow: 1px 1px 2px #888888;
	 background-color:#FFF;
}
.exsum_woman_data{
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
	font-size:65px;
}
.exsum_woman_text{
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
	font-size:34px;
	color:#060;
}
</style>
</head>
<body>
<div id="pie1" style="width:300px; height:400px;"></div>
<?php 
$arr_data = GetDataGrahp($_GET['id'],$_GET['yy'],$_GET['gid'],$_GET['part_id'],$_GET['areaid'],$_GET['prev_yy'],$_GET['cs_yy'],$_GET['cs_prev_yy']); # ดึงข้อมูลสำหรับแสดงใหน graph

$count_data = count($arr_data);
if($count_data > 0){
	foreach($arr_data as $key => $val){
		if($graph_data != "") $graph_data .= ",";
		$graph_data .= "['".$val['caption']."',".intval($val['value'])."]";	
	}
	#echo "jsdata ::".$graph_data."<hr>";
	
if($_GET['debug'] == "on"){
	echo "<pre>";
	print_r($arr_data);
	echo "<hr>datagraph :".$graph_data;
	die();
}	
	
?>
<script>
$(function(){
	pieGender2('pie1',[	<?php echo $graph_data; ?>],350, 350,10);
		
});
</script>
<?
}
?>

</body>
