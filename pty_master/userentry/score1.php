<?
	#START
	###### This Program is copyright Sapphire Research and Development co.,ltd ########
	#########################################################
	$ApplicationName= "AdminReport";
	$module_code = "statuser";
	$process_id = "display";
	$VERSION = "9.1";
	$BypassAPP= true;
	#########################################################
	#Developer::Pairoj
	#DateCreate::29/03/2007
	#LastUpdate::29/03/2007
	#DatabaseTable::schooll_name, login
	#END
	#########################################################
	
	session_start();
	set_time_limit(8000);
	if($_GET[xstaff_id]==""){
	$xstaff_id=$_SESSION['session_staffid'];	
	
}		
	include ("preloading.php")  ;
	include ("../../common/common_competency.inc.php")  ;

	include ("../../common/std_function.inc.php")  ;
	include("epm.inc.php");
	
	$dbnameuse = DB_USERENTRY;
	$datekeyin = date("Y-m-d");
	### ratio ผลคูณของ qc แต่ละกลุ่ม
	//$Ratio_val = ShowQvalue($xstaff_id);
	$Ratio_val = CheckGroupKeyRatio($xstaff_id,$datekeyin);
	### ฝัง sritp คำนวณหาค่าคะแนนจุดผิด
function CalSubTractPerDay($datereq1,$get_staffid){
		global $dbnameuse;
		
$sql = "SELECT
t1.idcard,
t1.staffid,
t1.ticketid
FROM
validate_checkdata as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.ticketid = t2.ticketid
Inner Join monitor_keyin as t3  ON t1.idcard = t3.idcard AND t1.staffid = t3.staffid
where t1.staffid='$get_staffid' 
and t3.timestamp_key LIKE '$datereq1%' and t1.status_process_point='YES' group by t1.idcard";


	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$subtract = CalSubtract($rs[idcard],$rs[staffid],$rs[ticketid]); // ค่าคะแนนที่คำนวณได้
		if($subtract == NULL){ $subtract = 0;} // กรณีเป็นที่ qc แล้วค่าเป็นค่า NULL
		### update ข้อมูลที่เคยคำนวณไปแล้ว
		$sql_update = "UPDATE validate_checkdata SET status_cal='1',datecal='$datereq1'  WHERE idcard='$rs[idcard]' AND staffid='$rs[staffid]' AND ticketid='$rs[ticketid]' and status_cal='0' ";
		mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
		
		$sql_subtract = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,num_p)VALUE('$rs[staffid]','$datereq1','$subtract','1')";
		mysql_db_query($dbnameuse,$sql_subtract)or die(mysql_error()."$sql_subtract<br>LINE__".__LINE__);
	
	}//end while($rs = mysql_fetch_assoc($result)){
}// end 	function CalSubTractPerDay(){
	
	
	## end 
	$sql =  " SELECT  numkpoint  FROM  stat_user_keyin WHERE  staffid = '$xstaff_id' AND datekeyin='".date("Y-m-d")."'" ;
	$result = mysql_db_query($dbnameuse,$sql) ;
	$rs = mysql_fetch_assoc($result);
	
	$Score = ( $rs[numkpoint] ) ? number_format($rs[numkpoint]) : "0";
	$xdatekey = date("Y-m-d");
	
	CalSubTractPerDay($xdatekey,$xstaff_id);// คำนวณหาค่าคะแนนจุดผิด
	### แสดงข้อมูลรวมทั้งหมด ROUND(SUM(kpoint_add),2) AS sumadd
	$sql_numkpoint = "SELECT ROUND(SUM(numkpoint),2) as sumkpoint FROM stat_user_keyin WHERE staffid='$xstaff_id' AND datekeyin LIKE '".date("Y-m")."%' ";
	$result_numkpoint = mysql_db_query($dbnameuse,$sql_numkpoint);
	$rs_kpoint = mysql_fetch_assoc($result_numkpoint);
	$ScoreTotal = $rs_kpoint[sumkpoint];/// ค่าคะแนนรวมทั้งหมดของเดือนนี้
	###  ค่าคะแนนลบทั้งหมดของเืดือนนี้ $Ratio_val
	
	//$sql_subtract = "SELECT SUM(spoint) as sumsubtract FROM stat_subtract_keyin WHERE staffid='$xstaff_id' AND datekey LIKE '".date("Y-m")."%' ";
	$sql_subtract = "SELECT sum(t1.spoint*t2.rpoint) as sumsubtract FROM stat_subtract_keyin as t1 Inner Join stat_user_keyin as t2 ON t1.staffid = t2.staffid AND t1.datekey = t2.datekeyin
WHERE t1.staffid='$xstaff_id' AND t1.datekey LIKE '".date("Y-m")."%'";
	$result_subtract = mysql_db_query($dbnameuse,$sql_subtract);
	$rs_subtract = mysql_fetch_assoc($result_subtract);
	$ScoreSubtractTotal = $rs_subtract[sumsubtract]; // ค่าคะแนนลบทั้งหมด
	
	###  ค่าคะแนนลบวันที่คีย์ปัจจุบัน
	$sql_subtract1 = "SELECT spoint FROM stat_subtract_keyin WHERE staffid='$xstaff_id' AND datekey = '".date("Y-m-d")."'";
	$result_subtract1 = mysql_db_query($dbnameuse,$sql_subtract1);
	$rs_sub1 = mysql_fetch_assoc($result_subtract1);
	$ScoreSubtract = $rs_sub1[spoint]*$Ratio_val; // ค่าคะแนนลบวันที่คีย์ข้อมูล
	
	 
?>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

<link href="../../common/style.css" type="text/css" rel="stylesheet">

<style type="text/css">
<!--
body {
	background-color: #003366;
	background-image: url(images/score_bg_main.gif);
	background-repeat: no-repeat;
}
.style1 {
	font-size: 36px;
	color: #FF0000;
}
.style89 {font-size: 30px; font-weight: bold; font-family: Tahoma; color: #33CC33; }
.style91 {font-size: 30px; font-weight: bold; font-family: Tahoma; color: #990000; }

-->
</style></head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="2">
  <tr>
    <td height="16" colspan="2" align="center" class="fillcolor_loginleft2"><strong class="ptext_w">Score</strong></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#333333">
    <table width="100%" border="0" cellpadding="2" cellspacing="1">
      <tr>
   		 <td width="50%" height="16" align="center" class="fillcolor_loginleft2"><strong>TODAY</strong></td>
    		<td width="50%" align="center" class="fillcolor_loginleft2"><strong>TOTAL</strong></td>
  		</tr>
      <tr>
        <td width="50%" align="center" background="images/score_bg.gif" class="style89"> <strong>
          <?=$Score?> 
          </strong></td>
        <td width="50%" align="center" background="images/score_bg.gif" class="style89"><?=number_format($ScoreTotal,2)?></td>
      </tr>
      <tr>
        <td align="center" background="images/score_bg.gif" class="style91"><?=$ScoreSubtract?></td>
        <td align="center" background="images/score_bg.gif" class="style91"><?=number_format($ScoreSubtractTotal,2)?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
