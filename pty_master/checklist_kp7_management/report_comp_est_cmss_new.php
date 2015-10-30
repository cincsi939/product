<?
session_start();
include("checklist2.inc.php");
$dbname_pobec_tran = "temp_pobec_transfer";
if($profile_id == ""){
		$profile_id = LastProfile();
}

/*if($type_num == ""){
		$type_num = "y";
}*/

function CountSite(){
	global $dbnamemaster;
	$sql = "SELECT COUNT(CZ_ID) AS num1 ,siteid FROM view_general GROUP BY siteid";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = $rs[num1];
			
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function CountSite(){

function SaveLogEstPri($profile_id){
	global $dbname_temp;
	$arrnumsite = CountSite();
	$sql = "SELECT
		Count(edubkk_checklist.tbl_checklist_kp7.idcard) AS numall,
		Sum(if((allschool_math_sd.schoolid='' OR allschool_math_sd.schoolid Is Null) OR (allschool_math_sd.schid='' OR allschool_math_sd.schid Is Null ),1,0)) AS pri_num,
		edubkk_checklist.tbl_checklist_kp7.siteid,
		edubkk_checklist.tbl_checklist_estimate.profile_id
		FROM
		edubkk_checklist.tbl_checklist_estimate
		Inner Join edubkk_checklist.tbl_checklist_kp7 ON edubkk_checklist.tbl_checklist_estimate.siteid = edubkk_checklist.tbl_checklist_kp7.siteid
		Left Join edubkk_master.allschool_math_sd ON edubkk_checklist.tbl_checklist_kp7.schoolid = edubkk_master.allschool_math_sd.schoolid
		WHERE
		edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' AND
		edubkk_checklist.tbl_checklist_estimate.status_high_school =  '0'
		AND edubkk_checklist.tbl_checklist_estimate.siteid <>  '1001'
		group by 
		edubkk_checklist.tbl_checklist_kp7.siteid";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$num_cmss= $arrnumsite[$rs[siteid]];
				if($num_cmss > 0){
					$num_cmss = 	$num_cmss;
				}else{
					$num_cmss = 	$rs[pri_num];
				}
				$sql_up = "UPDATE tbl_checklist_estimate SET num_cmss='$num_cmss' WHERE siteid='$rs[siteid]' AND profile_id='$rs[profile_id]'";
				mysql_db_query($dbname_temp,$sql_up);
		}
		
}//end function SaveLogEstPri($profile_id){
	
	
	function SaveLogEstHigh($profile_id){
		global $dbname_temp;
		$arrnumsite = CountSite();
		$sql = "SELECT * FROM tbl_checklist_estimate WHERE status_high_school='1' AND profile_id='$profile_id' AND siteid NOT IN('10001','10002')";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT
count(edubkk_checklist.tbl_checklist_kp7.idcard) as num1,
edubkk_checklist.tbl_checklist_estimate.siteid,
edubkk_checklist.tbl_checklist_est_math.areaid
FROM
edubkk_checklist.tbl_checklist_estimate
Inner Join edubkk_checklist.tbl_checklist_est_math ON edubkk_checklist.tbl_checklist_estimate.siteid = edubkk_checklist.tbl_checklist_est_math.siteid_est
Inner Join edubkk_master.allschool ON LEFT(edubkk_checklist.tbl_checklist_est_math.areaid,2) = LEFT(edubkk_master.allschool.siteid,2)
Inner join edubkk_master.allschool_math_sd ON edubkk_master.allschool.id=edubkk_master.allschool_math_sd.schoolid
inner join edubkk_checklist.tbl_checklist_kp7 ON edubkk_master.allschool.id=edubkk_checklist.tbl_checklist_kp7.schoolid
WHERE
edubkk_checklist.tbl_checklist_estimate.status_high_school =  '1' 
AND
edubkk_checklist.tbl_checklist_estimate.siteid =  '$rs[siteid]'
and edubkk_master.allschool_math_sd.schid <> '' and edubkk_master.allschool_math_sd.schid IS NOT NULL
AND edubkk_checklist.tbl_checklist_kp7.profile_id='$profile_id'
GROUP BY edubkk_checklist.tbl_checklist_est_math.areaid
";
	//echo $sql1."<br>";
	$result1 = mysql_db_query($dbname_temp,$sql1);
			while($rs1 = mysql_fetch_assoc($result1)){

				
					$sql_update1 = "UPDATE tbl_checklist_est_math SET num_cmss='$rs1[num1]' WHERE siteid_est='$rs1[siteid]' AND areaid='$rs1[areaid]' AND profile_id='$profile_id' ";
					//echo $sql_update1."<br>";
					mysql_db_query($dbname_temp,$sql_update1);
					$num_total += $rs1[num1];
			}//end while($rs1 = mysql_fetch_assoc($result1){		
			
				$num_cmss= $arrnumsite[$rs[siteid]];
				if($num_cmss > 0){
					$num_cmss = 	$num_cmss;
				}else{
					$num_cmss = 	$num_total;
				}

			$sql_update2 = "UPDATE tbl_checklist_estimate SET num_cmss='$num_cmss' WHERE siteid='$rs[siteid]' AND profile_id='$profile_id'";
			//echo $sql_update2."<br>";
			mysql_db_query($dbname_temp,$sql_update2);
			$num_total = 0;	
			$num_cmss = 0;
		}//end while($rs = mysql_fetch_assoc($result)){
		
			
	}//end 	function SaveLogEstHigh($profile_id){
		
	
