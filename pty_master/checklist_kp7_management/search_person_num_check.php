<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "search_person"; 
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
include("checklist.inc.php");
$time_start = getmicrotime();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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
</head>
<body>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center"><form name="form1" method="post" action="">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
           <tr>
             <td colspan="4" align="left" bgcolor="#CAD5FF"><strong>ค้นหาพนักงานตรวจสอบข้อมูล</strong></td>
             </tr>
           <tr>
             <td width="17%" align="left" bgcolor="#FFFFFF"><strong>ชื่อพนักงาน</strong></td>
             <td width="20%" align="left" bgcolor="#FFFFFF"><label>
               <input name="key_staffname" type="text" id="key_staffname" value="<?=$key_staffname?>">
             </label></td>
             <td width="15%" align="left" bgcolor="#FFFFFF"><strong>นามสกุลพนักงาน</strong></td>
             <td width="48%" align="left" bgcolor="#FFFFFF"><label>
               <input name="key_staffsurname" type="text" id="key_staffsurname" value="<?=$key_staffsurname?>">
             </label></td>
           </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF"><strong>วันที่ตรวจสอบเอกสาร</strong></td>
             <td colspan="3" align="left" bgcolor="#FFFFFF"> 
			 <? ######### 30/11/2552
			 if	($c_date == ""){ 
				$thyy = date("Y")+543 ; 
			 	//$c_date = date(d ."/".m."/".$thyy ) ; 
				$c_date = (date("d/m/")).$thyy;
			 }  ####### END  if	($c_date == ""){ 
			 if($e_date == ""){
					$thyy1 = date("Y")+543;
					$e_date = (date("d/m/")).$thyy1;
			}
			 ?>			 
			 <label><INPUT name="c_date" onFocus="blur();" value="<?=$c_date?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.c_date, 'dd/mm/yyyy')"value="วันเดือนปี"></label>
			&nbsp; ถึงวันที่ &nbsp;<INPUT name="e_date" onFocus="blur();" value="<?=$e_date?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.e_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
             </tr>
           <tr>
             <td colspan="4" align="center" bgcolor="#FFFFFF"><label>
			 <input type="hidden" name="search" value="search">
               <input type="submit" name="Submit" value="ค้นหา">
               <input type="reset" name="Submit2" value="ล้างข้อมูล">
             </label></td>
             </tr>
         </table></td>
       </tr>
     </table>
      </form>
   </td>
 </tr>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <? 
