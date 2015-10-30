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
$time_conf = "09:20:00";

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}
</script>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="left" bgcolor="#A3B2CC"><strong>รายการการเข้าปฏิบัตงานของลูกจ้างชั่วคราว แสดงในกรณีเวลาเข้างาน มากกว่า 09:20 น. </strong></td>
        </tr>
      <tr>
        <td width="9%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="32%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="30%" align="center" bgcolor="#A3B2CC"><strong>วันที่</strong></td>
        <td width="29%" align="center" bgcolor="#A3B2CC"><strong>เวลาเข้างาน</strong></td>
      </tr>
	 <?
	 		$sql = "SELECT * FROM keystaff  WHERE sapphireoffice='0' AND status_permit='YES' AND status_extra <> 'QC' ORDER BY staffname ASC";
			//echo $sql;
			$result = mysql_db_query($db_name,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
			$i++;
			echo "<tr bgcolor='#F0F0F0'><td colspan='4' align='left'>$i.$rs[prename]$rs[staffname] $rs[staffsurname] :: [$rs[staffid]]</td></tr>";
				$sql1 = "SELECT  monitor_keyin.staffid, monitor_keyin.keyin_name,  date(monitor_keyin.timeupdate) as dd FROM monitor_keyin where staffid='$rs[staffid]' and date(timeupdate) > '2009-07-31'
group by dd order by dd asc";
				$result1 = mysql_db_query($db_name,$sql1);
				$j=0;
				while($rs1 = mysql_fetch_assoc($result1)){
				$j++;
					$bg = "#FFFFFF";
						########   
						$sql2 = "SELECT monitor_keyin.timeupdate  FROM monitor_keyin  WHERE  staffid='$rs[staffid]' AND timeupdate LIKE '$rs1[dd]%'  ORDER BY timeupdate ASC LIMIT 0,1";
						$result2 = mysql_db_query($db_name,$sql2);
						$rs2 = mysql_fetch_assoc($result2);
						$arr_d = explode(" ",$rs2[timeupdate]);
						$time_1 = $arr_d[1];
						if($time_1 > $time_conf){ // กรณีเข้างาน ช้ากว่า 09:20:00
		
		
				
	 ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i.".".$j;?></td>
        <td colspan="2" align="center"><?=show_date($arr_d[0]);?></td>
        <td align="center"><?=$arr_d[1]?></td>
      </tr>
	  <?	
				}//end 	if($time_1 > $time_conf){
	  		} //end while($rs1 = mysql_fetch_assoc($result1)){
	  	} //end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
