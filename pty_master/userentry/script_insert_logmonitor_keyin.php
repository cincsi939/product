<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";

if($action == "process"){
		$sql = "SELECT
tbl_assign_key.idcard,
tbl_assign_key.fullname,
tbl_assign_key.siteid,
tbl_assign_sub.staffid,
tbl_assign_key.status_keydata,
t2.sapphireoffice,
t2.status_extra
FROM ".DB_USERENTRY.".tbl_assign_sub
inner join ".DB_USERENTRY.".keystaff as t2 ON ".DB_USERENTRY.".tbl_assign_sub.staffid=t2.staffid
Inner Join ".DB_USERENTRY.".tbl_assign_key ON ".DB_USERENTRY.".tbl_assign_sub.ticketid = ".DB_USERENTRY.".tbl_assign_key.ticketid
Inner Join  ".DB_MASTER.".view_general AS t1 ON ".DB_USERENTRY.".tbl_assign_key.idcard = t1.CZ_ID
Left Join ".DB_USERENTRY.".monitor_keyin ON ".DB_USERENTRY.".tbl_assign_key.idcard = ".DB_USERENTRY.".monitor_keyin.idcard 

WHERE
tbl_assign_key.userkey_wait_approve =  '1' 
AND
t2.status_permit = 'YES' and 
t2.status_extra='NOR'and 
monitor_keyin.idcard IS NULL
		";		
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$db_site = STR_PREFIX_DB.$rs[siteid];
				$sql_log = "SELECT logtime FROM  log_update WHERE username='$rs[idcard]' AND staff_login ='$rs[staffid]' group by date(logtime)";
				$result_log = mysql_db_query($db_site,$sql_log);
				$i=0;
				while($rslog = mysql_fetch_assoc($result_log)){
					if($rs[sapphireoffice] == 1){
						$status_user = 1; // พนักงาน sapphire
					}else if($rs[sapphireoffice] != 1 and $rs[status_extra] == "QC"){
						$status_user = 2; // ลูกจ้างชั่วคราวที่กำหนดในเป็น qc
					}else{
						$status_user = 0;// พนักงานจ้าง
					}

					
						$i++;
					if($i=="1"){
							$sql_insert = "INSERT INTO monitor_keyin SET staffid='$rs[staffid]',idcard='$rs[idcard]',keyin_name='$rs[fullname]',siteid='$rs[siteid]',status_key='100',timeupdate='$rslog[logtime]',timestamp_key='$rslog[logtime]',timeupdate_user='$rslog[logtime]',status_user='$status_user'";
							mysql_db_query($dbnameuse,$sql_insert);
					}else{
								$sql_insert = "UPDATE  monitor_keyin SET  timestamp_key='$rslog[logtime]',timeupdate_user='$rslog[logtime]' WHERE staffid='$rs[staffid]' AND idcard='$rs[idcard]'";
							mysql_db_query($dbnameuse,$sql_insert);
					}
					if($i == 2){ break;}
				}// end while($rslog = mysql_fetch_assoc($result_log)){
				
		}//end while($rs = mysql_fetch_assoc($result)){

}//end if($action == "process"){


?>
<a href="?action=process">ประมวลผลข้อมูล</a>