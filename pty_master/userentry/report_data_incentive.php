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
	include("../../config/conndb_nonsession.inc.php");
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
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="19%" align="center" bgcolor="#A3B2CC"><strong>รหัสพนักงาน</strong></td>
        <td width="19%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>วันเริ่มงาน</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>กลุ่มการทำงาน</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>incentive (บาท)</strong></td>
        <td width="15%" align="center" bgcolor="#A3B2CC"><strong>จำนวนผลผลิต/วัน(ชุด)</strong></td>
      </tr>
      <?
	  ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
      	$sql = "SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
Max(stat_incentive.incentive) AS incentive,
keystaff_group.groupname,
floor(Avg(stat_incentive.numkpoint/69)) AS num_doc,
keystaff.card_id
FROM
keystaff
Inner Join stat_incentive ON keystaff.staffid = stat_incentive.staffid
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE
stat_incentive.datekeyin LIKE  '$yymm%'
GROUP BY
keystaff.staffid
order by keystaff_group.groupkey_id asc,staffname asc";
$result = mysql_db_query($dbnameuse,$sql);
$j=0;
while($rs = mysql_fetch_assoc($result)){
		 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
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
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="center"><? echo "$rs[staffid]";?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname] $rs[staffsurname]";?></td>
        <td align="center"><?=$dates;?></td>
        <td align="center"><?=$rs[groupname]?></td>
        <td align="center"><?=$rsm[incentive]?></td>
        <td align="center"><?=$rs[num_doc]?></td>
      </tr>
      <?
}// end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
