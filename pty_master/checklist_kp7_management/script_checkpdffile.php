<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_import_pdf"; 
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



include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php")  ;
//include("checklist.inc.php");
###  กรณี profile_id เป็นค่าว่าง

	function XShowAreaSortName($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname_short FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return $rs_area[secname_short];
	}//end function ShowAreaSortName($get_secid){


	function xshow_school($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office FROM allschool WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_school = mysql_fetch_assoc($result_school);
		return $rs_school[office];
	}//end function show_school($get_schoolid){
if($profile_id == ""){
		$profile_id = "1";
}//end if($profile_id == ""){

$path_pdf = "../../../".PATH_KP7_FILE."/";
$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='16' height='16' border='0'>";
$dbname_temp = DB_CHECKLIST;

### ทำการประมวลผลการตรวจสอบข้อมูลเพื่อเก็บไว้ใน log
if($action == "process"){
	$sql = "SELECT idcard,siteid,prename_th,name_th,surname_th,schoolid,page_num,page_upload,position_now,profile_id FROM `tbl_checklist_kp7` WHERE profile_id='$profile_id' and page_upload > 0";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			 $xkp7file = $path_pdf."$rs[siteid]/$rs[idcard]".".pdf";
			 	if(is_file($xkp7file)){
						$statusfile = "1";
						$sitefile = "";
				}else{
					$arrpdf = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,$rs[schoolid],"pdf");
					
					if($arrpdf['numfile']> 0){
						$statusfile = "2";
						$sitefile = $arrpdf['sitefile'];
					}else{
						$statusfile = "0";	
						$sitefile = "";
					}//end f(GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,$rs[schoolid],"") > 0){
				}//end  	if(is_file($xkp7file)){
					
			### เก็บ log การนำเข้าข้อมูล
			$sql_update = "REPLACE INTO tbl_log_checkpdf_file SET idcard='$rs[idcard]',siteid='$rs[siteid]',prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',schoolid='$rs[schoolid]',page_num='$rs[page_num]',page_upload='$rs[page_upload]',sitefile='$sitefile',statusfile='$statusfile',profile_id='$rs[profile_id]' ";
			mysql_db_query($dbname_temp,$sql_update);
			$sitefile = "";
			
	}//end while($rs = mysql_fetch_assoc($result)){
		echo "<script>location.href='?action=&profile_id=$profile_id';</script>";
}//end if($action == "process"){
###  end ทำการประมวลผลเก็บไว้ใน log

function NumPersonUpload($profile_id){
	global $dbname_temp;
	$sql = "SELECT count(idcard) as num1,siteid  FROM `tbl_checklist_kp7` WHERE profile_id='$profile_id' group by siteid";
	$result  = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = $rs[num1];
			
	}//end while($rs = mysql_fetch_assoc($result)){		
	return $arr;
}//end function NumPersonUpload(){

	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<link href="../../common/jscriptfixcolumn/cssfixtable.css" type="text/css" rel="stylesheet" />
<title>เครื่องมือในการจัดการไฟล์ pdf</title>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 3 });
        });
</SCRIPT>

