<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "manage_keyin_data"; 
$process_id			= "report_staffkey_addpercen";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		รายงานคะแนนเพิ่มการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			$k12 = 0.1051;
			$percenadd = 5;
			
			$count_yy = date("Y")+543;
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

			
			$time_start = getmicrotime();
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			
			
			
			
			
	function ShowStartdate($staffid){
	global $dbnameuse;
	$sql = "SELECT start_date FROM `keystaff` where staffid='$staffid' group by staffid";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		return ShowDateThai($rs[start_date]);
	}else{
		return "";	
	}
}
			
			
		function ShowDateThai($get_date){
			global $mname;
			$arr = explode(" ",$get_date);
			if($arr > 1){
				$get_date = $arr[0];
			}
			if($get_date != "0000-00-00"){
				$arr1 = explode("-",$get_date);	
				return intval($arr1[2])." ".$mname[intval($arr1[1])]." ".substr(($arr1[0]+543),-2);
			}else{
				return "";	
			}
		}//end function ShowDateThai($get_date){

			
				function GetSiteReport(){
		global $dbnameuse;
		$sql = "SELECT
t2.site_id
FROM
keyin_area_profile as t1
Inner Join keyin_area_site_profile as t2 ON t1.profile_id = t2.profile_id
where t1.profile_id='2'";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[site_id]] = $rs[site_id];
				
		}// end while($rs = mysql_fetch_assoc($result)){
			return $arr;
	}//end function GetSiteReport(){
		
			if($group_id == ""){
		$group_id = 3;	
	}
	
	
	if($yy == ""){
			$yy = date("Y")+543;
	}
	if($mm == ""){
			$mm = sprintf("%02d",date("m"));
	}
	
	$yy1 = $yy;
	$yy = $yy-543;
	$yymm = $yy."-".$mm;
	if($yymm == ""){
			$yymm = date("Y-m");
	}

		
		
		
	function ShowDayOfMonth($yymm){
	$arr_d1 = explode("-",$yymm);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // วันเริ่มต้น
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // ฝันที่สุดท้ายของเดือน
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					//if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					//}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($yymm){
		
	$arrprov = GetSiteReport(); // พื้นที่ที่เป็นจังหวัดอุดร
	
	
		$arrdate = ShowDayOfMonth($yymm);
		
		if(count($arrdate) > 0){
			foreach($arrdate as $key => $val){
				$sumcount += count($val);
			}
		}//end if(count($arrdate) > 0){


	$col_w = 60; // อัตราความกว้าวของวันที่
	if($sumcount > 0){
		$width_col = $col_w/$sumcount;
	}else{
		$width_col = $col_w;
	}
	
	
$suby = substr($yymm,0,4);
$subm = substr($yymm,-2);


			
			
			


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="../../../common/jquery_1_3_2.js"></script>


</HEAD>
<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <form id="form1" name="form1" method="post" action="">       
 </strong> เดือน&nbsp;
<select name="mm" id="mm">
                  <option value="">เลือกเดือน</option>
                  <?
                  	for($m = 1 ; $m <= 12 ; $m++ ){
						$xmm = sprintf("%02d",$m);
						if($xmm == $mm){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$xmm' $sel>$monthFull[$m]</option>";
					}//end for($m = 1 ; $m <= 12 ; $m++ ){
				  ?>

</select> 
         &nbsp;   <strong>ปี</strong>
<select name="yy" id="yy">
                 <option value="">เลือกปี</option>
                 <?
                 	for($y = 2552 ; $y <= $count_yy ; $y++){
						if($y == $yy1){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>

</select>&nbsp;
เลือกกลุ่ม 
<select name="group_id" id="group_id"> 

            <option value="" >เลือกกลุ่มการคีย์ข้อมูล</option>
            <?
            	$sql_g = "SELECT * FROM `keystaff_group` where status_active='1'";
				$result_g = mysql_db_query($dbnameuse,$sql_g);
				while($rsg = mysql_fetch_assoc($result_g)){
					if($rsg[groupkey_id] == $group_id){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rsg[groupkey_id]' $sel>$rsg[groupname]</option>";
				}
		
				
			?>
        </select>
            &nbsp;&nbsp; ที่ตั้งศูนย์คีย์: 
            <select name="site_id" id="site_id"> 
            <option value="" > - เลือกที่ตั้ง - </option>
                 <option value="999" <? if($site_id == "999"){ echo " selected='selected' ";}?>>เลือกทั้งหมด</option>
                 <?
                 	if(count($arrsite) > 0){
							foreach($arrsite as $kk => $vv){
								if($kk == $site_id){ $sel = " selected='selected' ";}else{ $sel = "";}
									echo "<option value='$kk' $sel>$vv</option>";
							}
					}//end 	if(count($arrsite) > 0){
				 ?>
            </select>
            &nbsp;&nbsp;ชื่อพนักงาน : 
           
            <input type="text" name="staffname" id="staffname" value="<?=$staffname?>">&nbsp;นามสกุลพนักงาน : <input type="text" name="staffsurname" id="staffsurname" value="<?=$staffsurname?>">
    <input type="submit" name="button" id="button" value="ค้นหา" /></form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="4%" rowspan="2" align="center" bgcolor="#999999">รหัส<br>
          พนักงาน</td>
        <td width="8%" rowspan="2" align="center" bgcolor="#999999">ชื่อ นามสกุล</td>
        <td width="6%" rowspan="2" align="center" bgcolor="#999999">กลุ่มการคีย์ข้อมูล</td>
        <td width="6%" rowspan="2" align="center" bgcolor="#999999">วันที่เริ่มทำงาน</td>
        <td width="11%" rowspan="2" align="center" bgcolor="#999999">ศูนย์คีย์ฯ</td>
        <td width="8%" rowspan="2" align="center" bgcolor="#999999">ค่าประสิทธิ์ภา<br>
          พการทำงานของ Server(K)</td>
        <td width="6%" rowspan="2" align="center" bgcolor="#999999">เปอร์เซ็น<br>
          บวกเพิ่ม(P)</td>
       <?
      	   foreach($arrdate as $k => $v){
				 foreach($v as $k1 => $v1){

	  ?>

        <td colspan="3" align="center" bgcolor="#999999"><strong><?=ShowDateThai($v1)?></strong></td>
        
        <?
				 }//end foreach($v as $k1 => $v1){
		   }//end  foreach($arrdate as $k => $v){
			   
			   
			  foreach($arrdate as $k => $v){
				  foreach($v as $k1 => $v1){
		?>
        
        
        <td width="6%" rowspan="2" align="center" bgcolor="#999999">รวม(Key)</td>
        <td width="6%" rowspan="2" align="center" bgcolor="#999999">รวม(Key_P)</td>
        <td width="7%" rowspan="2" align="center" bgcolor="#999999">รวม(Key_P_K)</td>
        <td width="6%" rowspan="2" align="center" bgcolor="#999999">ค่าสัมประสิทธิ์</td>
        <td width="6%" rowspan="2" align="center" bgcolor="#999999">คะแนนสุทธิ</td>
      </tr>
      
            <?
      	
			  }// end  foreach($v as $k1 => $v1){
			 }// end  foreach($v as $k1 => $v1){
	  ?>

      
      <tr>
        <td width="6%" align="center" bgcolor="#999999">คะแนนก่อน<br>
          หักจุดผิด(Key)</td>
        <td width="6%" align="center" bgcolor="#999999">คะแนนบวก P(Key_P)</td>
        <td width="8%" align="center" bgcolor="#999999">คะแนนบวก P บวก K(Key_P_K)</td>
        </tr>
        <?
        
			
				$sql_g = "SELECT * FROM `keystaff_group` where status_active='1'";
				$result_g = mysql_db_query($dbnameuse,$sql_g);
				while($rsg = mysql_fetch_assoc($result_g)){
					$arrgroup[$rsg[groupkey_id]] = $rsg[groupname];
				}


 if($site_id != "999" and $site_id != ""){
		$in_pin = GetPinStaff($site_id);
		if($in_pin != ""){ $conv2 = " AND t1.card_id IN($in_pin)";}else{ $conv2 = " AND t1.card_id='1'";}
 }//end  if($site_id != "999"){
			
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);   
if($staffname != ""){
		$conw1 .= " AND t1.staffname LIKE '%$staffname%' ";
}
if($staffsurname != ""){
		$conw1 .= " AND t1.staffsurname LIKE '%$staffsurname%' ";
}
$sql = "SELECT
t1.id_code,
t1.staffid,
t1.staffname,
t1.staffsurname,
t1.keyin_group,
count(t2.datekeyin) as numr,
t1.site_id
FROM
keystaff as t1
LEFT Join stat_user_keyin as t2 ON t1.staffid = t2.staffid and t2.datekeyin LIKE '$yymm%'
where t1.keyin_group='$group_id' and t1.status_permit='YES' and t1.status_extra='NOR' $conw1 $conv2
group by t1.staffid
order by numr DESC,t1.staffsurname ASC";
//echo $sql;
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 if($site_id != "999" and $site_id != ""){
				$site_id = $site_id	;
			}else{
				$site_id = $rs[site_id]	;	
			}
			

if(array_key_exists($site_id,$arrprov)) {
   $provname = "อุดรธานี";
}else{
	$provname = "เชียงใหม่";
}
	

		?>
        
        
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$rs[id_code]?></td>
        <td align="left" nowrap="nowrap"><? echo "$rs[staffname] $rs[staffsurname]";?></td>
        <td align="left" nowrap="nowrap"><? echo $arrgroup[$rs[keyin_group]];?></td>
        <td align="left" nowrap="nowrap"><?=ShowStartdate($rs[staffid]);?></td>
        <td align="left"><?=$arrsite[$site_id]?></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <?
        	 foreach($arrdate as $k => $v){
				  foreach($v as $k1 => $v1){
		?>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <?
				  }//end   foreach($v as $k1 => $v1){
			 }//end foreach($arrdate as $k => $v){
		?>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?
			 }
	  ?>
    </table></td>
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
