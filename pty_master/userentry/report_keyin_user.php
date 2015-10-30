<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$curent_date = date("Y-m-d");
			
			
			$dbnameuse = "edubkk_userentry";
			
			$time_start = getmicrotime();
			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

	  		function compare_order_asc($a, $b)			
			{
				global $sortname;
				return strnatcmp($a["$sortname"], $b["$sortname"]);
			}
			
			 function compare_order_desc($a, $b)			
			{
				global $sortname;
				return strnatcmp($b["$sortname"], $a["$sortname"]);
			}
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				if($temp != ""){
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 " ;
				return $xrs;
				}else{
				$xrs = "<font color=red>Not Available</font>";
				return $xrs;
				}
			}
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]-543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}


	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$date1 = swapdate($date1);
		$datereq1 = $date1 ;
		$exday = explode("-",$date1);
		$datereq = ($exday[0]+543)."-$exday[1]-$exday[2]";
		
		
	}else{
		
		$dd = date("d");
		$mm = date("m");
		$dd2 = $dd-1;
		$yy=date("Y");
		$yy += 543;
		$dd = sprintf("%02d",intval($dd));
		$dd2 = sprintf("%02d",intval($dd2));
		$mm = sprintf("%02d",intval($mm));
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		$datereq2 = "$yy-$mm-$dd2";
		$round = "am" ;
		
	}

	if($round == "am"){
		$checked1 = "checked" ;
		$checked2 = "" ;
	}else{
		$checked1 = "" ;
		$checked2 = "checked" ;
	}

$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
}


###หาจุดฟิล์ดที่จะนำไปคำนวณจุด
function CheckFieldPoint($get_tbl){
	global $dbnameuse;
	$sql_checkfield = "SELECT * FROM keyin_point WHERE keyinpoint > 0 AND tablename='$get_tbl'";
	$result_checkfield = mysql_db_query($dbnameuse,$sql_checkfield);
	while($rs_chF = mysql_fetch_assoc($result_checkfield)){
		$arr[] = $rs_chF[keyname];	
	}//end while($rs_chF = mysql_fetch_assoc($result_checkfield)){
	return $arr;
}//end function CheckFieldPoint(){
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script>
var imgDir_path="../../common/popup_calenda/images/calendar/";
</script>
<script src="../../common/popup_calenda/popcalendar.js" type="text/javascript"></script>
<script src="../../common/popup_calenda/function.js" type="text/javascript"></script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" colspan="2" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px">รายงานสถิติการบันทึกข้อมูล</td>
        </tr>
		   <tr>
          <td width="63%" class="headerTB">&nbsp;</td>
          <td width="37%">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
	  <form name="form" method="post" action="">
	<table width="100%" height="19" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="13%" align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="59%" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="28%" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#CCCCCC" class="indexbold">&nbsp;</td>
        <td bgcolor="#CCCCCC" class="indexbold">วัน เดือน ปี
          <input type="text" name="date1" value="<?=swapdate($datereq)?>" size="10">
            <input type=button NAME="d1" id="d1"  onclick='popUpCalendar(this, this.form.date1, "dd/mm/yyyy");' value=' วันเดือนปี ' style='font-size:11px'>
            &nbsp;
            <input type="submit" name="Submit" value="   ค้นหา   ">		  </td>
        <td align="center" bgcolor="#CCCCCC"><a href="CC_keyin_user.inc.php?process=run" target="_blank"><img src="../../images_sys/refresh.png" width="16" height="16" border="0">ประมวลค่าสูงสุดและค่าเฉลี่ย</a></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><input name="round" type="radio" value="am" <?=$checked1?>>
          รอบเช้า 
            <input name="round" type="radio" value="pm" <?=$checked2?>>
            รอบบ่าย</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
    </table>
      </form>    