if ($search == ""){ $search =    "search" ; } ############  บังคับให้ เข้าครั้งแรกแสดงข้อมูลของวันนี้
  if($search == "search"){
	  ###  กรณีเลือกวันเริ่มต้นและวันสิ้นสุดให้เลือกเป็น ช่วงวันที่
	  	if($c_date != "" and $e_date != ""){
			$key_date = " AND date(edubkk_checklist.tbl_checklist_log.time_update) BETWEEN  '".sw_dateE($c_date)."' AND '".sw_dateE($e_date)."' ";	
		}else if($c_date != "" and $e_date == ""){
			$key_date = " AND  date(edubkk_checklist.tbl_checklist_log.time_update) LIKE '%".sw_dateE($c_date)."%'";	
		}else if($e_date != "" and $c_date == ""){
			$key_date = " AND  date(edubkk_checklist.tbl_checklist_log.time_update) LIKE '%".sw_dateE($e_date)."%'";	
		}else{
			$key_date = "";	
		}//end if($c_date != "" and $e_date != ""){
	  
//  	if($c_date != ""){
// 		$key_date = " AND  date(edubkk_checklist.tbl_checklist_log.time_update) LIKE '%".sw_dateE($c_date)."%'";
//	}else{
//		$key_date = "";
//	}
	if($key_staffname != ""){ $conv .= " and callcenter_entry.keystaff.staffname like '%$key_staffname%'";}
	if($key_staffsurname != ""){ $conv .= " and callcenter_entry.keystaff.staffsurname like '%$key_staffsurname%'";}
	
$sql_search = "SELECT
callcenter_entry.keystaff.staffid,
callcenter_entry.keystaff.prename,
callcenter_entry.keystaff.staffname,
callcenter_entry.keystaff.staffsurname,
edubkk_checklist.tbl_checklist_log.user_update,
callcenter_entry.keystaff.sapphireoffice,
edubkk_checklist.tbl_checklist_log.time_update,
date(edubkk_checklist.tbl_checklist_log.time_update) as date_c
FROM
edubkk_checklist.tbl_checklist_log
Inner Join callcenter_entry.keystaff ON edubkk_checklist.tbl_checklist_log.user_update = callcenter_entry.keystaff.staffid
WHERE
edubkk_checklist.tbl_checklist_log.type_action =  '1' $conv
$key_date
group by edubkk_checklist.tbl_checklist_log.user_update 
order by date_c ASC
";
//echo $sql_search;
	$result_search = mysql_db_query($dbtemp_check,$sql_search);
	$numr = @mysql_num_rows($result_search);
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td width="6%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="20%" align="center" bgcolor="#CAD5FF"><strong>ชื่อ-นามสกุลพนักงาน</strong></td>
        <td width="22%" align="center" bgcolor="#CAD5FF"><strong>วันที่ตรวจสอบเอกสาร</strong></td>
        <td width="29%" align="center" bgcolor="#CAD5FF"><strong>ประเภทพนักงาน</strong></td>
        <td width="23%" align="center" bgcolor="#CAD5FF"><strong>จำนวนที่ตรวจเอกสาร</strong></td>
      </tr>
	  <?
	  	if($numr < 1){
			echo "<tr bgcolor='#F0F0F0'><td colspan='6'> - ไม่พบรายการที่ค้นหา -</td></tr>";
		}else{
		$i=0;
		while($rs = mysql_fetch_assoc($result_search)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		//$log_user = search_person_check_kp7($rs[idcard]);
		## กรณีเลือกการค้นหาเป็นแบบช่วงเวลา
		if($c_date != "" and $e_date != ""){ 
				$txt_date = get_dateThai(sw_dateE($c_date),"T")." ถึง ".get_dateThai(sw_dateE($e_date),"T");	
				$num_check = count_check_kp7($rs[user_update],sw_dateE($c_date),sw_dateE($e_date));
		}else{ // กรณีเลือกวันเดียว
				$txt_date = get_dateThai(sw_dateE($c_date),"T");	
				if($c_date != "" and $e_date == ""){
					$num_check = count_check_kp7($rs[user_update],sw_dateE($c_date),"");	
				}else if($e_date != "" and $c_date == ""){
					$num_check = count_check_kp7($rs[user_update],sw_dateE($e_date),"");	
				}
				
		}//end if($c_date != "" and $e_date != ""){ 
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center"><?=$txt_date;?></td>
        <td align="left"><?=show_type_staff($rs[sapphireoffice]);?></td>
        <td align="center"><? if($num_check > 0){ 
		$start_date = sw_dateE($c_date);
		$end_date = sw_dateE($e_date);
		echo "<a href='search_person_num_check_detail.php?action=view&staffid=$rs[user_update]&key_date=$rs[date_c]&staffname=$rs[prename]$rs[staffname] $rs[staffsurname]&show_date=$txt_date&sdate=$start_date&edate=$end_date' target='_blank'>".number_format($num_check)."</a>";}else{ echo "0";}?></td>
      </tr>
      	  <?
		  $sum_numcheck += $num_check;
	  	}//end while(){
	  	}//end if($numr < 1){
	  ?>
      <tr>
        <td colspan="4" align="right" bgcolor="#FFFFFF"><strong> รวม : </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=number_format($sum_numcheck)?>
        </strong></td>
      </tr>

    </table></td>
  </tr>
  <?
  	}//end   if($search == "search"){
  ?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>