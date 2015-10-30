<?
include ("../../config/conndb_nonsession.inc.php")  ;


//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epm.inc.php");
include("../../common/class.time_query.php");			
$mytime_query->ApplicationName="crontab";

	################  funciton แบ่งกลุ่มการ QC
	function XSubGroupQC($get_staffid){
		global $dbnameuse;
		$kvalgroup  = ShowQvalue($get_staffid); // จำนวนชุดที่ต้อง QC
		$str1 = "SELECT MAX(flag_qc) AS max_flag FROM stat_user_keyperson WHERE staffid='$get_staffid'";
		echo $str1."<br>";
		$result1 = mysql_db_query($dbnameuse,$str1);
		$rs1 = mysql_fetch_assoc($result1);
		
		### ตรวจสอบว่าจำนวนรายการที่คีย์ใหม่ครบจำนวนที่จะ QC รึยัง
		if($rs1[max_flag] > 0){
			$sqlc1 = "SELECT COUNT(staffid) AS num2 FROM stat_user_keyperson WHERE staffid='$get_staffid' AND flag_qc='$rs1[max_flag]'";
			$resultc1 = mysql_db_query($dbnameuse,$sqlc1);
			$rsc1 = mysql_fetch_assoc($resultc1);
			$numcheck = $rsc1[num2]; // นับจำนวนรายการสุดท้ายหลังจากแบ่งชุด
		}//end 	if($rs1[max_flag] > 0){
			//echo $rs1[max_flag]." :: $numcheck<br>";die;
			if(($kvalgroup > $numcheck) and ($rs1[max_flag] > 0)){ // กรณีชุดสุดท้ายไม่ครบตามจำนวนที่คีย์
					$maxid = $rs1[max_flag];
					$j=$numcheck;
			}else{
					$maxid = $rs1[max_flag]+1;// กรณี
					$j=0;
			}
		
		
		$sql_count = "SELECT COUNT(idcard) AS num1  FROM stat_user_keyperson WHERE status_approve='1' AND staffid='$get_staffid' AND flag_qc='0'  GROUP BY staffid";
		//echo $sql_count."<br>";
		$result_count = mysql_db_query($dbnameuse,$sql_count);
		$rs_count = mysql_fetch_assoc($result_count);
		$numr = $rs_count[num1];
		
		$sql = "SELECT * FROM stat_user_keyperson WHERE status_approve='1' AND staffid='$get_staffid' AND flag_qc='0'  ORDER BY datekeyin ASC";
		/// AND status_random_qc='0'
		$result = mysql_db_query($dbnameuse,$sql);
		//$numr = @mysql_num_rows($result);
		$loop_save = floor($numr/$kvalgroup); // จำนวนครั้งที่ต้อง qc
	//	echo "<br>".$loop_save."<br>$sql<br>";
		//echo "<br>".$loop_save."<br>$sql<br>";die;
	//if($loop_save > 0){
			//$j=0;
			$loop1 = 0;
			while($rs = mysql_fetch_assoc($result)){
				####  ตรวจสอบกรณีมีเลขบัตรซ้ำ
				$sql_flag_qc = "SELECT COUNT(idcard) as numid FROM stat_user_keyperson WHERE idcard='$rs[idcard]'";
				$result_flag_qc = mysql_db_query($dbnameuse,$sql_flag_qc);
				$rs_qc = mysql_fetch_assoc($result_flag_qc);
				$num_idcard = $rs_qc[numid];
				#### end ตรวจสอบเลขบัตรซ้ำไม่นำมาคำนวณ
				if($num_idcard == 1){ // กำหนดจุด Qc เฉพาะ ที่มีเลขบัตรไม่ซ้ำเท่านั้น
				$j++;
				$sql_up = "UPDATE stat_user_keyperson SET flag_qc='$maxid' WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]' AND idcard='$rs[idcard]'";
				//echo "$sql_up<br>";
				mysql_db_query($dbnameuse,$sql_up);
				if($j == $kvalgroup){ // กรณีแบ่งกลุ่มครบจำนวนที่ต้อง qc
					$sql_insert = "REPLACE INTO stat_user_person_temp(flag_id,staffid,dateqc)VALUES('$maxid','$get_staffid','$rs[datekeyin]')";
					//echo " ครบ loop : $sql_insert<br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
					$maxid++;
					$j=0;
					$loop1++;
				}//end if($j == $kvalgroup){
				if($loop1 == $loop_save){ 
					$sql_insert = "REPLACE INTO stat_user_person_temp(flag_id,staffid,dateqc)VALUES('$maxid','$get_staffid','$rs[datekeyin]')";
					//echo "$sql_insert <br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				}
					
				}//end if($num_idcard == 1){
			}//end while($rs = mysql_fetch_assoc($result)){
		//}//end if($loop_save > 0){
	}//end function SubGroupQC(){
		



$sql_p = "SELECT keystaff.staffid, keystaff.prename, keystaff.staffname, keystaff.staffsurname, keystaff.sapphireoffice,
keystaff.keyin_group
FROM keystaff
WHERE
keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' AND
keystaff.keyin_group >  '0'";
$result_p = mysql_db_query($dbnameuse,$sql_p);
while($rsp = mysql_fetch_assoc($result_p)){
	//echo "sad";die;
		XSubGroupQC($rsp[staffid]);
}


?>