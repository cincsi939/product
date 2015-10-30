<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_graph";
$module_code 		= "listj18"; 
$process_id			= "listj18";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################

ini_set("display_errors","1");

include "../../../../config/config_hr.inc.php";
include "../../../../common/common_competency.inc.php";
//include "../../libary/function.php";
include "../phpconfig.php";
//include "../db.inc.php";

include "graph_path.inc.php";

//$time_start = getmicrotime();
conn2DB();

$ampname = array();
$ampname[1] 	= "สำนักงานพื้นที่การศึกษา";
$result 	= mysql_query("select * from `area_ampur`;");
while($rs = mysql_fetch_assoc($result)){
	$ampname[$rs[ampid]] = "อำเภอ".$rs[ampname];
}

$pgroup_array = array(
	"1"=>"สายงานบริหารการศึกษา",
	"2"=>"สายงานนิเทศการศึกษา",
	"3"=>"สายงานบริหารสถานศึกษา",
	"4"=>"สายงานการสอน"
);


$today = date("j") . "/" . date("m") . "/" . (date("Y") + 543);

$unit = "13000200"; //เชียงใหม่ เขต 2

$ampdata = array();

//เป็นข้าราชการครูและบุคลากรทางการศึกษาที่มีวิทยฐานะ
$krex  = "select  t2.ampid,count(*) as ncount  from general t1 left join  temp_listapprove t2 on t1.unit = t2.id  where t1.persontype2_now = 'ข้าราชการครู'   and (t1.unit <> '13099999') and positiongroup = '$pgroup'  group by t2.ampid ";
$krsultex =  mysql_query($krex);
while ($rs1 = mysql_fetch_assoc($krsultex)){
	$ampdata[$rs1[ampid]] += $rs1[ncount];
}		




$title="สัดส่วนบุคคลากรทางการศึกษาข้าราชการและบุคคลากรทางการศึกษา สำนักงานเขตพื้นที่การศึกษาเชียงใหม่ เขต 2 จำแนกรายอำเภอ";
$title="สัดส่วนบุคคลากรทางการศึกษาข้าราชการและบุคคลากรทางการศึกษา " . $pgroup_array[$pgroup] . " จำแนกรายอำเภอ";
//$title="อัตราส่วนบุคลากรทางการศึกษาที่มีรายชื่อในบัญชีถือจ่ายเงินเดือน จ.18 จำแนกรายอำเภอ";
//$subtitle = "จำแนกรายอำเภอ";
$subtitle = "รายงาน ณ วันที่ $today" ;
$namelist = "";
$datalist = "";

foreach ($ampdata as $ampid => $ncount){
	if ($namelist > ""){
		$namelist .= ";";
		$datalist .= ";";
	}

	$namelist .= $ampname[$ampid];
	$datalist .= $ncount;
}

$graphurl = $graph_path . "?category=$namelist&data1=$datalist&outputstyle=&numseries=1&seriesname=&graphtype=pie&graphstyle=$graph_style&title=$title&subtitle=$subtitle";


//$time_end = getmicrotime(); writetime2db($time_start,$time_end); 
header("Location: $graphurl");
?>