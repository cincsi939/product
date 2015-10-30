<?
include("epm.inc.php"); // 

$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";

	$host = HOST;
			$user = "cmss";
			$pass = "2010cmss";


function GetStaffFace(){
	global $dbface,$host_face,$user_face,$pass_face;
	ConHost($host_face,$user_face,$pass_face); // connect faceaccess
	$sql = "SELECT distinct t1.pin,t1.prename,t1.firstname,t1.surname,t2.time_start FROM faceacc_officer as t1 inner join faceacc_officer_to_status as t2 ON t1.officer_id=t2.officer_id  WHERE t1.status_id <> '1'
	order by time_start DESC
	";
	//echo $sql."";
	$result = mysql_db_query($dbface,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[pin]] = "$rs[time_start]||$rs[prename]$rs[firstname] $rs[surname]";
	}// end 	while($rs = mysql_fetch_assoc($result)){
		return $arr;

}//end function GetStaffFace(){
	
	##### ประมวลผลเพื่อปรับสถานคนออกในระบบ userentry
	$arr1 = GetStaffFace(); // รายชื่อพนักงานในระบบ face ที่ออกแล้ว
	ConHost($host,$user,$pass); // connect cmss server
	if(count($arr1) > 0){
		$i=0;
		foreach($arr1 as $key => $val){
				$sql1 = "SELECT * FROM keystaff  WHERE card_id='$key' AND status_permit='YES' ";
				echo $sql1."<br>";
				$result1 = mysql_db_query($dbnameuse,$sql1);
				$rs1 = mysql_fetch_assoc($result1);
				
				$arrp = explode("||",$val);
				if($rs1[staffid] != ""){
					$i++;
						$sql2 = "UPDATE keystaff SET status_permit='NO',retire_date='$arrp[0]' WHERE  staffid='$rs1[staffid]'";
						mysql_db_query($dbnameuse,$sql2);
						echo "$i :: $sql2<br>";
				}else{
						echo $key." :: ".$arrp[1]."<br>";
				}
		}//end foreach($arr1 as $key => $val){
	}//end if(count($arr1) > 0){
		

?>