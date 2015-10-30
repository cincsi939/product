<?
session_start();
$ApplicationName	= "search_documentkp7";
$module_code 		= "search_documentkp7"; 
$process_id			= "checklistkp7_search";
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
include("function_search.php");
$kp7path = "../../../".PATH_KP7_FILE."/";
$kp7path_org = "../../../".PATH_KP7_REFDOC_FILE."/";
if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
	$profile_id = LastProfile();
}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบสืบค้นเอกสาร ก.พ. 7</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
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
</head>
<body>

<?
	$get_id = trim($_GET['get_idcard']);
	if($_POST['key_idcard'] != "" || $get_id !=""){
		$txt_dis = "style=\"display:none\"";
	}else{
		$txt_dis = "";
	}
?>

<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" <?=$txt_dis?>>
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="4" align="center" valign="middle" bgcolor="#ABC8E2">      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="9%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="58%">
          <select name="profile_id" id="profile_id">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<!--<option value="?profile_id=<?//=$rsp[profile_id]?>&search=<?//=$search?>&key_surname=<?//=$key_surname?>&key_idcard=<?//=$key_idcard?>&key_name=<?//=$key_name?>&page=<?//=$page?>" <?//=$sel?>><?//=$rsp[profilename]?></option>-->
        <option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table></td>
          </tr>
        <tr>
          <td align="center" valign="middle" bgcolor="#ABC8E2"><strong><img src="../../images_sys/icon_search.png" border="0"></strong></td>
          <td colspan="3" align="left" valign="middle" bgcolor="#ABC8E2"><strong>เงื่อนไขการสืบค้นข้อมูล  <?=ShowProfile_name($profile_id);?></strong></td>
          </tr>
        <tr>
          <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="12%" bgcolor="#FFFFFF">ชื่อ</td>
          <td width="19%" bgcolor="#FFFFFF">
            <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>"></td>
          <td width="66%" bgcolor="#FFFFFF"><input type="submit" name="save" id="save" value="ตกลง">
            <input type="reset" name="btncancel" id="btncancel" value="ยกเลิก">
            <!--<input type="hidden" name="profile_id" value="<?//=$profile_id?>">-->
              <input type="hidden" name="search" value="search">
              <input type="hidden" name="page" value="">
            </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">นามสกุล</td>
          <td bgcolor="#FFFFFF">
            <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">หมายเลขบัตรประชาชน</td>
          <td bgcolor="#FFFFFF">
            <input name="key_idcard" type="text" id="key_idcard" size="25" maxlength="13" value="<?=$key_idcard?>"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<? if($search == "search" or $displaytype=="people" || $get_id !=""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>&nbsp;</td></tr>
<?
if($key_name != ""){
		$conwhere  .= " AND name_th LIKE '%$key_name%'";
}
if($key_surname != ""){
		$conwhere .= " AND surname_th LIKE '%$key_surname%' ";
}

if($key_idcard != ""){
		$conwhere .= " AND idcard LIKE '%$key_idcard%'";
}
if($get_id !=""){
		$conwhere .= " AND idcard LIKE '%$get_id%'";
}

	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 10 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 


	$sql = "SELECT COUNT(idcard) as numall FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	
	$sql_main = "SELECT * FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'  $conwhere ";
	
		$xresult = mysql_db_query($dbname_temp,$sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}
	//echo $sql_main;

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 
		
	if($num_row < 1){
	
?>
  <tr>
    <td><table width="99%" border="0" cellpadding="0" cellspacing="2" align="center" style="border:1px solid #5595CC;">
<tr>
	<td height="20"><img src="../../images_sys/alert.gif" width="16" height="16" align="absmiddle" />&nbsp;ผลการค้นหา:  <? if($key_name != ""){ echo "<br> - ชื่อ : $key_name  ";} if($key_surname != ""){ echo "<br> - นามสกุล : $key_surname  ";} if($key_idcard != ""){ echo " <br> - หมายเลขบัตรประชาชน : $key_idcard  ";} ?>&nbsp;ไม่ตรงกับบุคลากรใด ๆ<br /><br />
	ข้อแนะนำ :<br />
	- ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br />
	- ลดเงื่อนไขการค้นหาลง<br /><br />
	</td>
</tr>
</table></td>
  </tr>
  <?
	}//end 	if($num_row < 1){
   if($num_row > 0){?>
  <tr>
    <td <?=$txt_dis?>><strong>ผลการสืบค้น พบจำนวน <?=number_format($all)?> คน จากจำนวนข้อมูลทั้งหมด <?=number_format($rs[numall])?> คน (<? $time_e 	= getmicrotime();
	echo  number_format($time_e - $time_start,2);?> วินาที)</strong></td>
  </tr>
  <?
  while($rsm = mysql_fetch_assoc($result_main)){
	  $i++;
	  $arrkey1 = DateAssign($rsm[idcard],$rsm[profile_id]);
	  $arrqc = SearchGetQcKp7($rsm[idcard],$rsm[profile_id]);
	  $arrupfile = DateUploadFile($rsm[idcard],$rsm[profile_id]);
	  

				$orgname = show_school($rsm[schoolid])."/".ShowAreaSort($rsm[siteid]); 	 		
		$tab_txt_head =  "style=\"margin-left:50px\"";
	  
  ?>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="2%" align="center">&nbsp;</td>
        <td width="90%" align="left"><table width="99%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="2" align="left"><font color="#1375C6">&nbsp;<? echo "<b>".$i.".</b> ";?> <? echo " <b> $rsm[idcard]  $rsm[prename_th]$rsm[name_th]  $rsm[surname_th] </u> <b>$orgname</b></b> ";?> 
			<? 
			
				$filekp7 = $kp7path.$rsm[siteid]."/".$rsm[idcard].".pdf";
				$filekp7_org = $kp7path_org.$rsm['siteid']."/".$rsm[idcard]."R.pdf";
			
			
					$kp7_sys = "<a href=\"../hr3/hr_report/kp7_search.php?id=".$rsm[idcard]."&sentsecid=".$rsm[siteid]."\" target=\"_blank\"><img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" alt='ทะเบียนประวัติอิเล็กทรอนิกส์' ></a>";
					
			
					if(is_file($filekp7_org)){
					$kp7_ref = "<a href=\"$filekp7_org\" target=\"_blank\"><img src='../../images_sys/pdf_ref.png' width=\"16\" height=\"16\" border=\"0\"  title='สำเนาเอกสารหลักฐาน' ></a>";
					}else{
						$kp7_ref = "";	
					}
					
			 if(is_file($filekp7)){
					$kp7img="<a href='$filekp7' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' title='สำเนาเอกสารทะเบียนประวัติต้นฉบับ' width='16' height='16' border='0'></a>";
					$file_upload = 1;
			}else{
					
					$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
					$kp7img = $arrkp7['linkfile'];	
					$file_upload = 0;
			}
					echo "&nbsp; $kp7_ref &nbsp; $kp7img &nbsp;  $kp7_sys";
				?></font></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong style="margin-left:50px">สถานะการจัดทำข้อมูลปฐมภูมิ</strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">วันที่ได้รับเอกสาร&nbsp;<? $arrd1 = DateReciveDoc($rsm[idcard],$rsm[profile_id],""); echo $arrd1['time']?> <? $arrd1 = DateMoreFile($rsm[idcard],$rsm[profile_id]); 
			if(count($arrd1) > 0){
				$xk=1;
				foreach($arrd1 as $key => $val){
					$xk++;
						echo " <strong>ครั้งที่ $xk</strong> $val  &nbsp;&nbsp;";
				}	
			}
			?></font></td>
          </tr>
          		<tr>
            		<td align="left" colspan="2"></td>
          		</tr>
          			<tr>
                    		<td width="35%"><font color="#666666" style="margin-left:60px">วันที่ตรวจสอบเอกสาร&nbsp;<? $arrd2 = DateReciveDoc($rsm[idcard],$rsm[profile_id],"max"); echo $arrd2['time']?></font></td>
                    		<td width="64%"><font color="#666666">ผู้ตรวจสอบเอกสาร&nbsp;<?=$arrd2['user']?></font></td>
                    </tr>
          <tr>
          	<td colspan="2"><hr width="50%" style="margin-left:30px"></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong style="margin-left:50px">ความถูกต้องครบถ้วนของเอกสารสำเนา กพ.7 ต้นฉบับ </strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">วันที่จ่ายงานเพื่อบันทึกข้อมูล&nbsp;<?=$arrkey1['dateassign']?>&nbsp;</font><td width="1%">
            </tr>
            <tr>
            <td><font color="#666666" style="margin-left:60px">บันทึกข้อมูลโดย&nbsp;<?=$arrkey1['staff_key']?>&nbsp;</font></td>		<td><font color="#666666">วันที่บันทึกข้อมูลแล้วเสร็จ&nbsp;<?=$arrkey1['datecomp']?></font></td>
          </tr>
          <tr>
          	<td colspan="2"><hr width="50%" style="margin-left:30px"></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong style="margin-left:50px">วันที่ตรวจสอบคุณภาพการบันทึกข้อมูล</strong>&nbsp;<?=$arrqc['dateqc']?>&nbsp;<strong>ตรวจสอบโดย</strong>&nbsp;<?=$arrqc['fullname']?></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">สถานะรับรองข้อมูล: <font color="#006600"><?=$arrkey1['comment_approve']?></font></font></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">วันที่สแกนเอกสารและ upload ข้อมูลเข้าสู่ระบบ&nbsp;<? if($file_upload == "1"){ echo $arrupfile['date_upload'];}else{ echo " -  ";}?>&nbsp;โดย&nbsp;<? if($file_upload == "1"){ echo $arrupfile['staff_upload'];}else{ echo " - ";}?></font></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  
  <?
  }//end   while($rsm = mysql_fetch_assoc($result_main)){
	  if($all > 0){
  ?>
  <tr <?=$txt_dis?>>
    <td><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
  </tr>
  <?
	  }//END if($all > 0){
  }//end if($num_row > 0){
  ?>
</table>
<? }//end if($search == "search" or $displaytype=="people"){?>
</body>
</html>