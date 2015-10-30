<? session_start() ; 
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName    = "competency_percenentry_byarea";
$module_code         = "percenentry_byarea"; 
$process_id            = "percenentry_byarea";
$VERSION                 = "9.91";
$BypassAPP             = true;

//$_SESSION[secid];
    ###################################################################
    ## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
    ###################################################################
    ## Version :        20090703.001 (Created/Modified; Date.RunNumber)
    ## Created Date :        2009-07-03 09:49
    ## Created By :        Rungsit
    ## E-mail :            
    ## Tel. :            
    ## Company :        Sappire Research and Development Co.,Ltd. (C)All Right Reserved
    ###################################################################
    ## Version :        20090703.002
    ## Modified Detail :        ระบบฐานข้อมูลบุคลากร
    ## Modified Date :        2009-07-03 09:49
    ## Modified By :        MR.SUWAT KHAMTUM
###################################################################


//set_time_limit(0) ; 
//if ( $_SESSION[siteid]   != ""){ 
    # $_SESSION[reportsecid]
//} 
//if ($xsiteid == ""){ $xsiteid = $_SESSION[siteid]  ;    $xxsiteid = $xsiteid  ; } 

//if ($loginid != ""){   $xxsiteid = $loginid  ; } 
//if ($_SESSION[reportsecid] == "cmss-otcsc" ){
    ########### ok 
//} ### END if ($_SESSION[reportsecid] == "cmss-otcsc" ){
//
/*echo "<pre>";
print_r($_SESSION);
*/
//if($xsiteid != ""){ $xsiteid = $xsiteid;}else{ $xsiteid = "5006";}; // กรณีทดสอบในเครื่อง



include("../config/conndb_nonsession.inc.php");
include("../common/common_competency.inc.php");
include("positionsql.inc_v2.php");
include("percen_entry_v4.inc.php");
include("genlink_menu.php");  

$edubkk_master = DB_MASTER ; 
$lead_general = "general";
$view_general = "view_general";

if($_GET['xsiteid']==""){
	$dbconnect = $edubkk_master;
	$ccType = 'Changwat';
}else{
	$type_level = 3;
	$Pcode = $xsiteid;
	$dbconnect = STR_PREFIX_DB. $xsiteid ; 
}
$time_start = getmicrotime();
$Disp=$_REQUEST[Disp];
$siteid=$_REQUEST[scid]; 


    $month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $dd = date("j")   ; 
    $mm1 = date("n")  ; 
    $mm =  $month[$mm1] ; 
    $yy = date("Y") + 543 ; 
    $nowdd = " $dd $mm  $yy "  ; 
    $view_general = "view_general" ; 

	$getdepid = $depid ;


function count_province($Digi,$orSQL){
	$sql ="SELECT
					Count(view_general.CZ_ID) AS royal_count 
					FROM
					view_general
					Inner Join eduarea
					Inner Join allschool ON view_general.schoolid = allschool.id AND allschool.siteid = eduarea.secid
					WHERE
					(SUBSTR(view_general.birthday,1,4)+60) = '".(date('Y')+543)."' 
					AND $orSQL
					AND eduarea.provid='$Digi'
					GROUP BY
					eduarea.provid
	";
	$query = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($query);
	$vitaya_count = $row['royal_count'];
	return $vitaya_count;
}

function count_province_total($orSQL){
	$sql ="SELECT
					Count(view_general.CZ_ID) AS royal_count 
					FROM
					view_general
					Inner Join eduarea
					Inner Join allschool ON view_general.schoolid = allschool.id AND allschool.siteid = eduarea.secid
					WHERE
					(SUBSTR(view_general.birthday,1,4)+60) = '".(date('Y')+543)."' 
					AND $orSQL
					
	";
	$query = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($query);
	$vitaya_count = $row['royal_count'];
	return $vitaya_count;
}

