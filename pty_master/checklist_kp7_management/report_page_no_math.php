<?
session_start();
include("checklist2.inc.php");

function GetSql($xsiteid,$profile_id){
	$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.idcard,
edubkk_checklist.tbl_checklist_kp7.siteid,
edubkk_checklist.tbl_checklist_kp7.schoolid,
edubkk_checklist.tbl_checklist_kp7.name_th,
edubkk_checklist.tbl_checklist_kp7.surname_th,
edubkk_checklist.tbl_checklist_kp7.position_now,
temp_pobec_import_checklist.school_$xsiteid.S_NAME,
temp_pobec_import_checklist.school_$xsiteid.T_NAME,
temp_pobec_import_checklist.school_$xsiteid.H_NAME
FROM
edubkk_checklist.tbl_checklist_kp7
LEFT Join temp_pobec_import_checklist.pobec_$xsiteid ON edubkk_checklist.tbl_checklist_kp7.idcard = temp_pobec_import_checklist.pobec_$xsiteid.IDCODE
LEFT Join temp_pobec_import_checklist.school_$xsiteid ON temp_pobec_import_checklist.pobec_$xsiteid.I_CODE = temp_pobec_import_checklist.school_$xsiteid.I_CODE
LEFT Join edubkk_master.hr_addposition_now ON edubkk_checklist.tbl_checklist_kp7.position_now = edubkk_master.hr_addposition_now.`position`
WHERE
(edubkk_checklist.tbl_checklist_kp7.siteid =  '$xsiteid') AND
(edubkk_checklist.tbl_checklist_kp7.schoolid =  '0' OR
edubkk_checklist.tbl_checklist_kp7.schoolid IS NULL  OR
edubkk_checklist.tbl_checklist_kp7.schoolid =  '') AND
edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id'

GROUP BY edubkk_checklist.tbl_checklist_kp7.idcard

ORDER BY
temp_pobec_import_checklist.school_$xsiteid.I_CODE,
temp_pobec_import_checklist.school_$xsiteid.S_NAME,
edubkk_master.hr_addposition_now.orderby,
edubkk_checklist.tbl_checklist_kp7.name_th ,
edubkk_checklist.tbl_checklist_kp7.surname_th ASC";
return $sql;	
}//end function GetSql(){
	
######################  ประมวลผลจำนวนแผ่นเอกสาร ก.พ.7 #########################
if($_SERVER['REQUEST_METHOD'] == "GET"){
		if($action == "process_page"){
			$sql_update = "UPDATE tbl_checklist_kp7  SET page_num=page_upload WHERE page_num <> page_upload AND siteid='$sentsecid' AND page_upload > 0  AND profile_id='$profile_id' ";
			mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
			echo "<script>alert('ประมวลผลจำนวนแผ่นเอกสารเรียบร้อยแล้ว');location.href='?action=&sentsecid=$sentsecid&profile_id=$profile_id';</script>";
		}//end if($action == "process_page"){
}//end if($_SERVER['REQUEST_METHOD'] == "GET"){


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="10" align="left" bgcolor="#A8B9FF"><strong><?=show_area($sentsecid);?> || <a href="?action=process_page&sentsecid=<?=$sentsecid?>&profile_id=<?=$profile_id?>">ประมวลผลแก้ไขจำนวนแผ่นเอกสารคนนับให้ตรงกับที่ระบบนับทั้งหมด</a></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
        <td width="12%" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="18%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="17%" align="center" bgcolor="#A8B9FF"><strong>สังกัด</strong></td>
        <td width="7%" align="center" bgcolor="#A8B9FF"><strong>คนนับ</strong></td>
        <td width="7%" align="center" bgcolor="#A8B9FF"><strong>ระบบนับ</strong></td>
        <td width="4%" align="center" bgcolor="#A8B9FF">&nbsp;</td>
      </tr>
      <?
      	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE page_num <> page_upload AND siteid='$sentsecid' AND page_upload > 0  AND profile_id='$profile_id'";
		$result = mysql_db_query($dbtemp_check,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  $file_pdf = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
				}else{
					$img_pdf = "";
				}//end if(is_file($file_pdf)){
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><a href="check_kp7_area.php?action=execute&sentsecid=<?=$rs[siteid]?>&idcard=<?=$rs[idcard]?>&fullname=<? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?>&
search=&key_name=&key_surname=&key_idcard=&schoolid=<?=$rs[schoolid]?>&xsiteid=<?=$rs[siteid]?>&extra=1&profile_id=<?=$profile_id?>" target="_blank"><?=$rs[idcard]?></a></td>
        <td align="left"><?=$rs[prename_th]?></td>
        <td align="left"><?=$rs[name_th]?></td>
        <td align="left"><?=$rs[surname_th]?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="center"><?=show_school($rs[schoolid]);?></td>
        <td align="center"><?=$rs[page_num]?></td>
        <td align="center"><?=$rs[page_upload]?></td>
        <td align="center"><?=$img_pdf?></td>
      </tr>
      <?
		}//end while(){
	  ?>
    </table></td>
  </tr>
