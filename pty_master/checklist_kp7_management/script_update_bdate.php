<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$time_start = getmicrotime();
if($_GET['profile_id'] == ""){
		$profile_id = "6";
}

if($action == "process"){
		$sql = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t2.birthday,
t2.begindate,
t2.prename_th,
t2.name_th,
t2.surname_th
FROM
edubkk_checklist.tbl_checklist_kp7 as t1
Inner Join edubkk_master.view_general as t2  ON t1.idcard = t2.CZ_ID
where (t1.birthday IS NULL or t1.birthday='0000-00-00' or t1.birthday='' 
	or t1.begindate IS NULL or t1.begindate='0000-00-00' or t1.begindate='') and t1.siteid='$xsiteid' AND t1.profile_id='$profile_id'";
//echo "$sql<br>";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[birthday] != "" and $rs[birthday] != "0000-00-00"){
			$conup1 = " ,birthday='$rs[birthday]'";	
		}
		if($rs[begindate] != "" and $rs[begindate] != "0000-00-00"){
				$conup2 = " ,begindate='$rs[begindate]'";
		}
			
			$sql_up = "UPDATE tbl_checklist_kp7 SET siteid='$rs[siteid]' $conup1 $conup2  WHERE idcard='$rs[idcard]' and profile_id='$rs[profile_id]'";
			//echo "$sql_up<br>";
			mysql_db_query($dbname_temp,$sql_up) or die(mysql_error()."$sql_up<br>LINE__".__LINE__);
	}
	echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');location.href='?action=&profile_id=$profile_id';</script>";
}//end if($action == "process"){
	
function CountBdNull($profile_id){
		global $dbname_temp;
		$sql = "SELECT siteid,sum(if(birthday='' or birthday='0000-00-00' or birthday IS NULL,1,0)) as numbirthday,sum(if(begindate='' or begindate='0000-00-00' or begindate IS NULL,1,0)) as numbegindate  FROM tbl_checklist_kp7 WHERE profile_id='$profile_id' GROUP BY siteid";
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[siteid]]['birthday']  =$rs[numbirthday];
				$arr[$rs[siteid]]['begindate']  =$rs[numbegindate];

		}
		return $arr;
}

#########################  function num birthday cmss
function GetNumCmss($profile_id){
	global $dbname_temp;
	$sql = "SELECT
	t1.siteid,
	count(distinct t1.idcard) as num1
	

FROM
edubkk_checklist.tbl_checklist_kp7 as t1
Inner Join edubkk_master.view_general as t2  ON t1.idcard = t2.CZ_ID
where (t1.birthday IS NULL or t1.birthday='0000-00-00' or t1.birthday='' 
	or t1.begindate IS NULL or t1.begindate='0000-00-00' or t1.begindate='') and ((t2.birthday <> '0000-00-00' and t2.birthday <> '') or (t2.begindate <> '0000-00-00' and t2.begindate <> ''))  AND t1.profile_id='$profile_id'";	
	$result  = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
	$arr[$rs[siteid]] = $rs[num1];		
	}
return $arr;
}
?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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

<script src="../../common/jquery.js"></script>
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
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
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
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#A5B2CE"><strong><?=ShowProfile_name($profile_id);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="30%" align="center" bgcolor="#A5B2CE"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>จำนวนที่สามารถ update ได้</strong></td>
        <td width="14%" align="center" bgcolor="#A5B2CE"><strong>จำนวนวันเกิดเป็นค่าว่าง</strong></td>
        <td width="17%" align="center" bgcolor="#A5B2CE"><strong>จำนวนวันเริ่มปฏิบัติราชการเป็นค่าว่าง</strong></td>
        <td width="15%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
      <?
	  
	 $arrp = CountBdNull($profile_id);
	 $arrcm = GetNumCmss($profile_id);
      	$sql = "SELECT
t1.siteid,
t2.secname
FROM
edubkk_checklist.tbl_checklist_kp7 as t1
Inner Join edubkk_master.eduarea as t2 ON t1.siteid = t2.secid
where profile_id='$profile_id'
group by t1.siteid
order by t2.secname ASC";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?></td>
        <td align="center"><?=number_format($arrcm[$rs[siteid]])?></td>
        <td align="center"><?=number_format($arrp[$rs[siteid]]['birthday'])?></td>
        <td align="center"><?=number_format($arrp[$rs[siteid]]['begindate'])?></td>
        <td align="center"><? if($arrcm[$rs[siteid]] > 0){?><a href="?action=process&xsiteid=<?=$rs[siteid]?>&profile_id=<?=$profile_id?>">update</a><? }else{ echo "ไม่สามารถ update ได้";}?></td>
      </tr>
     <?
	}//end while($rs = mysql_fetch_assoc($result)){
	 ?>
    </table></td>
  </tr>
</table>


</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