function count_site($Digi,$orSQL){
	$sql ="SELECT
					Count(view_general.CZ_ID) AS royal_count 
					FROM
					view_general
					Inner Join eduarea
					Inner Join allschool ON view_general.schoolid = allschool.id AND allschool.siteid = eduarea.secid
					WHERE
					(SUBSTR(view_general.birthday,1,4)+60) = '".(date('Y')+543)."' 
					AND $orSQL
					AND eduarea.secid='$Digi'
					GROUP BY
					eduarea.provid
	";
	$query = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($query);
	$vitaya_count = $row['royal_count'];
	return $vitaya_count;
}

function count_site_total($Digi,$orSQL){
	$sql ="SELECT
					Count(view_general.CZ_ID) AS royal_count 
					FROM
					view_general
					Inner Join eduarea
					Inner Join allschool ON view_general.schoolid = allschool.id AND allschool.siteid = eduarea.secid
					WHERE
					(SUBSTR(view_general.birthday,1,4)+60) = '".(date('Y')+543)."' 
					AND $orSQL
					AND eduarea.provid='$Digi'
					GROUP BY
					eduarea.provid
	";
	$query = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($query);
	$vitaya_count = $row['royal_count'];
	return $vitaya_count;
}

function count_school($Digi,$orSQL,$DBsite){
	 $sql ="SELECT COUNT(CZ_ID) AS cID FROM view_general 
	 WHERE schoolid='$Digi'
	 AND $orSQL
	";
	$query = mysql_db_query($DBsite,$sql) or die(mysql_error());
	$row = mysql_fetch_array($query);
	$cID = $row['cID'];
	
	return $cID;
}

function count_school_total($Digi,$orSQL,$DBsite){
	 $sql ="SELECT COUNT(CZ_ID) AS cID FROM view_general 
	 WHERE siteid='$Digi'
	 AND $orSQL
	";
	$query = mysql_db_query($DBsite,$sql) or die(mysql_error());
	while ( $row = mysql_fetch_array($query) ){
	$cID = $cID+$row['cID'];
	}
	
	return $cID;
}

$smonth = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
# 2549-03-23  
 function  convertdatex($date001) {   // convert  form format   2004-11-25  (YYYY-MM-DD)

				global $smonth ; 
				$syear = substr ("$date001", 0,4); // ปี
				if ($syear < 2300 ){  $syear = $syear + 543 ;  }
				$smm = (int)(substr ("$date001", 5,2))  ; // เดือน
				$sday = (int)substr ("$date001", 8,2); // วัน
				$convert_date1 = "  $sday   ". $smonth[$smm] ." $syear  ";	
				if (($date001 =="") or ($date001 == 0))	{  $convert_date1 = "" ;  } 
				return $convert_date1 ;
} ## END function  convertdate($date1)

function retireDate($date){

	$d			= explode("-",$date);
	$year	= $d[0];
	$month	= $d[1];
	$date	= $d[2];

	if($month == 1 || $month == 2 || $month == 3){		
		$retire_year	= ($year < 2484) ? $year + 61 : $year + 60 ;		

	} else if($month == 10 || $month == 11 || $month == 12){		
		$retire_year 	= ($date <= 1 && $month == 10) ? $year + 60 :  $year + 61;		
	} else {
		$retire_year 	= $year + 60;
	}		

	return "30 กันยายน พ.ศ. ".$retire_year;
}


function find_query_birthday($year){
		
		$year1 = $year-61;
		$year2	= $year-60;
												
		$query_year = "(view_general.birthday like '".$year1."-10%' or view_general.birthday like '".$year1."-11%' or view_general.birthday like    '".$year1."-12%' or view_general.birthday like '".$year2."-%' ) and (view_general.birthday not like '".$year2 ."-10%' and view_general.birthday not like '".$year2."-11%' and view_general.birthday not like '".$year2."-12%' )";
		
		return $query_year;
}


$nyear = date('Y')+543;
$qr_birthday = find_query_birthday($nyear);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../application/hr3/libary/style.css" type="text/css" rel="stylesheet">
<title></title>
<script language="javascript">
function mOvr(src,clrOver){ 
    if (!src.contains(event.fromElement)) src.bgColor = clrOver; 
} 

