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

$yymm = "2011-05";

$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";
$dbnameuse = DB_USERENTRY;

$host = HOST;
$user = "cmss";
$pass = "2010cmss";


	
	function GetStartWork($pin){
		global $dbface,$host_face,$user_face,$pass_face;
			ConHost($host_face,$user_face,$pass_face); // connect faceaccess
			$sql = "SELECT pin, start_work FROM `faceacc_officer` where pin='$pin'";
			$result = mysql_db_query($dbface,$sql) or die(mysql_error()."".__LINE__);
			$rs = mysql_fetch_assoc($result);
			return DBThaiLongDate( $rs[start_work]);
	}//end function GetStartWork($pin){
	

		

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="3%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="7%" align="center" bgcolor="#A3B2CC"><strong>รหัสพนักงาน</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="7%" align="center" bgcolor="#A3B2CC"><strong>วันเริ่มงาน</strong></td>
        <td width="9%" align="center" bgcolor="#A3B2CC"><strong>กลุ่มการทำงาน</strong></td>
        <td width="11%" align="center" bgcolor="#A3B2CC"><strong>ค่าคะแนนทั้งหมด</strong></td>
        <td width="10%" align="center" bgcolor="#A3B2CC"><strong>จุดผิด</strong></td>
        <td width="15%" align="center" bgcolor="#A3B2CC"><strong>จำนวนวัน</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>คะแนนสุทธิ</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>คะแนนเฉลี่ยสุทธิ</strong></td>
      </tr>
      <?
      	$sql = "SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.card_id,
keystaff_group.groupname
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
where keyin_group='3' and status_permit='YES' and status_extra='NOR'
order by  staffname asc";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
$j=0;
while($rs = mysql_fetch_assoc($result)){
		 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
/*		 $sql1 = "SELECT
stat_user_keyin.datekeyin,
stat_user_keyin.staffid,
stat_user_keyin.numkpoint,
stat_subtract_keyin.spoint
FROM
stat_user_keyin
left Join stat_subtract_keyin ON stat_user_keyin.datekeyin = stat_subtract_keyin.datekey AND stat_user_keyin.staffid = stat_subtract_keyin.staffid
where stat_user_keyin.staffid='$rs[staffid]'
order by stat_user_keyin.datekeyin desc
limit 14";*/

	$sql1 = "SELECT
stat_user_keyin.datekeyin,
stat_user_keyin.staffid,
stat_user_keyin.numkpoint,
stat_subtract_keyin.spoint
FROM
stat_user_keyin
left Join stat_subtract_keyin ON stat_user_keyin.datekeyin = stat_subtract_keyin.datekey AND stat_user_keyin.staffid = stat_subtract_keyin.staffid
where stat_user_keyin.staffid='$rs[staffid]'  and datekeyin <='2011-06-04' and (datekeyin LIKE '2011-06%'  or  datekeyin LIKE '2011-05%')
order by stat_user_keyin.datekeyin desc
limit 14";
			$result1 = mysql_db_query($dbnameuse,$sql1);
			$numr1 = mysql_num_rows($result1);
	if($numr1 > 0){
			while($rs1 = mysql_fetch_assoc($result1)){
					$sumpoint += $rs1[numkpoint];
					$sumsub_point += $rs1[spoint];
			}
		 
		 $sql_max = "SELECT  incentive FROM  stat_incentive WHERE staffid='$rs[staffid]' and datekeyin LIKE '$yymm%'  order by datekeyin DESC LIMIT 1 ";
		 $resultm = mysql_db_query($dbnameuse,$sql_max) or die(mysql_error()."$sql_max<br>LINE::".__LINE__) ;
		 $rsm = mysql_fetch_assoc($resultm);
		 $dates = GetStartWork($rs[card_id]);
		 if($dates == ""){
			 ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
			$sql_min = "SELECT  min(datekeyin) as mind FROM  stat_incentive WHERE staffid='$rs[staffid]'";	
			$result_min = mysql_db_query($dbnameuse,$sql_min);	 
			$rsm1 = mysql_fetch_assoc($result_min);
			$dates= DBThaiLongDate($rsm1[mind]);
		}
		
		$net_point = $sumpoint-$sumsub_point;
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="center"><? echo "$rs[staffid]";?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center"><?=$dates;?></td>
        <td align="center"><?=$rs[groupname]?></td>
        <td align="center"><?=number_format($sumpoint,2)?></td>
        <td align="center"><?=number_format($sumsub_point,2)?></td>
        <td align="center"><?=$numr1?></td>
        <td align="center"><?=number_format($net_point,2)?></td>
        <td align="center"><? if($net_point > 0){ echo number_format($net_point/$numr1,2);}else{ echo "0";}?></td>
      </tr>
      <?
	  $sumpoint=0;
	  $sumsub_point = 0;
	}//end 
	
}// end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
