<?
require_once("../../config/conndb_nonsession.inc.php");
$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";
$dbnameuse = DB_USERENTRY;
define("HOST", HOST);
define("USERNAME_HOST","cmss");
define("PASSWORD_HOST","2010cmss");

function ConHost($host,$user,$pass){
	  $myconnect = mysql_connect($host,$user,$pass) OR DIE("Unable to connect to database :: $host ");
	  $iresult = mysql_query("SET character_set_results=tis-620");
	  $iresult = mysql_query("SET NAMES TIS620");
	  return $myconnect;
}


$point_basekey = "20"; // จำนวนจุดมาตรฐานในการคีย์ต่อ 1 ชั่วโมง
######  ฟังชั่นในกาตรวจสอบการทำงานของเด็กคีย์ข้อมูลการ approve เวลาการทำงาน
#$pin  คือ เลขบัตรประชุาชนของพนักงานคีย์ข้อมูล
#$type = 1 คือ ช่วงเช้าเข้าออก  2 คือ ช่วงบ่ายเข้าออก
#$period_time = F คือ Fulltime   $period_time = P คือ Parttime
function CheckStaffApproveFace($pin,$type="",$period_time="F"){
	global $dbnameuse,$point_basekey;
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
	
	$condate = date("Y-m-d");
	$condate = "2011-06-02";
	
	if($period_time == "F"){
		$conv = " AND t1.period_time='am'";
		if($type == "1"){ // ช่วงเช้า
			//$conv1  = " and ((time(t2.timeupdate) between '09:00:00' and '10:00:00') or (time(t2.timestamp_key) between '09:00:00' and '10:00:00'))";
			//$conv2 = " and ((time(t2.timeupdate) between '11:00:00' and '12:00:00') or (time(t2.timestamp_key) between '11:00:00' and '12:00:00'))";
			$con_log1 = " AND time(logtime) between '09:00:00' AND '10:30:00' ";
			$con_log2 = " AND time(logtime) between '10:30:00' AND '12:00:00' ";	
			
		}else if($type == "2"){
			//$conv1  = " and ((time(t2.timeupdate) between '13:00:00' and '14:00:00') or (time(t2.timestamp_key) between '13:00:00' and '14:00:00'))";
			//$conv2 = " and ((time(t2.timeupdate) between '16:30:00' and '17:30:00') or (time(t2.timestamp_key) between '16:30:00' and '17:30:00'))";
			$con_log1 = " AND time(logtime) between '13:00:00' AND '14:30:00' ";
			$con_log2 = " AND time(logtime) between '16:00:00' AND '17:30:00' ";
			
		}// 	if($period_time == "1"){ 
	}else if($period_time == "P"){
				$conv = " AND t1.period_time='pm'";
				$con_log1 = " AND time(logtime) between '18:00:00' AND '19:30:00' ";	
				$con_log2 = " AND time(logtime) between '20:30:00' AND '22:00:00' ";		
	}// end 	if($period_time == "F"){
	
		$sql = "SELECT
		t2.siteid,
		t2.idcard
		FROM
		keystaff as t1
		Inner Join monitor_keyin as t2  ON t1.staffid = t2.staffid
		WHERE t1.card_id='$pin'  and t1.sapphireoffice='0' and t1.status_permit='YES' 
		and (t2.timeupdate LIKE '".$condate."%' or t2.timestamp_key LIKE '".$condate."%') ";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$numkey1 = 0;
		$numkey2 = 0;
		while($rs = mysql_fetch_assoc($result)){
			
			$db_site = STR_PREFIX_DB.$rs[siteid];
				$sql_log = "SELECT count(username) as num1 FROM `log_update` WHERE username='$rs[idcard]' AND logtime LIKE '".$condate."%' 
				$con_log1  	GROUP BY username";
				//echo $sql_log."<br>";
				$result_log = mysql_db_query($db_site,$sql_log) or die(mysql_error()."$sql_log<br>LINE::".__LINE__);
				$rsl = mysql_fetch_assoc($result_log);
				$numkey1 += $rsl[num1];	
				//echo $rs[idcard]." :: ".$rsl[num1]."<br>";

					$sql_log1 = "SELECT count(username) as num1 FROM `log_update` WHERE username='$rs[idcard]' AND logtime LIKE '".$condate."%' 
					$con_log2  	GROUP BY username";
					//echo "$sql_log1<br>";
					$result_log1 = mysql_db_query($db_site,$sql_log1) or die(mysql_error()."$sql_log<br>LINE::".__LINE__);
					$rsl1 = mysql_fetch_assoc($result_log1);
					$numkey2 += $rsl1[num1];			

		}// end while($rs = mysql_fetch_assoc($result)){		
	
	
		//echo "$numkey1 :: $numkey2";
		###  Face เข้า
		if($numkey1 >= $point_basekey){
				$arr[0] = "Y";
		}else{
				$arr[0]	 = "N";
		}//	if($numkey1 >= $point_basekey){
		### Face ออก

			if($numkey2 >= $point_basekey){
					$arr[1] = "Y";
			}else{
					$arr[1] = "N";	
			}//end if($numkey2 >= $point_basekey){

	
	
	return $arr;	
}//end function CheckStaffApproveFace($pin,$period_time){


########  ตัวอย่างการใช้ function # 
$pin = "1509900071267"; // เลขบัตรประชาชนพนักงานคีย์
$type = "1";
$period_time = "P";// F คือ fulltime  P คือ parttime

$arr = CheckStaffApproveFace("$pin",$type,$period_time);
echo "<pre>";
print_r($arr);

?>