<?
if($action==""){  
//echo "date :: ".$date1." date c :: ".$datereq1;
	if($date1 == ""){
			$date1 = date("Y-m-d");
	}
	//echo "date :: ".$date1;
?>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" id="table0" class="sortable">
  <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
    <td height="24" align="center" class="fillcolor_menu"><strong>ลำดับ</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ชื่อ-นามสกุล</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ประวัติการทำงานวันนี้</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ประวัติการทำงาน<br>
    รายชั่วโมง</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ประวัติการทำงานทั้งหมด</strong></td>
    <td align="center" class="fillcolor_menu"><strong>สถานที่ทำงาน</strong></td>
    <td align="center" class="fillcolor_menu"><strong>จำนวนคน</strong></td>
    <td align="center" class="fillcolor_menu"><strong>จำนวนรายการ</strong></td>
    <td align="center" class="fillcolor_menu"><strong>ค่าคะแนน<br>
      การทำงาน</strong></td>
  </tr>
<?
if($date1 < $curent_date){
$sql = "SELECT
keystaff.staffid
FROM
keystaff
Inner Join stat_user_keyin ON keystaff.staffid = stat_user_keyin.staffid
WHERE
stat_user_keyin.datekeyin LIKE  '$datereq1%' 
AND
period_time = '$round' GROUP BY keystaff.staffid ";
$conwhere = "";
}else{
$sql = "
SELECT 
keystaff.staffid
FROM keystaff Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid
WHERE  ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' )  AND timestamp_key LIKE  '$datereq1%'
AND period_time = '$round'
GROUP BY  keystaff.staffid
ORDER BY keystaff.staffid ASC
";
$conwhere = " AND  keystaff.status_permit='YES' ";
}//end if($date1 < $curent_date){
//echo "$sql <br>" ; die;

### แสดงข้อมูลทุกคนที่เคยบันทึกข้อมูล
$sql = "SELECT
keystaff.staffid
FROM
keystaff
Inner Join monitor_keyin  ON keystaff.staffid = monitor_keyin.staffid
where sapphireoffice='0' $conwhere
GROUP BY  keystaff.staffid
ORDER BY keystaff.staffid ASC";
// AND ( keystaff.sapphireoffice = 0 ) AND ( keystaff.status = '$round' ) AND  (keystaff.sapphireoffice = 0)
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){

//echo "$rs[staffid] <br>";

  $arr_staff[] = $rs[staffid] ;
}  

$arr_staff = array_unique($arr_staff) ;

//echo "<pre>";print_r($arr_staff);echo "</pre>";

$i = 0 ;
$n=0;