function mOut(src,clrIn){ 
    if (!src.contains(event.toElement)) src.bgColor = clrIn; 
} 
</script>
<style type="text/css">
<!--
A:link {
    FONT-SIZE: 12px;color: #000000;
    FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
    FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
    FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
    FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<link href="../application/hr3/hr_report/libary/tab_style.css" rel="stylesheet" type="text/css">
<link href="pading.css" type="text/css" rel="stylesheet">   
<script type="text/javascript" src="../application/hr3/hr_report/libary/tabber.js"></script>
<script type="text/javascript">
//document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<script language=JavaScript> 

function CheckIsIE() 
{ 
if (navigator.appName.toUpperCase() == 'MICROSOFT INTERNET EXPLORER') { return true;} 
else { return false; } 
} 


function PrintThisPage() 
{ 

if (CheckIsIE() == true) 
{ 
parent.iframe1.focus(); 
parent.iframe1.print(); 
} 
else 
{ 
window.frames['iframe1'].focus(); 
window.frames['iframe1'].print(); 
} 

} 

 
</script>
</head>
<body>

<table width="95%" border="0" align="center">
  <tr>
    <td colspan="8" >
	<?
	// หา เขตพื้นที่
	$get = "SELECT * FROM area_part  ORDER BY partid ASC";
	$query = mysql_db_query($dbconnect,$get) or die(mysql_error());
	while( $area = mysql_fetch_array($query) ) {
			$ary_area[$area['partid']] = $area['area_part'];
	}
	
	// หาสายงาน
	$typeword = mysql_db_query($dbconnect,"SELECT * FROM hr_positiongroup WHERE status_active=1 ") or die(mysql_error());
	$numtype = mysql_num_rows($typeword);
	$numcolspan = $numtype*4;
	while ( $hrtype = mysql_fetch_array($typeword) ) {
			$ary_hr_positiongroup[] = $hrtype['positiongroupid'];
			$ary_hr_positiongroup_name[] = $hrtype['positiongroup'];
	}
	
	// หาจำนวนบุคลากรที่จะครบเกษียณอายุ แยกตามสายงานและหน่วยงาน
	if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup)){
		foreach( $ary_hr_positiongroup as $k => $v ) {	
				$or_query = find_positiongroup($v);
				$sql_count_have = "SELECT * FROM view_general WHERE ".$qr_birthday." AND ".$or_query;
				$qrydata_have = mysql_db_query($dbconnect,$sql_count_have) or die(mysql_error());
				while($rsdata_have = mysql_fetch_array($qrydata_have)){
						if($rsdata_have['schoolid'] != ''){
							$ary_view_general[$v][$rsdata_have['schoolid']] += 1; 
							$ary_view_general_school[$v][$rsdata_have['schoolid']][$rsdata_have['CZ_ID']] = trim($rsdata_have['position_now']); 
						}
						$ary_view_general_noschoolid[] = $rsdata_have['CZ_ID'];
				}
		}
	}
	
	// หาหน่วยงาน แยกตามเขตพื้นที่	
	$sql_partid = "SELECT
											allschool.id,
											eduarea.partid,
											eduarea.provid,
											eduarea.secid,
											eduarea.secname
											FROM
											eduarea
											Inner Join allschool ON eduarea.secid = allschool.siteid";
	$qrydata_partid = mysql_query($sql_partid) or die(mysql_error());
	while($rsdata_partid = mysql_fetch_array($qrydata_partid)){
			if($rsdata_partid['partid'] != ''){
					$ary_partid[$rsdata_partid['partid']][] = $rsdata_partid['id'];
			}
			/*if($rsdata_partid['provid'] != ''){
					$ary_provid[$rsdata_partid['provid']][] = $rsdata_partid['id'];
			}*/
	}
	
	//print_r($ary_provid); exit();
	
	if($type_level==""){
	?>
	<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
      <tr>
        <td width="36%" bgcolor="#A3B2CC" class="header"  ><strong>มีจำนวนบุคลากร (อัตราจริง)  ตามบัญชี จ.18 รวมทั้งสิ้น</strong>&nbsp;</td>
	<?
		if(count($ary_hr_positiongroup_name) > 0 && is_array($ary_hr_positiongroup_name)){
					foreach( $ary_hr_positiongroup_name as $sk => $sv ) {
	?>	
        <td bgcolor="#A3B2CC" class="header"  align="center"><?=$sv?></td>
	<?
					}
		}
	?>
        </tr>
      
<?
			// Loop เขตพื้นที่
			if(count($ary_area) > 0 && is_array($ary_area)){
				foreach( $ary_area as $a => $b ) {
?>      
	<tr>
        <td align="left" bgcolor="#F9F9F9"><strong> - <?=$b?></strong></td>
<?
							if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup)){
									foreach( $ary_hr_positiongroup as $k => $v ) {
													$xsum_og = 0;
													if(count($ary_partid[$a]) > 0 && is_array($ary_partid[$a])){
															foreach($ary_partid[$a] as $x => $y){
																		$xsum_og += $ary_view_general[$v][$y];
															}
													}
?>			
         <td bgcolor="#F9F9F9" class="header"  align="center"><?=number_format($xsum_og)?></td>
        <?
									} // End foreach( $ary_hr_positiongroup as $k => $v )
							} // End if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup))
?>		
        </tr>
<?
					} // End foreach( $ary_area as $a => $b )
				
				}//  End if(count($ary_area) > 0 && is_array($ary_area))
