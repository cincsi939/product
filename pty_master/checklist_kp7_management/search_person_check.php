<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7_report_pobec"; 
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
             <td colspan="4" align="left" bgcolor="#CAD5FF"><strong>ค้นหาข้อมูลการตรวจเอกสาร</strong></td>
             </tr>
           <tr>
             <td width="14%" align="left" bgcolor="#FFFFFF"><strong>ชื่อบุคลากร </strong></td>
             <td width="18%" align="left" bgcolor="#FFFFFF"><label>
               <input name="key_name" type="text" id="key_name" value="<?=$key_name?>">
             </label></td>
             <td width="15%" align="left" bgcolor="#FFFFFF"><strong>นามสกุลบุคลากร</strong></td>
             <td width="53%" align="left" bgcolor="#FFFFFF"><label>
               <input name="key_surname" type="text" id="key_surname" value="<?=$key_surname?>">
             </label></td>
           </tr>
           <tr>
             <td align="left" bgcolor="#FFFFFF"><strong>รหัสบัตร</strong></td>
             <td align="left" bgcolor="#FFFFFF"><label>
               <input name="key_idcard" type="text" id="key_idcard" value="<?=$key_idcard?>">
             </label></td>
             <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
             <td align="left" bgcolor="#FFFFFF"><label></label></td>
           </tr>
           <tr>
             <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
             <td align="left" bgcolor="#FFFFFF"><label>
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
  if($search == "search"){
  	if($key_name != ""){ $conv .= " AND name_th LIKE '%$key_name%'";}
	if($key_surname != ""){ $conv .= " AND surname_th LIKE '%$key_surname%'";}
	if($key_idcard != ""){ $conv .= " AND idcard LIKE '%$key_idcard%'";}
	$sql_search = "SELECT * FROM tbl_checklist_kp7 WHERE siteid <> '' $conv";
	$result_search = mysql_db_query($dbtemp_check,$sql_search);
	$numr = @mysql_num_rows($result_search);
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td width="4%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="15%" align="center" bgcolor="#CAD5FF"><strong>รหัสบัตร</strong></td>
        <td width="17%" align="center" bgcolor="#CAD5FF"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="19%" align="center" bgcolor="#CAD5FF"><strong>ตำแหน่ง</strong></td>
        <td width="16%" align="center" bgcolor="#CAD5FF"><strong>สังกัด/หน่วยงาน</strong></td>
        <td width="29%" align="center" bgcolor="#CAD5FF"><strong>ผู้ตรวจเอกสาร</strong></td>
      </tr>
	  <?
	  	if($numr < 1){
			echo "<tr><td colspan='6'> - ไม่พบรายการที่ค้นหา -</td></tr>";
		}else{
		$i=0;
		while($rs = mysql_fetch_assoc($result_search)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		$log_user = search_person_check_kp7($rs[idcard]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="center"><?=$rs[position_now]?></td>
        <td align="left"><?=show_area($rs[siteid])?>/<?=show_school($rs[schoolid]);?></td>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="44%" align="center" bgcolor="#CCCCCC"><strong>ชือ - นามสกุล </strong></td>
                <td width="56%" align="center" bgcolor="#CCCCCC"><strong>วันที่ตรวจสอบ</strong></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td align="left"><?=$log_user['user']?></td>
                <td align="left"><?=$log_user['time']?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
	  <?
	  	}//end while(){
	  	}//end if($numr < 1){
	  ?>
	  
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