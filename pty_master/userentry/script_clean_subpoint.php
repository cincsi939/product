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
			include("function_incentive.php");
			$flag_process = 0;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			
			if($sdate == ""){
					$sdate = "01/".(date("m/")).(date("Y")+543);
			}

         




		if($sdate == "16/08/2553"){
				$base_point = 381;
		}else if($sdate == "17/08/2553"){
				$base_point = 353;
		}else if($sdate == "18/08/2553"){
				$base_point = 381;
		}else{
				$base_point = $base_point;
		}
		
		//echo $base_point;
	
			
			
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
		$kgroup = GetKeyinGroupDate($get_staffid,$get_date);
		$ratio_point = intval(CheckGroupKeyRatio($staffid,$datekeyin)); //  ค่าถ่วงน้ำหนักการ QC ของแต่ละกลุ่ม 
		 
		$sqlS = "SELECT spoint,point_ratio  FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		if($rsS[point_ratio] > 0){
			$rpoint = $rsS[point_ratio];	
		}else{
			$rpoint = $ratio_point;
		}
		return ($rsS[spoint]*$rpoint);
}//end function ShowSubtract(){
	
	function ShowSubtractAvg($get_date,$get_staffid){
		global $dbnameuse;
		
		$kgroup = GetKeyinGroupDate($get_staffid,$get_date);
		$ratio_point = intval(CheckGroupKeyRatio($get_staffid,$get_date));// ค่าถ่วงน้ำหนัก การ QC
		if($ratio_point < 1){
			$ratio_point = intval(ShowQvalue($get_staffid));	
		}//end 
		$sqlS = "SELECT spoint,point_ratio  FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		####  
		if($rsS[point_ratio] > 0){
			$rpoint = $rsS[point_ratio];	
		}else{
			$rpoint = $ratio_point;
		}
		
		return ($rsS[spoint]*$rpoint);

}//end function ShowSubtract(){

/*	
function ShowSubtractBdate($get_staffid,$get_date){
	global $dbnameuse;
	$sql1 = "SELECT sum(spoint) AS subtarct FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND sdate <= '$get_date' AND edate >= '$get_date'";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[subtarct];
		
}//end function ShowSubtractBdate($get_staffid,$get_date){
*/	

##  ฟังก์ชั่นตรวจสอบค่าคะแนนลบภายในช่วงสัปดาห์
function CheckSubtractUpdate($get_staffid,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // หาวันเริ่มต้นและสิ้นสุดของแต่ละสัปดาห์
	$sql2 = "SELECT
sum(stat_incentive.subtract) as subtract_max
FROM `stat_incentive`
WHERE
stat_incentive.staffid =  '$get_staffid' AND
stat_incentive.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."'";
	$result2 = mysql_db_query($dbnameuse,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
	return $rs2[subtract_max];
}	
### function update ค่าภายในช่วงสัปดาห์กรณีค่าลบใหม่มีค่ามากกว่าค่าลบเก่าให้เอาค่าลบเก่าไป update รายการข้อมูล
function ShowNumkeyPoint($get_staff,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // หาวันเริ่มต้นและสิ้นสุดของแต่ละสัปดาห์
	$sql_k = "SELECT
stat_user_keyin.numkpoint AS kpoint,
datekeyin
FROM `stat_user_keyin`
WHERE
stat_user_keyin.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."' AND
stat_user_keyin.staffid =  '$get_staff'";
	$result_k = mysql_db_query($dbnameuse,$sql_k);
	while($rs_k = mysql_fetch_assoc($result_k)){
		$arrk[$rs_k[datekeyin]] = $rs_k[kpoint];
	}//end while($rs_k = mysql_fetch_assoc($result_k)){
	return $arrk;
}//end function ShowNumkeyPoint($get_staff,$get_date){

function UpdateSubtractVal($get_staffid,$get_date,$get_val){
	global $dbnameuse,$base_point,$point_w;
	$arr_kpoint = ShowNumkeyPoint($get_staffid,$get_date);
	if(count($arr_kpoint) > 0){
		foreach($arr_kpoint as $key => $val){
			$npoint = ($val-$get_val)-$base_point;
			$kincentive = $npoint*$point_w;
			
			$sql_up = "UPDATE stat_incentive SET subtract='$get_val', net_point='$npoint', incentive='$kincentive' WHERE staffid='$get_staffid' and datekeyin='$key'";
			mysql_db_query($dbnameuse,$sql_up);	
		}//end foreach($arr_kpoint as $key => $val){	
	}//end if(count($arr_kpoint) > 0){	
}//end function UpdateSubtractVal(){ 
	  						//echo "<input type='hidden' name='arr_datekeyin[$rsv[staffid]]' value='$rsv[datekeyin]'>";
							//echo "<input type='hidden' name='arr_subtract[$rsv[staffid]]' value='$subtract_val'>";
							//echo "<input type='hidden' name='arr_net_point[$rsv[staffid]]' value='$net_kpoint'>";
							//echo "<input type='hidden' name='arr_incentive[$rsv[staffid]]' value='$Incentive_val'>";
							

	
			$sql = "SELECT staffid,datekey FROM temp_clean_point_sub WHERE  status_active='0' ORDER BY staffid ASC , datekey ASC";			
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$dbnameuse<br><BR>$sql<br>LINE__".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
					//$sql_update = "UPDATE validate_checkdata SET status_cal='1',datecal=qc_date WHERE qc_date='$rs[datekey]' and staffid='$rs[staffid]' ";
					$sql_del1 = "DELETE FROM validate_checkdata WHERE qc_date='$rs[datekey]' and staffid='$rs[staffid]' ";
					mysql_db_query($dbnameuse,$sql_del1) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
					
					$sql_del = "UPDATE stat_subtract_keyin SET spoint='0' WHERE staffid='$rs[staffid]' and datekey='$rs[datekey]'";
					mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
					
					$sql_up1 = "UPDATE temp_clean_point_sub SET status_active='1' WHERE staffid='$rs[staffid]' AND datekey='$rs[datekey]'  ";
					mysql_db_query($dbnameuse,$sql_up1) or die(mysql_error()."$sql_up1<br>LINE__".__LINE__);
			}//end while($rs = mysql_fetch_assoc($result)){
			
			
	$xdatekey = "2011-10-01";
	$yymm = substr($xdatekey,0,7);
	$sql1 = "SELECT staffid,datekey FROM temp_clean_point_sub WHERE  datekey LIKE '$yymm%' GROUP BY staffid ";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		
		SumPointKeyPerPerson($rs1[staffid],$yymm); // คำนวนค่าคะแนนใหม่
		ProcessSubtractByPerson($xdatekey,$rs1[staffid],""); // $typestaff == "" ประเภทพนักงานคือ fulltime หรือ pattime
		
	}//end while($rs1 = mysql_fetch_assoc($result1)){

?>


<?
	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
