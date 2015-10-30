<?
session_start();
include("checklist.inc.php");

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
<? if($action == ""){?>
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
             <td colspan="3" align="left" bgcolor="#FFFFFF"><label><INPUT name="c_date" onFocus="blur();" value="<?=$c_date?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.c_date, 'dd/mm/yyyy')"value="วันเดือนปี"></label>               <label></label></td>
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
  	if($c_date != ""){
 		$key_date = " AND  date(edubkk_checklist.tbl_checklist_log.time_update) LIKE '%".sw_dateE($c_date)."%'";
	}else{
		$key_date = "";
	}
	if($key_staffname != ""){ $conv .= " and callcenter_entry.keystaff.staffname like '%$key_staffname%'";}
	if($key_staffsurname != ""){ $conv .= " and callcenter_entry.keystaff.staffsurname like '%$key_staffsurname%'";}
}//end   if($search == "search"){
	
$sql_search = "SELECT 
 callcenter_entry.keystaff.staffid,
callcenter_entry.keystaff.prename,
callcenter_entry.keystaff.staffname,
callcenter_entry.keystaff.staffsurname
FROM
edubkk_checklist.tbl_checklist_log
Inner Join callcenter_entry.keystaff ON edubkk_checklist.tbl_checklist_log.user_update = callcenter_entry.keystaff.staffid
WHERE
edubkk_checklist.tbl_checklist_log.type_action =  '1'$conv
$key_date GROUP BY  callcenter_entry.keystaff.staffid";
//echo $sql_search;
	$result_search = mysql_db_query($dbtemp_check,$sql_search);
	$numr = @mysql_num_rows($result_search);
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td width="5%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="39%" align="center" bgcolor="#CAD5FF"><strong>ชื่อ-นามสกุลพนักงาน</strong></td>
        <td width="27%" align="center" bgcolor="#CAD5FF"><strong>จำนวนเอกสารที่ตรวจสอบทั้งหมด(ชุด)</strong></td>
        <td width="29%" align="center" bgcolor="#CAD5FF"><strong>จำนวนการตรวจสอบเฉลี่ยต่อวัน</strong></td>
      </tr>
	  <?
	  	if($numr < 1){
			echo "<tr bgcolor='#F0F0F0'><td colspan='6'> - ไม่พบรายการที่ค้นหา -</td></tr>";
		}else{
		$i=0;
		while($rs = mysql_fetch_assoc($result_search)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
//		$log_user = search_person_check_kp7($rs[idcard]);
//		$num_check = count_check_kp7($rs[user_update],$rs[date_c]);
//		$txt_date = get_dateThai($rs[time_update],"T");
		$num_check_person = CountPersonCheck($rs[staffid]);
		$num_avg = CountCheckAvg($rs[staffid]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center"><? if($num_check_person > 0){ echo "<a href='?action=view1&staffid=$rs[staffid]&staffname=$rs[prename]$rs[staffname] $rs[staffsurname]&search=$search&c_date=$c_date&key_staffname=$key_staffname&key_staffsurname=$key_staffsurname'>".number_format($num_check_person)."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=$num_avg?></td>
      </tr>
	  <?
	  	}//end while(){
	  	}//end if($numr < 1){
	  ?>
	  
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<?
 } //end action == ""
 if($action == "view1"){
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="3" align="left" bgcolor="#CAD5FF"><a href="?action=&search=<?=$search?>&c_date=<?=$search?>&key_staffname=<?=$key_staffname?>&key_staffsurname=<?=$key_staffsurname?>">กลับหน้าหลัก</a>&nbsp;&nbsp;<strong>รายละเอียดการบันทึกการตรวจสอบเอกสารของ <?=$staffname?></strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="64%" align="center" bgcolor="#CAD5FF"><strong>วันที่ตรวจสอบข้อมูล</strong></td>
        <td width="31%" align="center" bgcolor="#CAD5FF"><strong>จำนวนเอกสารที่ตรวจสอบ(ชุด)</strong></td>
      </tr>
	  <?
	  	$sql = "SELECT
distinct edubkk_checklist.tbl_checklist_log.idcard,
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
edubkk_checklist.tbl_checklist_log.type_action =  '1' AND edubkk_checklist.tbl_checklist_log.user_update='$staffid'
group by  date(edubkk_checklist.tbl_checklist_log.time_update) 
";	
	$result = mysql_db_query($dbtemp_check,$sql);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	$txt_date = get_dateThai($rs[time_update],"T");
	$num_check = count_check_kp7($rs[user_update],$rs[date_c]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$txt_date?></td>
        <td align="center"><? if($num_check > 0){ echo "<a href='?action=view2&staffid=$staffid&date_check=$rs[date_c]&fullname=$rs[prename]$rs[staffname] $rs[staffsurname]&show_date=$txt_date' target='_blank'>".number_format($num_check)."</a>";}else{ echo "0";}?></td>
      </tr>
	  <?
	}//end while(){
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end  if($action == "view1"){
	if($action == "view2"){ //  รายละเอียดข้อมูลบุคลากรที่ตรวจสอบ
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#CAD5FF"><strong>รายงานการตรวจข้อมูลของ
            <?=$fullname?>
ประจำวันที่
<?=$show_date?>
        </strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="23%" align="center" bgcolor="#CAD5FF"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="23%" align="center" bgcolor="#CAD5FF"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="22%" align="center" bgcolor="#CAD5FF"><strong>ตำแหน่ง</strong></td>
        <td width="26%" align="center" bgcolor="#CAD5FF"><strong>สังกัด</strong></td>
      </tr>
	  <?
$sql_view = "SELECT
 tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid
FROM
tbl_checklist_log
Inner Join tbl_checklist_kp7 ON tbl_checklist_log.idcard = tbl_checklist_kp7.idcard
WHERE tbl_checklist_log.type_action =  '1' AND tbl_checklist_log.user_update =  '$staffid'
GROUP BY  tbl_checklist_kp7.idcard
ORDER BY tbl_checklist_kp7.siteid ASC, tbl_checklist_kp7.name_th ASC 
";
$result_view = mysql_db_query($dbtemp_check,$sql_view);
$i=0;
while($rs_v =mysql_fetch_assoc($result_view)){
if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs_v[idcard]?></td>
        <td align="center"><? echo "$rs_v[prename_th]$rs_v[name_th]  $rs_v[surname_th]";?></td>
        <td align="center"><?=$rs_v[position_now]?></td>
        <td align="center"><? echo show_area($rs_v[siteid])."/".show_school($rs_v[schoolid]);?></td>
      </tr>
	  <?
}//end 	  	
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end if($action == "view2"){
?>
</body>
</html>