foreach($arr_staff AS $key1 => $val1){
  if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
    
  //echo "$name<br>";
$numrows =0 ;  

$TNUM = 0 ;
$TPOINT = 0 ;
$j =1 ;

if($date1 < $curent_date){
		$sql1 = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,

monitor_keyin.idcard,
monitor_keyin.timeupdate
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid

WHERE   ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' )   AND   keystaff.staffid =  '$val1' AND (monitor_keyin.timestamp_key LIKE  '$datereq1%' or monitor_keyin.timeupdate LIKE  '$datereq1%' )  GROUP BY idcard   ORDER BY keystaff.staffid ASC        " ;
//echo $sql1;
$result1 = mysql_db_query($dbnameuse,$sql1);
$rs1 = mysql_fetch_assoc($result1);
//echo " $sql1 <br> $name : $rs1[idcard] <hr> "; 
$numrows = mysql_num_rows($result1);
	
$sql_db = "SELECT * FROM `stat_user_keyin` where datekeyin LIKE '$datereq1%' and staffid='$val1'";
$result_db = mysql_db_query($dbnameuse,$sql_db);
$rs_db = mysql_fetch_assoc($result_db);
##### ค่าสถิติการบันทึกข้อมูล
$TPOINT = $rs_db[numkpoint];
$TNUM = $rs_db[numkeyin];
if($rs_db[numperson] > 0){ $numrows = $rs_db[numperson];}else{ $numrows = $numrows;}

$xresult3 = mysql_db_query("edubkk_master"," SELECT  *   FROM  view_general  WHERE  CZ_ID = '$rs1[idcard]' ");
$xrs3 = mysql_fetch_assoc($xresult3);
$dbsite = STR_PREFIX_DB.$xrs3[siteid] ;

//echo "$TPOINT<br>";
	  	$sql3 = " SELECT  count(username) AS NUM ,  user_ip  FROM  log_update WHERE  username = '$rs1[idcard]' AND staff_login='$rs1[staffid]'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  )     GROUP BY username  ORDER BY   subject  DESC limit 1 ";
		//echo "$rs3[siteid]  : $sql2<br>";
		$result3 = mysql_db_query($dbsite,$sql3) ;
		$rs3= mysql_fetch_assoc($result3);

}else{
	$sql1 = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,

monitor_keyin.idcard,
monitor_keyin.timeupdate
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid

WHERE   ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' )   AND   keystaff.staffid =  '$val1' AND monitor_keyin.timestamp_key LIKE  '$datereq1%'  GROUP BY idcard   ORDER BY keystaff.staffid ASC        " ;

$result1 = mysql_db_query($dbnameuse,$sql1);
//echo " $sql1 <br> $name : $rs1[idcard] <hr> "; 
$numrows = mysql_num_rows($result1);	
while($rs1 = mysql_fetch_assoc($result1)){
	
$result3 = mysql_db_query("edubkk_master"," SELECT  *   FROM  view_general  WHERE  CZ_ID = '$rs1[idcard]' ");
$rs3 = mysql_fetch_assoc($result3);
$dbsite = STR_PREFIX_DB.$rs3[siteid] ;

	//echo "รหัสบัตร :: $rs3[CZ_ID]  ::  $rs3[prename_th]$rs3[name_th]  $rs3[surname_th] ::   ค่าคะแนน :: ";		
	  	

		foreach($arr_f_tbl1 AS $key => $val){
			$t = explode("#",$val);
			$c = cond_str($t[1]);
			$xa1 = explode("||",$t[1]);
			
			
			  #### หาฟิลด์ที่จะนำเป็นเป็นเงือนไขการคิดคำนวณจุด
			  $arrF = CheckFieldPoint($t[0]);
  

			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
			if($rs_ff[Field] != "" ){ $contimestamp = " AND $rs_ff[Field] LIKE '$datereq1%' ";}else{ $contimestamp = "";}
			
			$str_listfield = "SHOW COLUMNS FROM $t[0]".$subfix." WHERE TYPE NOT LIKE '%timestamp%' AND Extra NOT LIKE '%auto_increment%' ";
			$result_listfield = mysql_db_query($dbsite,$str_listfield);
			$xi = 0;
			$list_field = "";
			while($rs_l = mysql_fetch_assoc($result_listfield)){
				if(in_array($rs_l[Field],$arrF)){
					if($list_field > "") $list_field .= ","; 
					$list_field .= " $rs_l[Field] ";
					$xi++;
				}//end if(in_array($rs_l[Field],$arrF)){
			}//end while($rs_l = mysql_fetch_assoc($result_listfield)){

	if($list_field != ""){ 
		$sql_c1 = "SELECT ".$list_field." ,min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rs1[idcard]'  $contimestamp  GROUP BY $c";
			//$sql_c1 = "SELECT ".$list_field." ,min(auto_id) as auto_id, id,runid  FROM $t[0]".$subfix." WHERE id='$rs1[idcard]'  $contimestamp  GROUP BY $c";
	}else{
		$sql_c1 = "SELECT min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rs1[idcard]'  $contimestamp  GROUP BY $c";	
		//$sql_c1 = "SELECT min(auto_id) as auto_id, id,runid  FROM $t[0]".$subfix." WHERE id='$rs1[idcard]'  $contimestamp  GROUP BY $c";	
	}
		
		$result_c1 = mysql_db_query($dbsite,$sql_c1);
//		if($result_c1){
//			echo "รันผ่าน  :: ".$sql_c1."<br><br>";	
//		}else{
//			echo "รันไม่ผ่าน :: ".$sql_c1."<br><br>";	
//		}
		
	while($rs_c1 = mysql_fetch_assoc($result_c1)){
				$sql_c2 = "SELECT ".$list_field." ,auto_id, $c  FROM $t[0]".$subfix_befor." WHERE id='$rs1[idcard]' AND auto_id='$rs_c1[auto_id]' GROUP BY $c";
				//echo $sql_c2."<br> รหัสบัต :: $rs_c2[id]<hr>";
				$result_c2 = mysql_db_query($dbsite,$sql_c2);
				$rs_c2 = mysql_fetch_assoc($result_c2);
				$calcuatepoint=false ;
				if($rs_c2[id] > 0){
					//echo "รหัสคนคีย์ปัจจุบัน  :: ".$rs1[staffid]."<br>";
					/// selectr  staff ที่มี auto_id น้อยกว่าของบรรทัดเดียวกัน   ก่อนหน้าว่าเป็นตัวเองหรือไม่ หากไม่ใช่ให้คิดคะแนนรายจุด โดย	 $calcuatepoint =true	
					$conList = "";
					foreach($xa1 as $xk1 => $xv1){
						if($conList != "") $conList .= " AND "; 
						$conList .= "$xv1='".$rs_c1[$xv1]."'";
							
					}
					if($conList != ""){ $conA = " AND ";}else{ $conA = "";}
					
					$sql_check = "SELECT staffid  FROM $t[0]".$subfix_befor." WHERE id='$rs1[idcard]' and auto_id < '$rs_c1[auto_id]'  $conA $conList ORDER BY  auto_id DESC LIMIT 0,1";
					//echo $sql_check."<br>";
					$result_check = mysql_db_query($dbsite,$sql_check);
					$rs_check = mysql_fetch_assoc($result_check);

					if($rs_check[staffid] != $rs1[staffid]){
						
						$calcuatepoint = true;
					}//end if($rs_check[staffid] != $rs1[staffid]){
							if($calcuatepoint==true){
							$result1_diff = array_diff_assoc($sql_c1, $sql_c2);
							//echo "<pre>";
							//print_r($result1);
							
							$numpoint  = count($result1_diff);
							//echo "จำนวนรายการที่แก้ไข :: ".$numpoint."<br>";
								if($numpoint > 0){ // กรณีมีจุดการบันทึกที่ต่างกันให้คำณวณโดยใช้ค่า price_point ในการคูณ
									$tb1 = $t[0]."$subfix";
									$TPOINT  +=   $numpoint*$price_point[$tb1];
									//echo "$numpoint  :: "."$numpoint* ". $price_point[$tb1]."<br>";
								}//end if($numpoint > 0){
							}//end if($calcuatepoint==true){
							
									
					
				}else{
					//echo $sql_c1."<br>";
						$tb1 = $t[0]."$subfix";
						$TNUM += 1;
						$TPOINT += 1*$k_point[$tb1];
						//echo "จำนวนรายการที่เพิ่มใหม่  :: $TPOINT :: 1 *  ".$k_point[$tb1]."<br>";
				}// end if($rs_c2[id] > 0){
				
		}//end while($rs_c1 = mysql_fetch_assoc($result_c1)){

}//echo "$dbsite : $TNUM + $rs2[NUM] : <br> $sql2 <hr>";
		$j++ ; 
}

}//end if($date1 < $curent_date){


$sql3 = " SELECT  count(username) AS NUM ,  user_ip  FROM  log_update WHERE   staff_login='$val1'  AND logtime LIKE  '$datereq1%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  )  and  (user_ip <> '' or user_ip IS NOT NULL) GROUP BY username  ORDER BY   subject  DESC limit 1 ";
//echo "$rs3[siteid]  : $sql3<br>";
$result3 = mysql_db_query($dbsite,$sql3) ;
$rs3= mysql_fetch_assoc($result3);

$resultx= mysql_db_query($dbnameuse," SELECT  *    FROM  keystaff  WHERE  staffid  = '$val1' ");
$rsx = mysql_fetch_assoc($resultx);
$name = "$rsx[prename]$rsx[staffname]  $rsx[staffsurname]"; 


//echo "$name : $val1  $rsx[status] == $round || $rsx[status] :: value = $TPOINT<br>";

		if(substr($rs3[user_ip],0,8)=="192.168."){ $place = "Office";}else{$place = "InternetCafe";}
		
		//if(substr($rs3[user_ip],0,8) == "192.168."){ // แสดงหน้ารายงานเฉพาะ พนักงานที่คีย์ข้อมูลข้างใน
		$n++;
		
		if($TPOINT > 0 ){ $arrnum[] = $TPOINT ; }
		//echo "$name : $val1  $rsx[status] == $round || $rsx[status] :: value = $TPOINT<br>";
		
	 ?>	
  <tr bgcolor="#<?=$bgcolor1?>">
    <td width="2%" height="18" align="center"><?=$n?></td>
    <td width="23%">&nbsp;      <? echo "$name : $val1 "; ?></td>

      <td width="10%" align="center"><a href="report_keyin_user3.php?staffid=<?=$val1?>&datereq=<?=$datereq?>" target="_blank"><img src="images/cal.jpg" width="16" height="16" border="0"></a></td>
      <td width="10%" align="center"><a href="CC_log_keyin.php?staffid=<?=$val1?>&datereq=<?=$datereq?>" target="_blank"><img src="../../images_sys/history.gif" width="16" height="16" border="0"></a></td>
      <td width="13%" align="center"><a href="report_keyin_user2.php?staffid=<?=$val1?>" target="_blank"><img src="images/calendar.jpg" width="16" height="16" border="0"></a></td>
      <td width="14%" align="center"><?=$place?></td>
	    <td width="7%" align="center"><?=$numrows?> </td>
    <td width="11%" align="center"><?=$TNUM?></td>
    <td width="10%" align="center"><?=$TPOINT?></td>
  </tr>
  <?
	//}//end if(substr($rs3[user_ip],0,8) == "192.168."){

  }
  ?>
