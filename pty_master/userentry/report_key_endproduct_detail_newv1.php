<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
session_start();
set_time_limit(0);
$ApplicationName	= "AdminReport";
$module_code 		= "statuser"; 
$process_id			= "display";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110701.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-01 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110701.00
	## Modified Detail :		รายงานข้อมูลการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-01 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			

			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("function_face2cmss.php");
			$time_start = getmicrotime();
			$point_per_doc = 69; // ค่าคะแนต่อชุด
			$arrsite = GetSiteKeyData();
			
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			$idcard_ex = GetCard_idExcerent();// เลขบัตรประจำตัวประชาชนของกลุ่ม excerent
			
			function GetShowGroupname(){
				global $dbnameuse;
				$sql = "SELECT keystaff_group.groupname, keystaff_group.groupkey_id FROM `keystaff_group`  ";
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql :: ".__LINE__);	
				while($rs = mysql_fetch_assoc($result)){
						$arr[$rs[groupkey_id]] = $rs[groupname];
				}//end while($rs = mysql_fetch_assoc($result)){
					return $arr;
			}//end 	function GetShowGroupname(){
				
			function GetShowGroupnameN(){
				global $dbnameuse;
				$sql = "SELECT keystaff_group_report.groupreport_name, keystaff_group_report.r_point FROM `keystaff_group_report` where  r_point > 0";	
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[r_point]] = $rs[groupreport_name];	
				}//end while($rs = mysql_fetch_assoc($result)){
					return $arr;
			}//end function GetShowGroupnameN(){

			
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>

</HEAD>
<BODY >
<?		
	$arrc = explode("||",$condate);	
	$cyy_cmm = date("Y-m");/// เดือนปัจจุบัน
	

	
	if(count($arrc) > 1){
			//$conv_date = "AND t2.datekeyin between '".$arrc[0]."' AND '".$arrc[1]."'";

				$conid_staff = " AND t2.date_start <= '".$arrc[0]."' AND t2.date_end >= '".$arrc[1]."' ";	
			
			
			$xhead = "ข้อมูลพนักงานระหว่างวันที่ ".DBThaiLongDateFull($arrc[0])." ถึง ".DBThaiLongDateFull($arrc[1])."".$arrsite[$site_id];
	}else{
			//$conv_date = " AND t2.datekeyin LIKE '".$arrc[0]."%'";				
			
				if($cyy_cmm == $arrc[0]){
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '".$arrc[0]."' AND t1.status_permit='YES'";
				}else{
					$conid_staff = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '".$arrc[0]."'";		
				}

			
			
			$arrd1 = explode("-",$arrc[0]);
			$xhead = " รายงานข้อมูลเดือน  ".$monthname[intval($arrd1[1])]." พ.ศ. ".($arrd1[0]+543)."  ".$arrsite[$site_id];	
	}
	
				if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con_idcard = " AND t1.card_id IN($in_pin)";	
					}else{
						$con_idcard = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){

	

	if($groupreport_id == "1"){ // กลุ่ม E
	
		$con1 = " and t2.group_id='2' ";
		if($idcard_ex != ""){
				$con1_1 = " and t1.card_id IN($idcard_ex)";
		}
		
			
	}else if($groupreport_id == "2"){
		$con1 = " and t2.group_id='2' ";
		if($idcard_ex != ""){
				$con1_1 = " and t1.card_id NOT IN($idcard_ex)";
		}

	}else{
		$con1 = " and t2.group_id='3'  AND t2.ratio_id='$rpoint'";
	}
	//$sql_staff = "SELECT * FROM keystaff as t1  WHERE t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0'  $con1 $con_idcard 
	//$conid_staff  $con1_1	 GROUP BY t1.staffid  ORDER BY t1.staffname ASC ";
	$sql_staff = "SELECT  *  FROM  keystaff_history as t2 Inner Join keystaff as t1 ON t2.staffid = t1.staffid WHERE   t1.period_time='am'  $con1 $con_idcard 
	$conid_staff  $con1_1  GROUP BY t1.staffid  ORDER BY t1.staffname ASC";
	
	$arr_g = GetShowGroupname();
	$arr_g1 = GetShowGroupnameN();	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" align="center" bgcolor="#A5B2CE"><strong><?=$xhead?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>รหัสพนักงาน</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>โคดพนักงาน</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชนพนักงาน</strong></td>
        <td width="28%" align="center" bgcolor="#A5B2CE"><strong>ชื่อนาม - นามสกุล</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>กลุ่มพนักงาน</strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>วันเริ่มทำงาน</strong></td>
      </tr>
      <?
      	$result = mysql_db_query($dbnameuse,$sql_staff) or die(mysql_error()."$sql_staff<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[staffid]?></td>
        <td align="center"><?=$rs[id_code]?></td>
        <td align="center"><?=$rs[card_id]?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="left"><? if($rs[ratio_id] > 0){ echo $arr_g1[$rs[ratio_id]];}else{ echo $arr_g[$rs[keyin_group]];}?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[start_date]);?></td>
      </tr>
      <?
		}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
