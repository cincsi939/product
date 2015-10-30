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
			$dbnameuse = DB_USERENTRY;
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			$arr_dc = explode("-",$datecal);
			
		//$datereq1 = "2010-02-24";
	 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_dc[1]), intval($arr_dc[2]), intval($arr_dc[0]))));
	 $curent_w = $xFTime["wday"];
	 $xsdate = $curent_w -1;
	 $xedate = 6-$curent_w;
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 //echo " $datereq1  :: $xsdate  :: $xedate<br>";
				
				 $xbasedate = strtotime("$datecal");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป
				 
				 $xbasedate1 = strtotime("$datecal");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xedate = date("Y-m-d",$xdate1);// วันถัดไป
				 
				//echo "$xsdate  :: $xedate<br>";


	 
	 //echo "<pre>";
	 //print_r($xFTime);
	 
			
			if($sdate == ""){
					$sdate = date("d/m/").(date("Y")+543);
			}


			
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}


function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){


function ShowSubtract($get_date,$get_staffid){
		global $dbnameuse;
		$sqlS = "SELECT spoint FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		return $rsS[spoint];
}//end function ShowSubtract(){
	
	
function ShowPerson($get_idcard){
	global $dbnameuse;
	$sql = "SELECT * FROM  tbl_assign_key where idcard='$get_idcard' AND nonactive='0'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[fullname];
}

function XShowGroupQC($get_id){
		global $dbnameuse;
		$sql = "SELECT * FROM validate_datagroup WHERE checkdata_id='$get_id'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[dataname];
}
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" bgcolor="#a3b2cc"><strong>ประวัิติการเปลี่ยนกลุ่มการคีย์ข้อมูลของ 
          <?=ShowStaffOffice($xstaffid);?>
        </strong></td>
        </tr>
      <tr>
        <td width="8%" align="center" bgcolor="#a3b2cc"><strong>ลำดับ</strong></td>
        <td width="24%" align="center" bgcolor="#a3b2cc"><strong>กลุ่มการคีย์ข้อมูล</strong></td>
        <td width="25%" align="center" bgcolor="#a3b2cc"><strong>วันเริ่มต้น</strong></td>
        <td width="23%" align="center" bgcolor="#a3b2cc"><strong>วันที่สิ้นสุด</strong></td>
        <td width="20%" align="center" bgcolor="#a3b2cc"><strong>เวลาบันทึกข้อมูล</strong></td>
      </tr>
      <?
      	$sql_log = "SELECT keystaff_group.groupname, keystaff_log_group.end_date, keystaff_log_group.updatetime,
keystaff_log_group.start_date FROM keystaff_log_group Inner Join keystaff_group ON keystaff_log_group.keyin_group = keystaff_group.groupkey_id WHERE keystaff_log_group.staffid = '$xstaffid' ORDER BY keystaff_log_group.start_date DESC";
		$result_log = mysql_db_query($dbnameuse,$sql_log);
		$n=0;
		while($rsl = mysql_fetch_assoc($result_log)){
		if ($n++ %  2){
			$bgcolor = "#F0F0F0";
		}else{
			$bgcolor = "#FFFFFF";
		}
	  ?>
      <tr bgcolor="<?=$bgcolor?>">
        <td align="center"><?=$n?></td>
        <td align="center"><?=$rsl[groupname]?></td>
        <td align="center"><?=DBThaiLongDate($rsl[start_date]);?></td>
        <td align="center"><? if(DBThaiLongDate($rsl[end_date]) == ""){ echo DBThaiLongDate(date("Y-m-d"));}else{ echo DBThaiLongDate($rsl[end_date]); }?></td>
        <td align="center"><?=ShowThaiDateTime($rsl[updatetime]);?></td>
      </tr>
      <?
		}//end while($rsl = mysql_fetch_assoc($result_log)){
	  ?>
    </table></td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>