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

//$today_long = date("j") . " " . $monthname[date("j")] . " " . (date("Y") + 543);
$today = date("j") . "/" . date("m") . "/" . (date("Y") + 543);

$unit = "13000200"; //เชียงใหม่ เขต 2

$krnullex  = "select * from position_null  where  persontype2_now = 'ข้าราชการครู' ";
$krsultnullex =  mysql_query($krnullex);
$krrnullex = mysql_num_rows($krsultnullex);

$krex  = "select  *  from general where persontype2_now = 'ข้าราชการครู'  and   (unit <> '13099999') ";
$krsultex =  mysql_query($krex);
$krrex = mysql_num_rows($krsultex);

$teacher = $krrex+$krrnullex;


$kre  = "select *  from general where persontype2_now = 'ข้าราชการพลเรือน'   and (unit <> '13099999')  ";
$krsulte =  mysql_query($kre);
$krre = mysql_num_rows($krsulte);

$krnull = "select * from position_null  where  persontype2_now = 'ข้าราชการพลเรือน' ";
$krsultnull =  mysql_query($krnull);
$krrnull = mysql_num_rows($krsultnull);
$other = $krre+$krrnull;



//$title="ระบบสนับสนุนการจัดการสมรรถนะบุคลากรทางการศึกษา";
//$subtitle="อัตราส่วนบุคลากรทางการศึกษาที่มีรายชื่อในบัญชีถือจ่ายเงินเดือน จ.18";

$title="สัดส่วนบุคคลากรทางการศึกษาข้าราชการและบุคคลากรทางการศึกษา สำนักงานเขตพื้นที่การศึกษาเชียงใหม่ เขต 2";
//$subtitle = "จำแนกตามประเภทของบุคลากร";
$subtitle = "รายงาน ณ วันที่ $today" ;

$namelist = "ข้าราชการครูและบุคลากรทางการศึกษา;บุคลากรทางการศึกษาอื่น ตามมาตรา 38 ค. (2)";
$datalist = "$teacher;$other";


$graphurl = $graph_path . "?category=$namelist&data1=$datalist&outputstyle=&numseries=1&seriesname=&graphtype=pie&graphstyle=$graph_style&title=$title&subtitle=$subtitle";


//$time_end = getmicrotime(); writetime2db($time_start,$time_end); 
header("Location: $graphurl");
?>