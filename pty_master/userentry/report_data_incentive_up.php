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
$yymm1 = "2011-03";
$yymm2 = "2011-04";
$yymm3 = "2011-05";
$dateconfig = "2011-03-01"; // วันที่เริ่มเก็บสถิติ

$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";
$dbnameuse = "edubkk_userentry";

$host = HOST;
$user = "cmss";
$pass = "2010cmss";


	
/*	function GetStartWork($pin){
		global $dbface,$host_face,$user_face,$pass_face;
			ConHost($host_face,$user_face,$pass_face); // connect faceaccess
			$sql = "SELECT pin, start_work FROM `faceacc_officer` where pin='$pin'";
			$result = mysql_db_query($dbface,$sql) or die(mysql_error()."".__LINE__);
			$rs = mysql_fetch_assoc($result);
			return DBThaiLongDate( $rs[start_work]);
	}//end function GetStartWork($pin){
*/	

		

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
        <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="16%" align="center" bgcolor="#A3B2CC"><strong>รหัสพนักงาน</strong></td>
        <td width="16%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>วันเริ่มงาน</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>กลุ่มการทำงาน</strong></td>
        <td width="12%" align="center" bgcolor="#A3B2CC"><strong>incentive (บาท)</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>incentive เฉลี่ยต่อวัน</strong></td>
        <td width="14%" align="center" bgcolor="#A3B2CC"><strong>จำนวนผลผลิต/วัน(ชุด)</strong></td>
      </tr>
      <?
      	$sql = "SELECT * FROM `a_stat_incentive_key`";
		$result = mysql_db_query($dbnameuse,$sql);
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
		 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 
		$sql_max1 = "SELECT  incentive FROM  stat_incentive WHERE staffid='$rs[staffid]' and datekeyin LIKE '$yymm1%'  order by datekeyin DESC LIMIT 1 ";
		 $resultm1 = mysql_db_query($dbnameuse,$sql_max1) or die(mysql_error()."$sql_max<br>LINE::".__LINE__) ;
		 $rsm1 = mysql_fetch_assoc($resultm1);

		 $sql_max2 = "SELECT  incentive FROM  stat_incentive WHERE staffid='$rs[staffid]' and datekeyin LIKE '$yymm2%'  order by datekeyin DESC LIMIT 1 ";
		 $resultm2 = mysql_db_query($dbnameuse,$sql_max2) or die(mysql_error()."$sql_max<br>LINE::".__LINE__) ;
		 $rsm2 = mysql_fetch_assoc($resultm2);
		 
		 $sql_max3 = "SELECT  incentive FROM  stat_incentive WHERE staffid='$rs[staffid]' and datekeyin LIKE '$yymm3%'  order by datekeyin DESC LIMIT 1 ";
		 $resultm3 = mysql_db_query($dbnameuse,$sql_max3) or die(mysql_error()."$sql_max<br>LINE::".__LINE__) ;
		 $rsm3 = mysql_fetch_assoc($resultm3);
		 
		 $incentive_sum = ($rsm1[incentive]+$rsm2[incentive]+$rsm3[incentive]);

		// $dates = GetStartWork($rs[card_id]);
		$sql_count = "SELECT COUNT(staffid) AS numc FROM stat_incentive WHERE staffid='$rs[staffid]' and datekeyin > '$dateconfig%' GROUP BY staffid ";
		$result_count = mysql_db_query($dbnameuse,$sql_count) or die(mysql_error()."$sql_count<br>LINE::".__LINE__);
		$rsc = mysql_fetch_assoc($result_count);
		
		$sql_num = "SELECT avg(stat_user_keyin.numkpoint)/69 as avgpoint FROM `stat_user_keyin` WHERE staffid='$rs[staffid]' and datekeyin > '$dateconfig%'";
		$result_num = mysql_db_query($dbnameuse,$sql_num) or die(mysql_error()."$sql_num<br>LINE::".__LINE__);
		$rsnum = mysql_fetch_assoc($result_num);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="center"><? echo "$rs[staffid]";?></td>
        <td align="left"><? echo "$rs[fullname]";?></td>
        <td align="center"><? echo "$rs[date_start]"?></td>
        <td align="center"><?=$rs[groupname]?></td>
        <td align="center"><?=$incentive_sum?></td>
        <td align="center"><? if($rsc[numc] > 0){ echo number_format($incentive_sum/$rsc[numc],2);}else{ echo "0";}?></td>
        <td align="center"><?=substr($rsnum[avgpoint],0,4);?></td>
      </tr>
      <?
}// end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
