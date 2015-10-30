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
			$arr_dc = explode("-",$datecal);
			
		$datereq1 = "2010-02-24";
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานรายการจุดผิดจากการ QC</td>
        </tr>
		   <tr>
          <td class="headerTB">หมายเหตุ กรณีเป็นกลุ่มพนักงานคีย์ กลุ่ม A และ กลุ่ม B ถ้ามีคะแนนลบจะทำการคูณ 3 ชุด </td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td><form name="form2" method="post" action="">
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr>
		                   <td colspan="6" align="left" bgcolor="#A5B2CE"><strong>รายการจุดผิดของ <?=$xstaffname?> วันที่คีย์  <? echo DBThaiLongDate($datecal);?></strong></td>
		                   </tr>

		                 <tr>
		                   <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
		                   <td width="15%" align="center" bgcolor="#A5B2CE"><strong>รหัสใบงาน</strong></td>
		                   <td width="29%" align="center" bgcolor="#A5B2CE"><strong>ข้อมูลของ(ครู)</strong></td>
		                   <td width="21%" align="center" bgcolor="#A5B2CE"><strong>รายการที่ผิด</strong></td>
		                   <td width="18%" align="center" bgcolor="#A5B2CE"><strong>ประเภทรายการที่ผิด</strong></td>
		                   <td width="13%" align="center" bgcolor="#A5B2CE"><strong>คะแนนที่หัก</strong></td>
		                   </tr>
                            <?
		$group_type = CheckGroupKey($staffid);
		if($group_type > 0){ // กรณีเป็น กลุ่ม A หรือ B
				$conw = " AND
(validate_checkdata.datecal BETWEEN  '$xsdate' AND '$xedate') ";
		}else{
				$conw = " AND validate_checkdata.datecal =  '$datecal' ";
		}//end if($group_type > 0){
	### หารายการที่มีการคำนวณค่าจุดผิดสูงสุด
	$sql2 = "SELECT 
sum(if(validate_mistaken.mistaken_id='2',1,0.5)) as subtract_val,
 validate_checkdata.idcard
FROM validate_checkdata Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id 
Inner Join validate_mistaken ON validate_datagroup.mistaken_id = validate_mistaken.mistaken_id WHERE validate_checkdata.staffid LIKE '%$staffid%' 
AND validate_checkdata.result_check = '0' $conw
group by validate_checkdata.idcard
 ORDER BY subtract_val DESC
LIMIT 1";
	$result2 = mysql_db_query($dbnameuse,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
	
			
                           	$sql = "SELECT
validate_checkdata.ticketid,
validate_mistaken.mistaken,
if(validate_mistaken.mistaken_id='2',1,0.5) as subtract_val,
validate_checkdata.idcard,
validate_datagroup.dataname
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
Inner Join validate_mistaken ON validate_datagroup.mistaken_id = validate_mistaken.mistaken_id
WHERE
validate_checkdata.staffid LIKE  '%$staffid%'  AND 
validate_checkdata.result_check =  '0' AND validate_checkdata.idcard='$rs2[idcard]' ";
//echo $sql."<br>";
## validate_checkdata.datecal =  '$datecal' AND  "$xsdate  :: $xedate<br>";
$result = mysql_db_query($dbnameuse,$sql);

$i=0;
while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
						   ?>                      
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><?=$rs[ticketid]?></td>
		                   <td align="left"><? echo "$rs[idcard] [".ShowPerson($rs[idcard])."]";?></td>
		                   <td align="left"><? echo "$rs[dataname]";?></td>
		                   <td align="left"><? echo "$rs[mistaken]";?></td>
		                   <td align="center"><? echo "$rs[subtract_val] ";?></td>
		                   </tr>
                          <?
						  	$subtract_sum1 += $rs[subtract_val];
						}
						
			
						if($group_type > 0){ // กรณีเป็นกลุ่ม A และ กลุ่ม B ถ้ามีคะแนน * 3 ชุด
							$net_totalsubtract = $subtract_sum1*3;
							$txt_comment = "คะแนนรวม $subtract_sum1 x  3 : ";
						}else{
							$net_totalsubtract = $subtract_sum1;
							$txt_comment = "รวม : ";
						}
						  ?>
		                 <tr>
		                   <td colspan="5" align="right" bgcolor="#FFFFFF"><strong> <? echo $txt_comment; ?> </strong></td>
		                   <td align="center" bgcolor="#FFFFFF"><strong><?=$net_totalsubtract;?></strong></td>
		                   </tr>

	                    </table></td>
	                  </tr>
	                </table>
	             </form></td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>