?>		
      
    </table>
	
<?
}else{
?>	
	
	<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
      <tr>
        <td width="36%" bgcolor="#A3B2CC" class="header"  ><b>มีจำนวนบุคลากร จะครบเกษียณอายุราชการ รวมทั้งสิ้น&nbsp;</b></td>
        <td  align="center" bgcolor="#A3B2CC" class="header"><b>จำนวนคน</b></td>

        </tr>
      
<?

		if($type_level=="1"){
		
				$getlist = mysql_query("SELECT * FROM eduarea WHERE provid='".$Pcode."'   ORDER BY secid   ASC") or die(mysql_error());
		
		}else if($type_level=="2"){
		
				$getlist = mysql_db_query($edubkk_master,"SELECT * FROM allschool WHERE siteid='".$Pcode."'") or die(mysql_error());
				
		}
		$list_schz = array();
		while ( $rcc = mysql_fetch_array($getlist) ) {
		
				if($type_level=="1"){
						$name = $rcc['secname'];
						$npcode =  $rcc['secid'];		
						$next_level= "2";
						
				}else if($type_level=="2"){
						$name = $rcc['office'];
						$npcode =  $rcc['id'];		
						$next_level= "3";
						
						
				}
				
				$sql_sch = "SELECT
										allschool.id
										FROM
										allschool 
										WHERE
										allschool.siteid =  '".$npcode."'
										";
				$qr_sch = mysql_query($sql_sch);
				while($rs_sch = mysql_fetch_array($qr_sch)){
						$list_schz[] = $rs_sch['id'];
				}
						
		}		
				
		
		if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup)){
			foreach( $ary_hr_positiongroup as $k => $v ) {
						$xsum_og = 0;
						
						if(count($list_schz) > 0 && is_array($list_schz)){
								foreach($list_schz as $x => $y){
											$xsum_og += $ary_view_general[$v][$y];
								}
						}
	?>      
	<tr>
        <td align="left" bgcolor="#F9F9F9"><strong> - <?=$ary_hr_positiongroup_name[$k]?></strong></td>
         <td  align="center" bgcolor="#F9F9F9" class="header"><b><?=number_format($xsum_og)?></b></td>
        </tr>
		<?
			} // End foreach( $ary_hr_positiongroup as $k => $v )
		} // End if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup))
		?>     
    </table>
	