function CountSPMBangkok($sitekok,$profile_id){
		global $dbname_temp;

		$sql = "SELECT count(t3.idcard) as numid
FROM
edubkk_checklist.tbl_checklist_est_math as t1
Inner Join edubkk_master.allschool as t2 ON LEFT(t1.areaid,4) = LEFT(t2.moiareaid,4)
Inner Join edubkk_checklist.tbl_checklist_kp7 as t3 ON t2.id=t3.schoolid
Inner join edubkk_master.allschool_math_sd as t4 ON t2.id=t4.schoolid
WHERE
t1.siteid_est =  '$sitekok'";
$result =  mysql_db_query($dbname_temp,$sql);
$rs = mysql_fetch_assoc($result);
	$sql_up1 = "UPDATE tbl_checklist_estimate SET  num_cmss='".$rs[numid]."'  WHERE siteid='$sitekok'  AND profile_id='$profile_id'";
	mysql_db_query($dbname_temp,$sql_up1);
}
	
	
function CountPriBangkok($profile_id){
		global $dbname_temp;
	$sql = "SELECT
count(t3.idcard) as num1
FROM
edubkk_master.allschool as t1
Left Join edubkk_master.allschool_math_sd as t2 ON t1.id = t2.schoolid
inner join edubkk_checklist.tbl_checklist_kp7 as t3 ON t1.id=t3.schoolid
WHERE
t2.schid IS NULL  AND
t1.siteid LIKE  '100%' AND t3.profile_id='$profile_id'";	
$result = mysql_db_query($dbname_temp,$sql);
$rs = mysql_fetch_assoc($result);
	$sql_up2 = "UPDATE tbl_checklist_estimate SET num_cmss='".$rs[num1]."' WHERE siteid='1001' AND profile_id='$profile_id' ";
	mysql_db_query($dbname_temp,$sql_up2);
}


function CheckConFNum($profile_id){
	global $dbname_temp;
	$sql = "SELECT
tbl_checklist_estimate.siteid,
tbl_checklist_est_math.areaid
FROM
tbl_checklist_estimate
Inner Join tbl_checklist_est_math ON tbl_checklist_estimate.siteid = tbl_checklist_est_math.siteid_est
WHERE
tbl_checklist_estimate.status_high_school =  '1' AND tbl_checklist_estimate.siteid NOT IN('10001','10002')  and tbl_checklist_est_math.profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			if($rs[siteid] != $temp_id){
				$temp_id = $rs[siteid];
				$flag_id = 0;
		}
	
	
	$sql1 = "SELECT count(siteid) as num1 ,sum(if(num_cmss is null or num_cmss=0,1,0)) as num2 FROM `tbl_checklist_estimate` where siteid LIKE '$rs[areaid]%'  and profile_id='$profile_id' ";	
	$result1 = mysql_db_query($dbname_temp,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	if($rs1[num1] != $rs1[num2]){
		$flag_id = $flag_id+1;
	}else{
		$flag_id = $flag_id;
	}// end if($rs1[num1] != $rs1[num2]){
		
		if($flag_id > 0){
			$sql_update = "UPDATE tbl_checklist_estimate SET conf_num='0' WHERE siteid='$rs[siteid]' and profile_id='$profile_id'";	
		}else{
			$sql_update = "UPDATE tbl_checklist_estimate SET conf_num='1' WHERE siteid='$rs[siteid]'  and profile_id='$profile_id'";	
		}//end if($flag_id > 0){
	
			mysql_db_query($dbname_temp,$sql_update);
	
	}
}

