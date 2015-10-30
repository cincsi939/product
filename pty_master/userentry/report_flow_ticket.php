<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");

function show_position($idcard){
	global $dbnamemaster;
	$sql = "SELECT position_now FROM view_general WHERE CZ_ID='$idcard' ";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[position_now];
}

function xshow_area($idcard){
	global $dbnamemaster;
	
	$db_site = STR_PREFIX_DB.$siteid;
	$sql = "SELECT schoolid  FROM view_general WHERE CZ_ID='$idcard' ";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);

	$sql = "SELECT office FROM allschool WHERE id='$rs[schoolid]'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[office];
}
?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript">
function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
    document.location = delUrl;
  }
}
</script>
</head>
<body bgcolor="#EFEFFF">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="7" align="center" bgcolor="#A3B2CC"><strong><?=$secname?>&nbsp;&nbsp; <?=$xtitle?></strong></td>
          </tr>

        <tr>
          <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
          <td width="13%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตร</strong></td>
          <td width="16%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล[บุคลากร]</strong></td>
          <td width="15%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
          <td width="17%" align="center" bgcolor="#A3B2CC"><strong>หน่วยงาน</strong></td>
          <td width="13%" align="center" bgcolor="#A3B2CC"><strong>รหัสใบจ่ายงาน (Ticketid) </strong></td>
          <td width="22%" align="center" bgcolor="#A3B2CC"><strong>ชื่อผู้ดำเนินการ </strong></td>
        </tr>
		<?
		
		
	if($action == "qc_pass"){ // กรณีรายการ ตรวจสอบข้อมูลผ่าน
		if($xtype != "2"){
			$con_sql = "  AND  (t4.sapphireoffice =  '$xtype' OR t4.sapphireoffice IS NULL )  AND t2.approve =  '2' AND t1.siteid =  '$xsiteid'  AND t2.profile_id='$profile_id' AND  t1.profile_id='$profile_id'";
		}else{
			$con_sql = "  AND  t4.sapphireoffice ='$xtype' AND t2.approve =  '2' AND t1.siteid =  '$xsiteid'  AND t2.profile_id='$profile_id' AND  t1.profile_id='$profile_id'";	
		}
	}else if($action == "qc_wait"){ // รายการที่รอ QC
		$con_sql = "  AND  (t4.sapphireoffice =  '$xtype' OR t4.sapphireoffice IS NULL )  AND t2.approve =  '3' AND t1.siteid =  '$xsiteid'  AND t2.profile_id='$profile_id' AND  t1.profile_id='$profile_id'";
	}else if($action == "waitkey"){
		$con_sql = "  AND   (t4.sapphireoffice =  '$xtype' OR t4.sapphireoffice IS NULL ) AND (t2.approve =  '0' or t2.approve = '1') AND t2.status_keydata='0' AND t4.status_permit='YES' AND t1.siteid =  '$xsiteid'  AND t2.profile_id='$profile_id' AND  t1.profile_id='$profile_id'";
	}else if($action == "Outkey"){
			$con_sql = "  AND  (t4.sapphireoffice =  '$xtype' OR t4.sapphireoffice IS NULL ) AND (t2.approve =  '0' or t2.approve = '1') AND t2.status_keydata='0' AND t4.status_permit='NO' AND t1.siteid =  '$xsiteid'  AND t2.profile_id='$profile_id' AND  t1.profile_id='$profile_id'";
	}else{ // รายการ ค้างดำเนินการ
		$con_sql = "  AND  (t4.sapphireoffice =  '$xtype' OR t4.sapphireoffice IS NULL ) AND (t2.approve =  '0' or t2.approve = '1') AND t2.status_keydata='1' AND t1.siteid =  '$xsiteid' AND t2.profile_id='$profile_id' AND  t1.profile_id='$profile_id'";
	}
/*$sql = "SELECT 
t3.idcard,t3.fullname,t3.ticketid,t2.prename,t2.staffname,t2.staffsurname 
FROM tbl_assign_sub as t1
Inner Join keystaff as t2 ON t1.staffid = t2.staffid 
Inner Join tbl_assign_key as t3 ON t1.ticketid = t3.ticketid 
Inner Join   ".DB_CHECKLIST.".tbl_check_data as t4 ON t4.idcard=t3.idcard 
$con_sql
GROUP BY t3.idcard";*/
$sql = "SELECT
t1.idcard,concat(t1.prename_th,t1.name_th,' ',t1.surname_th) as fullname,t2.ticketid,t4.prename,t4.staffname,t4.staffsurname 

FROM
 ".DB_CHECKLIST.".tbl_checklist_kp7 as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid and t1.profile_id='$profile_id' and t2.profile_id='$profile_id'
Left Join ".DB_USERENTRY.".tbl_assign_sub as t3 ON t2.ticketid = t3.ticketid
Left Join ".DB_USERENTRY.".keystaff as t4 ON t3.staffid = t4.staffid
WHERE
((t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0') or
(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0')) $con_sql  ORDER BY t1.schoolid ASC ,t1.name_th ,t1.surname_th ASC
";

#echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
	 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$j?></td>
          <td align="left"><?=$rs[idcard]?></td>
          <td align="left"><?=$rs[fullname]?></td>
          <td align="left"><?=show_position($rs[idcard]);?></td>
          <td align="left"><?=xshow_area($rs[idcard]);?></td>
          <td align="center"><?=$rs[ticketid]?></td>
          <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        </tr>
		<?
			} // end 	while($rs = mysql_fetch_assoc($result)){
		?>
      </table></td>
    </tr>
  </table>
</BODY>
</HTML>