<? 
}
?>
	</td>
  </tr>
  <tr>
    <td colspan="5" ><b><?
			if($type_level == ""){
					echo "ภาพรวมทั้งประเทศ";
			}else if($type_level == "1"){
					echo "ภาพรวมระดับจังหวัด";
			}else if($type_level == "2"){
					echo "ภาพรวมระดับเขต";
			}else  if($type_level == "3"){
					echo "ภาพรวมระดับหน่วยงาน";
			}
	?> </b> </td>
    <td colspan="3" align="right">&nbsp;รายงาน ณ วันที่
      <?=$nowdd?></td>
  </tr>
</table>
</td>
	   </tr>
	</table>
	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	
	
	<?
	if($type_level=="3"){
	
			$sql_list_vw = "SELECT
											view_general.birthday,
											view_general.prename_th,
											view_general.name_th,
											view_general.surname_th,
											view_general.position_now
											FROM
											view_general
											WHERE
											view_general.schoolid =  '".$stid."'
											AND ".$qr_birthday."
											";
			$qr_list_vw = mysql_db_query(STR_PREFIX_DB.$stid,$sql_list_vw);			
	?>
	
	<table border="0" width="95%" cellspacing="1" cellpadding="2" bgcolor="black" align="center" style="margin-top:5px; margin-bottom:5px;">
		<tr bgcolor="#A3B2CC" align="center" >
			<th width="10%"> ลำดับที่ </th>
			<th width="19%"> วันเดือนปีเกิด</th>
			<th width="27%"> ชื่อ-นามสกุล</th>
			<th width="26%">ตำแหน่งปัจจุบัน</th>
			<th width="18%">วันที่เกษียณอายุ</th>	 
		</tr>
		<?
		if(@mysql_num_rows($qr_list_vw) > 0){
				while($rs = mysql_fetch_assoc($qr_list_vw)){
				$i += 1;	
				$color 		= ($i%2 == 0) ? "#DDDDDD" : "#EFEFEF" ;
		?>
		<tr align="center" bgcolor="<?=$color?>">
			<td height="20"><?=$i?></td>	
			<td align="center">
			<?
			 $rs_birthday = convertdatex($rs[birthday]) ; 
			 echo  $rs_birthday;  
			?>
			</td>
			<td align="left">&nbsp;
			<?=$rs[prename_th]."".$rs[name_th]." ".$rs[surname_th];?>
			</td>
			<td align="left">&nbsp;<?=$rs[position_now]?></td>
		  	<td align="center">
			 <?
			 echo  retireDate($rs[birthday]);  
			 ?> </td>	 
		</tr>
		<? 	
				} 
		}
		mysql_free_result($result);
		?>	
		</table>
	
	<?
	}else{
	?>
	
	<table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
      <tr>
        <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="15%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>หน่วยงาน</strong></td>
        <td colspan="<?=$numcolspan?>" bgcolor="#A3B2CC"><div align="center"><strong>จำนวนข้าราชการครูและบุคลากรทางการศึกษา (คน)</strong></div></td>
      </tr>
      <tr>
        <?
	  	//while ( $htypelist = mysql_fetch_array($typeword) ) {
		if(count($ary_hr_positiongroup_name) > 0 && is_array($ary_hr_positiongroup_name)){
			foreach( $ary_hr_positiongroup_name as $k => $v ) {
	  ?>
        <td colspan="4" align="center" bgcolor="#A3B2CC"><strong>
        <?=$v?>
        </strong></td>
        <?
			}
	  }
	?>
      </tr>
      
	  <?
	  $sum_all_xsum_og = array();
	  
	    if($type_level==""){
	  
	  			$getlist = mysql_query("SELECT * FROM ccaa WHERE ccType='$ccType'  ORDER BY ccDigi  ASC") or die(mysql_error());
		
		}else if($type_level=="1"){
		
				$getlist = mysql_query("SELECT * FROM eduarea WHERE provid='".$Pcode."'   ORDER BY secid   ASC") or die(mysql_error());
		
		}else if($type_level=="2"){
		
				$getlist = mysql_db_query($edubkk_master,"SELECT * FROM allschool WHERE siteid='".$Pcode."'") or die(mysql_error());
				
		}
		
		$inum =0;
		while ( $rcc = mysql_fetch_array($getlist) ) {
		
				$xsum_og = 0;
				
				if($type_level==""){
						$name = $rcc['ccName'];
						$npcode =  $rcc['areaid'];
						$next_level= "1";
						
						$sql_sch = "SELECT
												allschool.id
												FROM
												eduarea
												Inner Join allschool ON allschool.siteid = eduarea.secid
												WHERE
												eduarea.provid =  '".$rcc['areaid']."'
												";
						$qr_sch = mysql_query($sql_sch);
						$ary_schz = array();
						while($rs_sch = mysql_fetch_array($qr_sch)){
								$ary_schz[] = $rs_sch['id'];
						}
						
				}else if($type_level=="1"){
						$name = $rcc['secname'];
						$npcode =  $rcc['secid'];		
						$next_level= "2";
						
						$sql_sch = "SELECT
												allschool.id
												FROM
												allschool 
												WHERE
												allschool.siteid =  '".$npcode."'
												";
						$qr_sch = mysql_query($sql_sch);
						$ary_schz = array();
						while($rs_sch = mysql_fetch_array($qr_sch)){
								$ary_schz[] = $rs_sch['id'];
						}
						
				}else if($type_level=="2"){
						$name = $rcc['office'];
						$npcode =  $rcc['id'];
						$stid =  $Pcode;	
						$next_level= "3";
						
						$sql_sch = "SELECT
												allschool.id
												FROM
												allschool 
												WHERE
												allschool.siteid =  '".$npcode."'
												";
						$qr_sch = mysql_query($sql_sch);
						$ary_schz = array();
						while($rs_sch = mysql_fetch_array($qr_sch)){
								$ary_schz[] = $rs_sch['id'];
						}
						
				}
				
				if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
		
				$inum++;
	  ?>
      <tr bgcolor="#<?=$bgcolor1?>">
        <td align="right"><?=$inum?></td>
        <td><a href="<?=$PHP_SELF?>?xsiteid=<?=$xsiteid?>&type_level=<?=$next_level?>&Pcode=<?=$npcode?>&stid=<?=$stid?>"><?=$name?></a></td>
        <?
				  if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup)){
					foreach( $ary_hr_positiongroup as $k => $v ) {
					
							 	$xsum_og = 0;
							 	
								if(count($ary_schz) > 0 && is_array($ary_schz)){
										foreach($ary_schz as $x => $y){
													$xsum_og += $ary_view_general[$v][$y];
										}
								}
							   
							   $sum_all_xsum_og[$v] +=  $xsum_og;
							  
							   if($xsum_og>0){ $show_xsum_og = "<b>".number_format($xsum_og)."</b>"; }else{ $show_xsum_og = 0;}
	   
	  ?>
        <td colspan="4" align="right"><?=$show_xsum_og?></td>
        <?
					} // End foreach( $ary_hr_positiongroup as $k => $v )
				} // End  if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup))
		?>
      </tr>
	  <?
	  } // End while ( $rcc = mysql_fetch_array($getlist) )
	  ?>
	   <tr bgcolor="#<?=$bgcolor1?>">
        <td colspan="2" align="right" bgcolor="#A3B2CC"><strong>รวม</strong></td>
        <?
	 if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup)){
					foreach( $ary_hr_positiongroup as $k => $v ) {
	 
	  ?>
        <td colspan="4" align="right" bgcolor="#A3B2CC"><b><?=number_format($sum_all_xsum_og[$v])?></b></td>
    <?
					} // End foreach( $ary_hr_positiongroup as $k => $v )
	  } // End  if(count($ary_hr_positiongroup) > 0 && is_array($ary_hr_positiongroup))
	?>
      </tr>
    </table>
	
	<?
	}
	?>
	
	<p>&nbsp;</p>
</body>
</html>