</table>
<?

rsort($arrnum);
$maxkey = $arrnum[0];
reset($arrnum);
sort($arrnum);
$minkey = $arrnum[0];
reset($arrnum);
$numuser  = count($arrnum);
$sumarr = array_sum($arrnum);

?>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr>
    <td width="44%" align="center" bgcolor="#5C85EF" class="link_back">รายการ </td>
    <td width="20%" align="center" bgcolor="#5C85EF" class="link_back">ค่าคะแนน</td>
    <td width="36%" bgcolor="#5C85EF">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าสูงสุด</td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=$maxkey?></td>
    <td bgcolor="#B7CBCF" class="link_back">คะแนน</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าต่ำสุด</td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=$minkey?></td>
    <td bgcolor="#B7CBCF" class="link_back">คะแนน</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#B7CBCF" class="link_back">ค่าเฉลี่ย </td>
    <td align="center" bgcolor="#CCCCCC" class="link_back">&nbsp;<?=number_format(($sumarr/$numuser),2)?></td>
    <td bgcolor="#B7CBCF" class="link_back">คะแนน</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#B7CBCF" class="headerTB">&nbsp;</td>
    <td bgcolor="#B7CBCF">&nbsp;</td>
    <td bgcolor="#B7CBCF">&nbsp;</td>
  </tr>
</table>
<? } ?>
</BODY></HTML>