<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalScore";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::29/07/2011
#LastUpdate::29/07/2011
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
//die;
			set_time_limit(0);
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			$percenadd = 5;
			$date_s = "2011-07-01";
			$date_e = "2011-07-25";
			
			$date1 = "2011-06-27";
			
			$date2 = "2011-07-25";
			
			$time_start = getmicrotime();

			
	
			
			
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
	
function GetKDate(){
	global $dbnameuse,$date_s,$date_e;
	$sql = "SELECT * FROM kvalue_keyin  where datekey between '$date_s' and '$date_e'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[datekey]] = $rs[kval];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}	

$sql = "SELECT
t1.datekeyin,
t1.staffid,
t1.numkpoint,
t2.spoint,
t2.point_ratio,
t1.rpoint,
if(t1.rpoint > 0 AND t1.rpoint Is Not Null,t2.spoint * t1.rpoint,if(t2.point_ratio > 0 AND t2.point_ratio Is Not Null,t2.spoint * t2.point_ratio,t2.spoint * 1)) AS subpoint
FROM
stat_user_keyin AS t1
Inner Join keystaff as t ON t1.staffid = t.staffid
Left Join stat_subtract_keyin AS t2 ON t1.datekeyin = t2.datekey AND t1.staffid = t2.staffid

where t1.datekeyin between '$date1' and '$date2' and t.site_id IN('6','69','71')
group by t1.datekeyin,
t1.staffid
order by t1.datekeyin,t1.staffid ASC";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
$arrkdate = GetKDate();
while($rs = mysql_fetch_assoc($result)){
	$k5percen = (($rs[numkpoint]*$percenadd)/100);
	$kpoint_add5p = $rs[numkpoint]+(($rs[numkpoint]*$percenadd)/100);
	$k_date = $arrkdate[$rs[datekeyin]];
	if($k_date > 0){
		$v_k_date = (($kpoint_add5p*$k_date)/100);
		$netkpoint = $kpoint_add5p+$v_k_date;
	}else{
		$k_date = 0;
		$v_k_date = 0;
		$netkpoint = $kpoint_add5p;
			
	}
	
	$kpoint_end = $netkpoint-$rs[subpoint];
	
	$sqlr = "REPLACE INTO stat_addkpoint_report SET staffid='$rs[staffid]',datekeyin='$rs[datekeyin]',numkpoint='$rs[numkpoint]',k5percen='$k5percen',kpoint_add5p='$kpoint_add5p',k_date='$k_date',v_k_date='$v_k_date',netkpoint='$netkpoint',subtarct_val='$rs[subpoint]',kpoint_end='$kpoint_end'";
	mysql_db_query($dbnameuse,$sqlr) or die(mysql_error()."$sqlr<br>LINE__".__LINE__);
		
}





##  end เขียนข้อมูลใส่ใน ranking 
$time_end = getmicrotime();
echo "เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";
 writetime2db($time_start,$time_end);




echo "<script>alert('ประมวลผลข้อมูลเรียบร้อยแล้ว');  window.opener.location.reload();window.close(); </script>";
 ?>