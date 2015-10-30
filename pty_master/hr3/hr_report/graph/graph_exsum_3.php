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
include "../exsum_function.inc.php";

//$time_start = getmicrotime();
conn2DB();


$pgroup_array = array(
	"1"=>"สายงานบริหารการศึกษา",
	"2"=>"สายงานนิเทศการศึกษา",
	"3"=>"สายงานบริหารสถานศึกษา",
	"4"=>"สายงานการสอน"
);


$today = date("j") . "/" . date("m") . "/" . (date("Y") + 543);

$unit = "13000200"; //เชียงใหม่ เขต 2



$namelist = "";
$datalist = "";




$gid = 1; // 1 = ข้าราชการครู , 2 = พลเรือน

$sql1 = " SELECT  *  FROM  exsummenu  WHERE  ( PARENT_ID = '$parent' )  AND  ( POSITION <>  0 )  AND  ( NGROUP = '$gid' ) ORDER BY  POSITION ASC ";
$result1 = mysql_query($sql1);
if (mysql_errno() != 0 ) { echo "<hr> <b> " .mysql_error()     .  "<b><hr>  " ;  }
$n =1;
while($rs1 = mysql_fetch_assoc($result1)){
	$Gp = $rs1[GROUP_POSITION] ;

	if($rs1[NGROUP] == 2){
		$m=5;$rdetail = 1;$detail="detail";
	}else if($rs1[NLABEL] == "ยังไม่มีวิทยฐานะ"){
		$m=7;$detail="detail2";
	}else{
		$m=1;$detail="detail2";
	}

	if ($namelist > ""){
		$namelist .= ";";
		$datalist .= ";";
	}

	$nm = countnum($rs1[KEYWORD],$m);
	$namelist .= $rs1[NLABEL];
	$datalist .= $nm;

}


//$title="สัดส่วนบุคคลากรทางการศึกษาข้าราชการและบุคคลากรทางการศึกษา สำนักงานเขตพื้นที่การศึกษาเชียงใหม่ เขต 2 จำแนกรายอำเภอ";
$title="สัดส่วนบุคคลากรทางการศึกษาข้าราชการและบุคคลากรทางการศึกษา " . $pgroup_array[$pgroup] ;
//$title="อัตราส่วนบุคลากรทางการศึกษาที่มีรายชื่อในบัญชีถือจ่ายเงินเดือน จ.18 จำแนกรายอำเภอ";
//$subtitle = "จำแนกรายอำเภอ";
$subtitle = "รายงาน ณ วันที่ $today" ;


$graphurl = $graph_path . "?category=$namelist&data1=$datalist&outputstyle=&numseries=1&seriesname=&graphtype=pie&graphstyle=$graph_style&title=$title&subtitle=$subtitle";


//$time_end = getmicrotime(); writetime2db($time_start,$time_end); 
header("Location: $graphurl");
?>