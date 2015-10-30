<?
session_start();
set_time_limit(0);
include("../../config/conndb_nonsession.inc.php");
include("checklist2.inc.php");
	if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
		$profile_id = LastProfile();
	}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์


//echo "ประเภทเอกสาร ::".$type_doc;
function NumKeyDocType($profile_id){
	global $dbname_temp;
			$sql = "SELECT
		edubkk_checklist.tbl_checklist_kp7.siteid,
		sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0)) as numup1,
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' and page_upload>0,1,0)) as numupload,
		count(edubkk_checklist.tbl_checklist_kp7.idcard) as numkey
		FROM
		edubkk_checklist.tbl_checklist_kp7
		Inner Join callcenter_entry.tbl_assign_key ON edubkk_checklist.tbl_checklist_kp7.idcard = callcenter_entry.tbl_assign_key.idcard
		AND edubkk_checklist.tbl_checklist_kp7.siteid = callcenter_entry.tbl_assign_key.siteid
		WHERE
		edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' AND
		callcenter_entry.tbl_assign_key.nonactive =  '0' AND
		callcenter_entry.tbl_assign_key.approve =  '2'
		GROUP BY
		edubkk_checklist.tbl_checklist_kp7.siteid
		ORDER BY edubkk_checklist.tbl_checklist_kp7.siteid ASC";
		 $result = mysql_db_query($dbname_temp,$sql);
		 while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[siteid]]['org'] =  ShowAreaSort($rs[siteid]);
				$arr[$rs[siteid]]['numkey'] = $rs[numkey];
				$arr[$rs[siteid]]['numup1'] = $rs[numup1];
				$arr[$rs[siteid]]['numupload'] = $rs[numupload];
		}//end  while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function NumKeyDocType(){
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/tooltip_checklist/css/style.css" rel="stylesheet" type="text/css" />
<script src="../../common/tooltip_checklist/jquery_1_3_2.js"></script>
<script src="../../common/tooltip_checklist/script.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

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


</head>
<body>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#D2D2D2"><strong>เลือกกลุ่มรายการข้อมูล</strong></td>
          </tr>
        <tr>
          <td width="12%" align="right" bgcolor="#FFFFFF"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td bgcolor="#FFFFFF">
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
          </tr>
      </table>
   </td>
  </tr>
</table>
</form>
 <? if($type == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td height="22" colspan="5" bgcolor="#CCCCCC"><strong>รายงานการคีย์เอกสาร ก.พ. 7 ที่ขาดเอกสารประกอบ แยกรายเขตพื้นที่การศึกษา</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="32%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>จำนวนที่บันทึกข้อมูลทั้งหมด</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>จำนวนบันทึกที่เอกสารขาดปก</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>จำนวนบันทึกที่เอกสารสมบูรณ์</strong></td>
      </tr>
      <?	  
	  $arrcount = NumKeyDocType($profile_id);
      	if(count($arrcount) > 0){
			$i=0;
			foreach($arrcount as $key => $val){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$numall = $val['numkey'];
			$numF = $val['numup1'];
			$numT = $val['numupload'];
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$val['org']?></td>
        <td align="center"><? if($numall > 0){ echo "<a href='?xsiteid=$key&type=all&profile_id=$profile_id' target='_blank'>".number_format($numall)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numF > 0){ echo "<a href='?xsiteid=$key&type=F&profile_id=$profile_id' target='_blank'>".number_format($numF)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numT > 0){ echo "<a href='?xsiteid=$key&type=T&profile_id=$profile_id' target='_blank'>".number_format($numT)."</a>";}else{ echo "0";}?></td>
      </tr>
      <?
			}//end //end foreach($arrcount as $key => $val){
		}//end  	if(count($arrcount) > 0){
	  ?>
    </table></td>
  </tr>
</table>
<?
		}else{//end 
		if($type == "all"){
			$conkey = " WHERE t1.profile_id =  '$profile_id' AND
		t2.nonactive =  '0' AND
		t2.approve =  '2' AND t1.siteid='$xsiteid'";
		 $xtitle = " จำนวนที่บันทึกข้อมูลทั้งหมด";
				
		}else if($type == "F"){
				$conkey = " WHERE t1.profile_id =  '$profile_id' AND
		t2.nonactive =  '0' AND
		t2.approve =  '2'  and status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' AND t1.siteid='$xsiteid'";
		 $xtitle = " จำนวนบันทึกที่เอกสารขาดปก";
		}else if($type == "T"){
				$conkey = " WHERE t1.profile_id =  '$profile_id' AND t1.siteid='$xsiteid' AND 
		t2.nonactive =  '0' AND
		t2.approve =  '2' AND status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' and page_upload > 0";
		 $xtitle = " จำนวนบันทึกที่เอกสารสมบูรณ์";
		}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#000000">
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#CCCCCC"><strong>รายงานการคีย์ข้อมูล ก.พ. 7 <?=$xtitle?>&nbsp;<?=ShowAreaSort($xsiteid)?></strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
        <td width="27%" align="center" bgcolor="#CCCCCC"><strong>ชื่อนามสกุล</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="29%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงาน</strong></td>
      </tr>
      <?
      		$sql = "SELECT t1.idcard,t1.siteid,t1.prename_th,t1.name_th,t1.surname_th,t1.position_now,t1.schoolid FROM edubkk_checklist.tbl_checklist_kp7 as t1 INNER JOIN callcenter_entry.tbl_assign_key as t2 ON t1.idcard=t2.idcard  AND  t1.siteid = t2.siteid $conkey ORDER BY t1.schoolid ASC";
			$result = mysql_db_query($dbname_temp,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

				$org = $pre."".show_school($rs[schoolid]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo $org;?></td>
      </tr>
      <?
			}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
<?
		}//end 
?>
</body>
</html>