function CountChecklist($profile_id){
		global $dbname_temp;
		$sql = "SELECT COUNT(idcard) as num1,siteid FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'  GROUP BY siteid";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[siteid]] = $rs[num1];
		}
		return $arr;
}

function CountCmss(){
		global $dbnamemaster;
		$sql = "SELECT COUNT(CZ_ID) as num_cmss,siteid FROM view_general GROUP BY siteid";
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[siteid]] = $rs[num_cmss];
		}
	return $arr;
}

function max_profile(){
	global $dbname_temp;
	$sql = "SELECT max(profile_id) as max_pro FROM tbl_checklist_kp7";	
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[max_pro];
}

################################################################
## function ในการตรวจสอบสถานะการยืนยันจำนวนข้อมูลที่ครบถ้วนภายในเขต
function GetStatusApprove(){
	global $dbname_temp;
	$sql = "SELECT tbl_checklist_estimate_new.siteid, tbl_checklist_estimate_new.approve_num FROM `tbl_checklist_estimate_new` ";	
	$result = mysql_db_query($dbname_temp,$sql);	
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[approve_num];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function GetStatusApprove(){
	
####  function นับจำนวนบุคลากรใน Pobec

function GetPobecTransfer($siteid){
		global $dbname_pobec_tran;
		$tbl_pobec = "pobec_".$siteid;
		$field_w = "Tables_in_".$dbname_pobec_tran; 
		$sql = "SHOW TABLES  WHERE $field_w='$tbl_pobec'";
		$result = mysql_db_query($dbname_pobec_tran,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs['$field_w'] != ""){
			$sql1 = "SELECT
COUNT(IDCODE) AS num1
FROM $tbl_pobec WHERE IDCODE <> '' AND IDCODE IS NOT NULL ";	
			$result1 = mysql_db_query($dbname_pobec_tran,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			$num_person = $rs1[num1];
		}else{
			$num_person = 0;	
		}
	return $num_person;
		
}//end function GetPobecTransfer($siteid){
	
#####  ตรวจสอบความสมบูรณ์ของเขตมัธยมที่ดึงข้อมูลมาครบหรือไม่ครบ
function CheckAreaTranfer(){
	global $dbnamemaster;
	$sql = "SELECT count(schoolid) as num1,siteid  FROM log_transfer_pobec GROUP BY  siteid";	
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}// end function CheckAreaTranfer(){
	
	
##### ตรวจสอบว่ามีการยืนยันจำนวนตัวเลขจากระบบ checklist หรือยัง
function CheckConFChecklist($profile_id){
	global $dbname_temp;
	$sql = "SELECT
count(siteid) as num1,siteid
FROM `tbl_status_lock_site`
where status_lock='1' and profile_id='$profile_id'
group by siteid";	
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}// end function CheckConFChecklist($profile_id){


######  function นับจำนวนเลขบัตรที่ไม่ถูกต้องตามกรมการปกครอง
function Countid_Fail($profile_id){
global $dbname_temp;

	$sql = "SELECT 
		SUM(if(status_IDCARD='IDCARD_FAIL' AND  status_chang_idcard='NO',1,0)) AS F,siteid 
		FROM  tbl_checklist_kp7_false WHERE   profile_id='$profile_id'  GROUP BY siteid
		";
			$result = mysql_db_query($dbname_temp,$sql);
			while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[siteid]] = $rs[F];
			}// end while($rs = mysql_fetch_assoc($result)){
				
		return $arr;
	
}// end function Countid_Fail($profile_id){



############################################################### 
#### เก็บ log นับจำนวนบุคลากรใน หน่วยงานสำนักงานปฐม
if($action == "process"){
	$profile_id =  max_profile();
	$profile_id1 = $profile_id-1;
	
	
	$arrapp = GetStatusApprove(); // ตรวจสอบเขตที่มีการยืนยันจำนวนข้อมูลเรียบร้อยแล้ว
	$arr_cmss = CountCmss();// จำนวนใน cmss
	$arrch = CountChecklist($profile_id);
	$arrch1 = CountChecklist($profile_id1);
	$arrconf_pobec = CheckAreaTranfer(); // สถานะการยืนยันจำนวนจาก pobec
	$confch =  CheckConFChecklist($profile_id);
	$confch1 =  CheckConFChecklist($profile_id1);
	$arr_idfial = Countid_Fail($profile_id);
	$arr_idfial1 = Countid_Fail($profile_id1);
	$sql = "SELECT secid FROM eduarea WHERE secid NOT LIKE '99%' ";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($arrapp[$rs[secid]] == "0"){ // ประมวลผลจัดเก็บข้อมูลของเขตที่ยังไม่มีการยืนยันจำนวนตัวเลขแล้วเท่านั้น
		$sub_siteid = substr($rs[secid],0,1); // ตรวจสอบว่าเป็นเขต มัธยมหรือไม่
		$site = $rs[secid];
		$temp_numidfial = $arr_idfial[$site];
		$temp_numidfial1 = $arr_idfial1[$site];
		
		
		if($sub_siteid == "0"){ // แสดงว่าเป็น สพม.
			$status_high_school = 1;
			#### หาใน cmss
			$temp_numcmss = $arr_cmss[$site];
			$temp_numchecklist = $arrch[$site];
			$temp_numchecklist1 = $arrch1[$site];

			if($temp_numchecklist > 0){
					$numchecklist = $temp_numchecklist+$temp_numidfial;
					$temp_con_approve = $confch[$site];
			}else{
					$numchecklist = $temp_numchecklist1+$temp_numidfial1;
					$temp_con_approve = $confch1[$site];
			}//end if($temp_numchecklist > 0){
			
			if($temp_numcmss > $numchecklist){
					$temp_num = $temp_numcmss;
			}else{
					$temp_num = $numchecklist;
			}
			
			$temp_numpobec = GetPobecTransfer($site);
			if($temp_numpobec > $temp_num){
					$numcmss = $temp_numpobec;
					
			}else{
					$numcmss = $temp_num;
					
					
			}//end $temp_numpobec = GetPobecTransfer($site);
			
					if($arrconf_pobec[$site] > 0){ // แสดงว่าการย้ายข้อมูลยังมาไม่ครบ
							$con_approve = 0;
					}else{
							$con_approve = 1;
					}//end if($arrconf_pobec[$site] > 0){
						
					if($temp_con_approve > 0){
							$con_approve = 1;
					}

			
			
		}else{
				

		if($arrch[$site] > 0){
			$numchecklist = 	$arrch[$site]+$temp_numidfial;
			$temp_con_approve = $confch[$site];
		}else{
			$numchecklist = 	$arrch1[$site]+$temp_numidfial1;
			$temp_con_approve = $confch1[$site];
		}
		
		
			if($arr_cmss[$site] > $numchecklist){
				$numcmss =$arr_cmss[$site]; 	
			}else{
				$numcmss = $numchecklist;
			}
			
			$con_approve = $temp_con_approve;
			
			if($numcmss > 0){
					$conf_num = 1;
			}else{
					$conf_num = 0;	
			}
			
			$status_high_school = 0;	
			
		}//end if($sub_siteid == "0"){
			
			$sql1 = "UPDATE tbl_checklist_estimate_new SET num_cmss='".$numcmss."',conf_num='$conf_num',status_high_school='$status_high_school',approve_num='$con_approve' WHERE siteid='$rs[secid]' ";
		//	echo $sql1."<br>";
			mysql_db_query($dbname_temp,$sql1);
			//echo $sql1."<br>";
			
		}//end if($arrapp[$rs[secid]] == "0"){ // ประมวลผลจัดเก็บข้อมูลของเขตที่ยังไม่มีการยืนยันจำนวนตัวเลขแล้วเท่านั้น
	}//end while($rs = mysql_fetch_assoc($result)){
	
	//CountSPMBangkok("10001",$profile_id);
	//CountSPMBangkok("10002",$profile_id);
	//SaveLogEstPri($profile_id);
	//SaveLogEstHigh($profile_id);
	//CountPriBangkok($profile_id);
	//CheckConFNum($profile_id); // mark สถานะของหน่วยงาน สพม.
	
	
	
	
	
echo "<script language=\"javascript\">
location='?action=';
</script>
";
}//end if($action == "process"){

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/jscriptfixcolumn/cssfixtable.css" rel="stylesheet">
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</SCRIPT>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>


