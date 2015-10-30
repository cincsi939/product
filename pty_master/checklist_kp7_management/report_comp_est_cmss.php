<?


session_start();

header("Location: report_comp_est_cmss_new.php");die;
include("checklist2.inc.php");
if($profile_id == ""){
		$profile_id = LastProfile();
}

if($type_num == ""){
		$type_num = "y";
}

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


#### เก็บ log นับจำนวนบุคลากรใน หน่วยงานสำนักงานปฐม
if($action == "process"){
	CountSPMBangkok("10001",$profile_id);
	CountSPMBangkok("10002",$profile_id);
	SaveLogEstPri($profile_id);
	SaveLogEstHigh($profile_id);
	CountPriBangkok($profile_id);
	CheckConFNum($profile_id); // mark สถานะของหน่วยงาน สพม.
	
	
	
	
	
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
.style1 {color: #006600}
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
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right" bgcolor="#CCCCCC"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%" align="left" bgcolor="#CCCCCC">
          <select name="profile_id" id="profile_id" onChange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select>
          &nbsp;&nbsp;|| <a href="?action=process&profile_id=<?=$profile_id?>">คลิ๊กเพื่อประมวลผลข้อมูลใหม่ </a> || <a href="?type_num=all&profile_id=<?=$profile_id?>">แสดงทั้งหมด</a>  || <a href="?type_num=y&profile_id=<?=$profile_id?>">แสดงเฉพาะมีตัวเลข</a></td>
          <td width="33%" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>รายงานเปรียบเทียบจำนวนบุคลากรประมาณการกับข้อมูลในระบบcmss</strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="26%" align="center" bgcolor="#CCCCCC"><strong>สพป/สพม</strong></td>
        <td width="21%" align="center" bgcolor="#CCCCCC"><strong>จำนวนประมาณการ</strong></td>
        <td width="21%" align="center" bgcolor="#CCCCCC"><strong>จำนวนจริงในระบบ cmss</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>ผลต่าง<br>
(จำนวนจริง cmss - จำนวนประมาณการ)</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>คิดเป็นเปอร์เซ็น</strong></td>
      </tr>
      <?
	   if($type_num == "y"){
		 	 	 $conw = " WHERE (tbl_checklist_estimate.status_high_school =  '1'  and conf_num > 0 and num_cmss > 0) or (tbl_checklist_estimate.status_high_school='0' and num_cmss > 0) ";
		 }else{
				$conw = "";	 
		}
		
		$arrnum = CountSite();
	  $sql = "SELECT *,if(LENGTH(siteid)=5,0,1) as ord_id FROM `tbl_checklist_estimate` group by siteid ORDER BY ord_id,siteid ASC, areaname ASC ";
	  $result = mysql_db_query($dbname_temp,$sql);
	  $i=0;
	  while($rs= mysql_fetch_assoc($result)){
      	if ($i++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
		if($rs[num_cmss] < 1){
			$numcm = 	$arrnum[$rs[siteid]];
		}else{
			$numcm = 	$rs[num_cmss];
		}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[areaname]?></td>
        <td align="center"><?=number_format($rs[numall])?></td>
        <td align="center"><?=number_format($numcm);?></td>
        <td align="center"><?=number_format($numcm-$rs[numall])?></td>
        <td align="center"><? if($numcm > 0){ echo number_format(($numcm-$rs[numall])*100/$numcm,2);}else{ echo "0.00";}?></td>
      </tr>
      <?
	  	$sum1 += $rs[numall];
		$sum2 += $numcm;
		
	  }//end while($rs= mysql_fetch_assoc($result)){
	  ?>
       <tr bgcolor="#FFFFFF">
        <td colspan="2" align="center" bgcolor="#FFFFFF"><strong>รวม</strong></td>
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
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