</table>
<?
		}//end if($action == ""){
		if($action == "NOSCHOOL"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#A8B9FF"><strong>รายชื่อคนที่ไม่สามารถระบุหน่วยงานสังกัดได้ <?=show_area($sentsecid);?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="13%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="16%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="17%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="25%" align="center" bgcolor="#A8B9FF"><strong>หน่วยงานใน pobec</strong></td>
        <td width="4%" align="center" bgcolor="#A8B9FF">&nbsp;</td>
      </tr>
      <?
	  
	  
	  
      	//$sql = "SELECT * FROM tbl_checklist_kp7 WHERE  (siteid = '$xsiteid') and (schoolid='0' or schoolid IS NULL or schoolid ='') AND profile_id='$profile_id' ORDER BY name_th,surname_th ASC  ";
		#$sql = GetSql($xsiteid,$profile_id);
		$sql = "SELECT
t1.idcard,
t1.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid
FROM
edubkk_checklist.tbl_checklist_kp7 AS t1
Left Join edubkk_master.allschool AS t2 ON t1.schoolid = t2.id AND t1.siteid = t2.siteid
LEFT Join temp_pobec_import_checklist.pobec_$xsiteid as t3 ON t1.idcard = t3.IDCODE
LEFT Join temp_pobec_import_checklist.school_$xsiteid as t4 ON t4.I_CODE = t3.I_CODE
LEFT Join edubkk_master.hr_addposition_now as t5 ON t1.position_now = t5.`position`

WHERE t1.siteid =  '$xsiteid' AND t1.profile_id =  '$profile_id' and t2.id is null
ORDER BY 
t4.I_CODE,
t4.S_NAME,
t5.orderby,
t1.name_th ,
t1.surname_th ASC";

		$result = mysql_db_query($dbtemp_check,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  $file_pdf = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
				}else{
					$img_pdf = "";
				}//end if(is_file($file_pdf)){   
				
				if($rs[T_NAME] != ""){
						$tambon = "( ตำบล :  $rs[T_NAME] )";
				}else{ 
					$tambon = "";
				}
				
				if($rs[H_NAME] != ""){
						$hname = " (ผู้บริหาร :  $rs[H_NAME])";
				}else{
						$hname = "";	
				}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><a href="form_manage_checklist.php?action=EDIT&sentsecid=<?=$rs[siteid]?>&idcard=<?=$rs[idcard]?>&fullname=<? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?>&search=<?=$search?>&key_name=<?=$key_name?>&key_surname=<?=$key_surname?>&key_idcard=<?=$key_idcard?>&schoolid=<?=$schoolid?>&xsiteid=<?=$xsiteid?>&extra=1&profile_id=<?=$profile_id?>" target="_blank"><?=$rs[idcard]?></a></td>
        <td align="left"><?=$rs[prename_th]?></td>
        <td align="left"><?=$rs[name_th]?></td>
        <td align="left"><?=$rs[surname_th]?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="left"><?  echo "$rs[S_NAME] ".$tambon." ".$hname;//echo ShowOrgInPobec($xsiteid,$rs[idcard]);?></td>
        <td align="center"><?=$img_pdf?></td>
      </tr>
      <?
		}//end while(){
	  ?>
    </table></td>
  </tr>
</table>


<?
		}//end 	if($action == "NOSCHOOL"){
?>
</body>
</html>