</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td align="left" bgcolor="#CCCCCC"><a href="?action=process&profile_id=<?=$profile_id?>">คลิ๊กเพื่อประมวลผลข้อมูลใหม่ </a> || <a href="?type_num=all&profile_id=<?=$profile_id?>">แสดงทั้งหมด</a>  || <a href="?type_num=y&profile_id=<?=$profile_id?>">แสดงเฉพาะมีตัวเลข</a>|| <a href="?type_num=1&profile_id=<?=$profile_id?>">แสดงเฉพาะเขตที่มีการยืนยันจำนวนแล้วเท่านั้น</a></td>
          <td width="33%" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
      </table>
</td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>รายงานเปรียบเทียบจำนวนบุคลากรประมาณการกับข้อมูลในระบบcmss</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="21%" align="center" bgcolor="#CCCCCC"><strong>สพป/สพม</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>โรงเรียน<br>
          ที่ไม่มีบุคลากร</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>จำนวนประมาณการ</strong></td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>จำนวนจริงในระบบ cmss</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ผลต่าง<br>
          (จำนวนจริง cmss - จำนวนประมาณการ)</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>คิดเป็นเปอร์เซ็น</strong></td>
      </tr>
      <?
	   if($type_num == "y"){
		 	 	 $conw = " WHERE  num_cmss > 0 ";
		 }else if($type_num == "all"){
				$conw = " WHERE 1";	 
		}else if($type_num == "1"){
				$conw = " WHERE approve_num='1'";	
		}else{
				$conw = " WHERE 1";	
		}// end   if($type_num == "y"){
		
		$arrnum = CountSite();
	  $sql = "SELECT *,if(LENGTH(siteid)=5,0,1) as ord_id FROM `tbl_checklist_estimate_new` $conw  group by siteid ORDER BY ord_id,siteid ASC, areaname ASC ";
	 // echo $sql."<br>";
	  $result = mysql_db_query($dbname_temp,$sql);
	  $i=1;
	  while($rs= mysql_fetch_assoc($result)){
	    
		if($rs['site_status'] != "0"){
		  $bg = "#BBFFBB";
		}else{
		  $bg = "#FFFFFF";
		} 
		
		
		if($rs[siteid][0] == '0'){
          $tbl_name = "pobec_".$rs[siteid];
		  $sql_num = "SELECT COUNT(*) as num_person FROM $tbl_name ";
		  $query_num = mysql_db_query('temp_pobec_transfer',$sql_num)or die(mysql_error());	
		  $rows_num = mysql_fetch_array($query_num);
		  $numcm = $rows_num['num_person'];
		}else{
		  if($rs[num_cmss] < 1){
			 $numcm = 	$arrnum[$rs[siteid]];
		  }else{
			 $numcm = 	$rs[num_cmss];
		  }
	    }
		
		#################### แสดงสัญญาลักษณ์ของเขตที่ทำการยืนยันจำนวนตัวเลขเรียบร้อยแล้ว
		if($rs[approve_num] == "1"){
				$xmark  = "<font color='green'><b>*</b></font>";
		}else{
				$xmark = "";	
		}
		
	  ?>
      <tr bgcolor="<?=$bg?>" >
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[areaname]?><?=$xmark?></td>
        <td align="center">
		<?php
		$sql_sc = "SELECT * FROM log_transfer_pobec WHERE siteid = '$rs[siteid]' ";
		$query_sc = mysql_db_query('edubkk_master',$sql_sc)or die(mysql_error());
		$num_sc = mysql_num_rows($query_sc);
		if($num_sc > 0){
		?>
		<a href="view_school.php?siteid=<?=$rs['siteid']?>" target="_blank"><?=$num_sc?></a>
		<?php
		}
		?>
		</td>
        <td align="center"><?=number_format($rs[numall])?></td>
        <td align="center"><?=number_format($numcm);?>		</td>
        <td align="center"><?=number_format($numcm-$rs[numall])?></td>
        <td align="center"><? if($numcm > 0){ echo number_format(($numcm-$rs[numall])*100/$numcm,2);}else{ echo "0.00";}?></td>
      </tr>
      <?
	  	$sum1 += $rs[numall];
		$sum2 += $numcm;
		$i++;
		
	  }//end while($rs= mysql_fetch_assoc($result)){
	  ?>
       <tr bgcolor="#FFFFFF">
        <td colspan="2" align="center" bgcolor="#FFFFFF"><strong>รวม</strong></td>
        <td align="center" bgcolor="#FFFFFF"></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=number_format($sum1)?>
        </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=number_format($sum2)?>
        </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=number_format($sum2-$sum1)?>
        </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <? if($sum2 > 0){echo number_format(($sum2-$sum1)*100/$sum2,2); }?>
        </strong></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><strong>หมายเหตุ : เครื่องหมาย <font color="green">*</font> เป็นเขตที่ได้รับการยืนยันจำนวนตัวเลขเรียบร้อยแล้ว</strong></td>
  </tr>
</table>
</body>
</html>