</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select>  
          
          || <a href="?action=process&profile_id=<?=$profile_id?>">ประมวลผลตรวจสอบข้อมูลไฟล์ pdf ต้นฉบับ</a></td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<? if($action == ""){
	
	?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>รายงานการผลการตรวจสอบไฟล์ pdf ในระบบ</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="27%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>จำนวนบุคลากรทั้งหมด</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>จำนวนไฟล์ pdf ที่นำเข้าไปในระบบ</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>จำนวนไฟล์ที่อยู่ในเขตเดิม</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>จำนวนไฟล์ที่ย้ายไปเขตใหม่</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>จำนวนที่หาไฟล์ไม่เจอ</strong></td>
      </tr>
      <?
      $arrnum = NumPersonUpload($profile_id);
	  
	  $sql = "SELECT 
count(idcard) as num1,
sum(if(statusfile=0,1,0)) as numloss,
sum(if(statusfile=1,1,0)) as numfile1,
sum(if(statusfile=2,1,0)) as numfile2,
siteid
 FROM `tbl_log_checkpdf_file`
where profile_id='$profile_id'
group by siteid";
	$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
	while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		$org = str_replace("สพท.","",XShowAreaSortName($rs[siteid]));
		$numall = $arrnum[$rs[siteid]];
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$org?></td>
        <td align="center"><? if($numall > 0){ echo "<a href='?action=view1&xsiteid=$rs[siteid]&xtype=numall&profile_id=$profile_id'>".number_format($numall)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($rs[num1] > 0){ echo "<a href='?action=view1&xsiteid=$rs[siteid]&xtype=numpdf&profile_id=$profile_id'>".number_format($rs[num1])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($rs[numfile1] > 0){ echo "<a href='?action=view1&xsiteid=$rs[siteid]&xtype=numpdfsite_odd&profile_id=$profile_id'>".number_format($rs[numfile1])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($rs[numfile2] > 0){ echo "<a href='?action=view1&xsiteid=$rs[siteid]&xtype=numpdfsite_new&profile_id=$profile_id'>".number_format($rs[numfile2])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($rs[numloss] > 0){ echo "<a href='?action=view1&xsiteid=$rs[siteid]&xtype=numpdfsite_false&profile_id=$profile_id'>".number_format($rs[numloss])."</a>";}else{ echo "0";}?></td>
      </tr>
      <?
	  $sumall1 += $numall;
	  $sumall2 += $rs[num1];
	  $sumall3 += $rs[numfile1];
	  $sumall4 += $rs[numfile2];
	  $sumall5 += $rs[numloss];
	}//end while($rs = mysql_fetch_assoc($result)){
	  ?>

      <tr bgcolor="<?=$bg?>">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sumall1);?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sumall2);?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sumall3);?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sumall4);?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($sumall5);?></td>
      </tr>
    </table></td>
  </tr>
  <?
}//end if($action == ""){
	if($action == "view1"){
		
		if($xtype == "numall"){
			$xtitle = "จำนวนข้าราชการครูและบุคลากรทางการศึกษาทั้งหมด";
				
		}else if($xtype == "numpdf"){
				$xtitle = "จำนวนไฟล์ pdf ที่นำเข้าไปในระบบทั้งหมด";
				$sql = "SELECT *  FROM `tbl_checklist_kp7` WHERE profile_id='$profile_id' AND siteid='$xsiteid'";
		}else if($xtype == "numpdfsite_odd"){
				$xtitle = "จำนวนไฟล์ที่อยู่ในเขตเดิม";
				$sql = "SELECT  * FROM `tbl_log_checkpdf_file`
where profile_id='$profile_id' and siteid='$xsiteid'  and  statusfile='1'";
		}else if($xtype == "numpdfsite_new"){
				$xtitle = "จำนวนไฟล์ที่ย้ายไปเขตใหม่";
				
					$sql = "SELECT  *  FROM `tbl_log_checkpdf_file`
where profile_id='$profile_id' and siteid='$xsiteid'  and  statusfile='2'";
		}else if($xtype == "numpdfsite_false"){
				$xtitle = "จำนวนที่หาไฟล์ไม่เจอ";
					$sql = "SELECT  *  FROM `tbl_log_checkpdf_file`
where profile_id='$profile_id' and siteid='$xsiteid'  and  statusfile='0'";
		}
  ?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#CCCCCC"><strong><a href="?action=&profile_id=<?=$profile_id?>">ย้อนกลับ</a> || <?=$xtitle?>
          <?=XShowAreaSortName($xsiteid);?>
        </strong></td>
      </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงาน</strong></td>
        <td width="22%" align="center" bgcolor="#CCCCCC"><strong>ไฟล์ย้ายไปสังกัดใหม่</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>จำนวนแผ่นคนนับ</strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>จำนวนแผ่นระบบนับ</strong></td>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ไฟล์</strong></td>
      </tr>
      <?
      	$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $file_pdf = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard]".".pdf";
			 	if(is_file($file_pdf)){
					$img_pdf = "<a href='$file_pdf' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับมีปัญหา xref' width='16' height='16' border='0'></a>";
				}else{
					$arrpdf = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,$rs[schoolid],"pdf");
					$img_pdf = $arrpdf['linkfile'];
				}//end if(is_file($file_pdf)){
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo $rs[idcard];?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><?=xshow_school($rs[schoolid]);?></td>
        <td align="left"><? if($xtype != "numall"){ echo XShowAreaSortName($rs[sitefile]); }else{ echo "";}?></td>
        <td align="center"><?=$rs[page_num]?></td>
        <td align="center"><?=$rs[page_upload]?></td>
        <td align="center"><?=$img_pdf?></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($action == "view1"){
		
?>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>