<?
include("epm.inc.php"); // 

		
if($action == "process"){
	$sql = "SELECT ".DB_USERENTRY.".keystaff.staffid, ".DB_USERENTRY.".keystaff.prename, ".DB_USERENTRY.".keystaff.staffname, ".DB_USERENTRY.".keystaff.staffsurname, ".DB_USERENTRY.".tbl_assign_sub.ticketid, ".DB_USERENTRY.".tbl_assign_key.idcard, ".DB_USERENTRY.".tbl_assign_key.fullname,
 ".DB_MASTER.".eduarea.secname
FROM ".DB_USERENTRY.".keystaff
Inner Join ".DB_USERENTRY.".tbl_assign_sub ON ".DB_USERENTRY.".keystaff.staffid = ".DB_USERENTRY.".tbl_assign_sub.staffid
Inner Join ".DB_USERENTRY.".tbl_assign_key ON ".DB_USERENTRY.".tbl_assign_sub.ticketid = ".DB_USERENTRY.".tbl_assign_key.ticketid
Left Join  ".DB_MASTER.".eduarea ON ".DB_USERENTRY.".tbl_assign_key.siteid =  ".DB_MASTER.".eduarea.secid
WHERE ".DB_USERENTRY.".keystaff.status_permit =  'NO' AND ".DB_USERENTRY.".keystaff.status_extra =  'NOR' AND
date(tbl_assign_sub.timeupdate) >=  '2011-01-01' AND ".DB_USERENTRY.".tbl_assign_key.status_keydata =  '0'
ORDER BY ".DB_USERENTRY.".keystaff.staffname ASC, ".DB_USERENTRY.".tbl_assign_sub.ticketid ASC";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql_temp = "REPLACE INTO assign_keyin_staff_out SET ticketid='$rs[ticketid]',idcard='$rs[idcard]',staffid='$rs[staffid]'";
	mysql_db_query($dbnameuse,$sql_temp);
	$sql_del = "DELETE FROM tbl_assign_key WHERE  ticketid='$rs[ticketid]' AND idcard='$rs[idcard]' ";
	echo "$sql_del<br>";
	mysql_db_query($dbnameuse,$sql_del);
		
}//end while($rs = mysql_fetch_assoc($result)){
		
}//end if($action == "process"){


?>