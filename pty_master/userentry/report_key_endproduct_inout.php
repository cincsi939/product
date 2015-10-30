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
			
			$config_num_min = 15;
			$config_num_max = 20;
			
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
	
		$con1 = " and t1.keyin_group='2' ";
		if($idcard_ex != ""){
				$con1_1 = " and t1.card_id IN($idcard_ex)";
				$constaff_tranfer = " and t1.card_id IN($idcard_ex) ";
		}
		
		
			
	}else if($groupreport_id == "2"){
		$con1 = " and t1.keyin_group='2' ";
		if($idcard_ex != ""){
				$con1_1 = " and t1.card_id NOT IN($idcard_ex)";
				$constaff_tranfer = " and t1.card_id NOT IN($idcard_ex) ";
		}
		
	}else{
		$con1 = " and t1.keyin_group='3'  AND t1.ratio_id='$rpoint'";
	
	}
		
	
	if($xtype == "inall" or $xtype == "outall" or $xtype == "numstaffkeyall"){
			$con1 = " and (t1.keyin_group='3' or t1.keyin_group='2')";	
	}
	

	
	$arrdate1 = explode("||",$condate1);	
	$arrdate2 = explode("||",$condate2);	
	if($xtype == "in" or $xtype == "inall"){
		$conpermit = " and t1.status_permit='YES'";
		if(count($arrdate) > 1){
			$conpermit .= " AND ((t1.start_date between '".$arrdate1[0]."' and '".$arrdate1[1]."') or (t1.start_date between '".$arrdate2[0]."' and '".$arrdate2[1]."') ) ";
			$constaff_tranfer1 = "((t2.datekeyin between '".$arrdate1[0]."' and '".$arrdate1[1]."') or (t2.datekeyin between '".$arrdate2[0]."' and '".$arrdate2[1]."')) and t2.keyin_group='3' ";
			$constaff_tranfer2 = "((t2.datekeyin between '".$arrdate1[0]."' and '".$arrdate1[1]."') or (t2.datekeyin between '".$arrdate2[0]."' and '".$arrdate2[1]."')) ";
			$xhead = "ข้อมูลพนักงานที่เข้างานระหว่างวันที่  ".DBThaiLongDateFull($arrdate2[0])." ถึง ".DBThaiLongDateFull($arrdate2[1])."".$arrsite[$site_id];
		}else{
			$conpermit .= " AND (t1.start_date LIKE '".$arrdate1[0]."%' or t1.start_date LIKE '".$arrdate2[0]."%' )";
			$constaff_tranfer1 = "((t2.datekeyin LIKE  '".$arrdate1[0]."%') or (t2.datekeyin LIKE  '".$arrdate2[0]."%')) and t2.keyin_group='3' ";
			$constaff_tranfer2 = "((t2.datekeyin LIKE  '".$arrdate1[0]."%') or (t2.datekeyin LIKE  '".$arrdate2[0]."%')) ";
				$arrd1 = explode("-",$arrdate1[0]);
				$arrd2 = explode("-",$arrdate2[0]);
				$xhead = " ข้อมูลพนักงานที่เข้างานเทียบเดือน  ".$monthname[intval($arrd1[1])]." พ.ศ. ".($arrd1[0]+543)." กับเดือน  ".$monthname[intval($arrd2[1])]." พ.ศ. ".($arrd2[0]+543)." ".$arrsite[$site_id];	

		}

	}else{
		$conpermit = " and t1.status_permit='NO'";	
		if(count($arrdate) > 1){
			$conpermit .= " AND ((t1.retire_date between '".$arrdate1[0]."' and '".$arrdate1[1]."') or (t1.retire_date between '".$arrdate2[0]."' and '".$arrdate2[1]."') ) ";
			$xhead = "ข้อมูลพนักงานที่ออกงานระหว่างวันที่  ".DBThaiLongDateFull($arrdate2[0])." ถึง ".DBThaiLongDateFull($arrdate2[1])."".$arrsite[$site_id];
		}else{
			$conpermit .= " AND (t1.retire_date LIKE '".$arrdate1[0]."%'  or  t1.retire_date LIKE '".$arrdate2[0]."%')";	
		
				$arrd1 = explode("-",$arrdate1[0]);
				$arrd2 = explode("-",$arrdate2[0]);
				$xhead = " ข้อมูลพนักงานที่ออกงานเทียบเดือน  ".$monthname[intval($arrd1[1])]." พ.ศ. ".($arrd1[0]+543)." กับเดือน  ".$monthname[intval($arrd2[1])]." พ.ศ. ".($arrd2[0]+543)." ".$arrsite[$site_id];	
		}

	}// end if($xtype == "in" or $xtype == "inall"){

	if($xtype == "numstaffkey" or $xtype == "numstaffkeyall"){
		$conpermit = " and t1.status_permit='YES' ";		
		$con_idcard = "";
			$xhead = "ข้อมูลพนักงานที่ยังทำงานอยู ณ วันที่ ".intval(date("d"))." เดือน ".$monthname[intval(date("m"))]." พ.ศ. ".(date("Y")+543)." ".$arrsite[$site_id];	
	}

	
	
	if($constaff_tranfer1 != "" and $xtype != "inall"){
	$sql_staff = "SELECT t1.staffid,t1.prename,t1.staffname,t1.staffsurname,t1.site_id,t1.keyin_group,t1.ratio_id,t1.start_date,t1.retire_date,max(numkpoint) as maxpoint,avg(numkpoint) as avgpoint,min(numkpoint) as minpoint,t1.status_permit,'' as numgroupN,'' as numall FROM keystaff as t1 Left Join stat_user_keyin AS t2 ON t1.staffid=t2.staffid 
	 WHERE t1.period_time='am'  and t1.sapphireoffice='0' and t1.status_extra='NOR'  $conpermit
	  $con1 $con_idcard   $con1_1	 GROUP BY t1.card_id   
	  
UNION
	  
	  SELECT 
t1.staffid,t1.prename,t1.staffname,t1.staffsurname,t1.site_id,t1.keyin_group,t1.ratio_id,t1.start_date,t1.retire_date,max(numkpoint) as maxpoint,avg(numkpoint) as avgpoint,min(numkpoint) as minpoint,t1.status_permit,
sum(if($constaff_tranfer1,1,0)) as numgroupN,
count(t1.staffid) as numall
FROM keystaff as t1  inner join stat_user_keyin as t2 on t1.staffid=t2.staffid  
WHERE t1.keyin_group='2' AND t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0' AND t1.status_permit='YES'  $constaff_tranfer
group by t1.staffid
having (numgroupN >= $config_num_min and  numall >= $config_num_max) or (numgroupN < $config_num_min and numall < $config_num_max)
ORDER BY site_id ASC, staffname ASC,staffsurname ASC";
	}else if($xtype == "inall"){
		
		$sql_staff = "SELECT t1.staffid,t1.prename,t1.staffname,t1.staffsurname,t1.site_id,t1.keyin_group,t1.ratio_id,t1.start_date,t1.retire_date,max(numkpoint) as maxpoint,avg(numkpoint) as avgpoint,min(numkpoint) as minpoint,t1.status_permit,'' as numgroupN,'' as numall FROM keystaff as t1 Left Join stat_user_keyin AS t2 ON t1.staffid=t2.staffid 
	 WHERE t1.period_time='am'  and t1.sapphireoffice='0' and t1.status_extra='NOR'  $conpermit
	  $con1 $con_idcard   $con1_1	 GROUP BY t1.card_id   
	  
UNION
	  
	  SELECT 
t1.staffid,t1.prename,t1.staffname,t1.staffsurname,t1.site_id,t1.keyin_group,t1.ratio_id,t1.start_date,t1.retire_date,max(numkpoint) as maxpoint,avg(numkpoint) as avgpoint,min(numkpoint) as minpoint,t1.status_permit,
sum(if($constaff_tranfer1,1,0)) as numgroupN,
count(t1.staffid) as numall
FROM keystaff as t1  inner join stat_user_keyin as t2 on t1.staffid=t2.staffid  
WHERE t1.keyin_group IN('2') AND t1.period_time='am' and t1.status_extra='NOR' and t1.sapphireoffice='0' AND t1.status_permit='YES'  
group by t1.staffid
having (numgroupN >= $config_num_min and  numall >= $config_num_max) or (numgroupN < $config_num_min and numall < $config_num_max)
ORDER BY site_id ASC, staffname ASC,staffsurname ASC";
	}else{
		$sql_staff = "SELECT t1.staffid,t1.prename,t1.staffname,t1.staffsurname,t1.site_id,t1.keyin_group,t1.ratio_id,t1.start_date,t1.retire_date,max(numkpoint) as maxpoint,avg(numkpoint) as avgpoint,min(numkpoint) as minpoint,t1.status_permit FROM keystaff as t1 Left Join stat_user_keyin AS t2 ON t1.staffid=t2.staffid 
	 WHERE t1.period_time='am'  and t1.sapphireoffice='0' and t1.status_extra='NOR'  $conpermit
	  $con1 $con_idcard   $con1_1	 GROUP BY t1.card_id  ORDER BY t1.site_id ASC, t1.staffname ASC,t1.staffsurname ASC ";	
	}
	//echo $sql_staff;
	
	$arr_g = GetShowGroupname();
	$arr_g1 = GetShowGroupnameN();	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../../images_sys/banner_cmss2_report.jpg" width="100%" height="130"></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="center" bgcolor="#A5B2CE"><strong><?=$xhead?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ชื่อนาม - นามสกุล</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>ศูนย์คีย์ข้อมูล</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>กลุ่มพนักงาน</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>วันเริ่มทำงาน</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>วันที่ออกงาน</strong></td>
        <td width="15%" align="center" bgcolor="#A5B2CE"><strong>คะแนนสูงสุด</strong></td>
        <td width="16%" align="center" bgcolor="#A5B2CE"><strong>คะแนนต่ำสุด</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>คะแนนเฉลี่ย</strong></td>
      </tr>
      <?
      	$result = mysql_db_query($dbnameuse,$sql_staff) or die(mysql_error()."$sql_staff<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
			if($xtype == "numstaffkey" or $xtype == "numstaffkeyall"){
				$rs[retire_date] = "";	
			}
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left" nowrap><? echo "<a href='report_key_endproduct_inout_detail.php?staffid=$rs[staffid]&status_permit=$rs[status_permit]&fullname=$rs[prename]$rs[staffname]  $rs[staffsurname]&datein=".DBThaiLongDateFull($rs[start_date])."&dateout=".DBThaiLongDateFull($rs[retire_date])."' target=\"_blank\">$rs[prename]$rs[staffname]  $rs[staffsurname]</a>";?></td>
        <td align="left" nowrap><?=$arrsite[$rs[site_id]]?></td>
        <td align="left"><? if($rs[ratio_id] > 0 and $rs[keyin_group] == "3" ){ echo $arr_g1[$rs[ratio_id]];}else{ echo $arr_g[$rs[keyin_group]];}?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[start_date]);?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[retire_date]);?></td>
        <td align="center"><?=number_format($rs[maxpoint],2)?></td>
        <td align="center"><?=number_format($rs[minpoint],2)?></td>
        <td align="center"><?=number_format($rs[avgpoint],2)?></td>
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
