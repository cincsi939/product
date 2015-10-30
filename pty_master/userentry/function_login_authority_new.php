<?php
### ตรวจสอบวันหยุด
function GetHoliday($staffid){
	global $dbnameuse;
	$sql = "SELECT
count(t6.date_holiday) as num
FROM
authority_profile AS t1
Inner Join authority_login AS t2 ON t1.profile_id = t2.profile_id
Inner Join authority_math_profile AS t3 ON t2.profile_id = t3.profile_id
Inner Join authority_group_holiday AS t4 ON t4.group_id = t2.group_id
Inner Join authority_math_group_holiday AS t5 ON t5.group_id = t4.group_id
Inner Join authority_holiday AS t6 ON t5.holiday_id = t6.holiday_id
where t1.profile_active='1' and t3.staffid='$staffid' and t6.date_holiday='".date("Y-m-d")."'
group by t6.date_holiday";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs['num'];
}

function GetLabelHoliday($staffid){
	global $dbnameuse;
	$sql = "SELECT
t6.date_holiday,
t6.label_holiday
FROM
authority_profile AS t1
Inner Join authority_login AS t2 ON t1.profile_id = t2.profile_id
Inner Join authority_math_profile AS t3 ON t2.profile_id = t3.profile_id
Inner Join authority_group_holiday AS t4 ON t4.group_id = t2.group_id
Inner Join authority_math_group_holiday AS t5 ON t5.group_id = t4.group_id
Inner Join authority_holiday AS t6 ON t5.holiday_id = t6.holiday_id
where t1.profile_active='1' and t3.staffid='$staffid' and year(t6.date_holiday)='".date("Y")."' and t6.date_holiday >= '".date("Y-m-d")."' 
group by t6.date_holiday";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs['date_holiday']] = $rs['label_holiday'];
	}
	return $arr;
}
## ตรวจสอบวันที่สามารถ login เข้าสู่ระบบได้
function GetDayLogin($staffid,$dayid){
	global $dbnameuse;
	$sql = "SELECT
count(t1.day_id) as num
FROM
authority_login AS t1
Inner Join authority_day AS t2 ON t1.day_id = t2.day_id
Inner Join authority_math_profile AS t3 ON t3.profile_id = t1.profile_id
Inner Join authority_profile AS t4 ON t3.profile_id = t4.profile_id
Inner Join authority_time AS t5 ON t1.time_id = t5.time_id
WHERE
t4.profile_active =  '1' AND
t3.staffid =  '$staffid' and t1.day_id='$dayid' and t5.start_time <= '".date("H:i:s")."' and t5.end_time >= '".date("H:i:s")."'
group by t1.day_id";
#echo $sql."<hr>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs['num'];
}

## ตรวจสอบกลุ่มพนักงานที่ถูกกำหนดสิทธิการเข้าใช้งานระบบ
function CheckGroupLogin($staffid){
	global $dbnameuse;
	$sql = "SELECT
t1.day_id,
t2.day_label,
t5.start_time,
t5.end_time
FROM
authority_login AS t1
Inner Join authority_day AS t2 ON t1.day_id = t2.day_id
Inner Join authority_math_profile AS t3 ON t3.profile_id = t1.profile_id
Inner Join authority_profile AS t4 ON t3.profile_id = t4.profile_id
Inner Join authority_time AS t5 ON t1.time_id = t5.time_id
WHERE
t4.profile_active =  '1' AND
t3.staffid =  '$staffid' 

#group by t1.day_id

ORDER BY
t1.day_id ASC";
	#echo $sql."<hr>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs['day_id']]['dd'] = $rs['day_label'];
		$arr[$rs['day_id']]['time_start'] = $rs['start_time'];
		$arr[$rs['day_id']]['time_end'] = $rs['end_time'];
	}
	return $arr;
}

## ตรวจสอบสิทธิการเข้าสู่ระบบ
function CheckAuthorityLogin($staffid,$idcard,$day_id){
	$arr_authority = CheckGroupLogin($staffid); ##  หาวันและเวลาในการเข้าใช้งานระบบ
	#echo "<pre>";
	#print_r($arr_authority);
	$num_authority = count($arr_authority); ## นับว่าเป็นกลุ่มที่อยู่ในการจัดสิทธิการเข้าใช้งานระบบหรือไม่
	#echo "xxx => $num_authority";die();
	if($num_authority > 0){ # กรณีอยู่ในกลุ่มการจัดสิทธิการเข้าใช้งานระบบ
		$num_holiday = intval(GetHoliday($staffid)); ## ตรวจสอบว่าเป็นวันหยุด
		#echo "จำนวนวันหยุด : ".$num_holiday."";die();
		if($num_holiday < 1){ ## กรณีไม่ใช่วันหยุด
			$ip_login = substr(GET_IPADDRESS(),0,-3); ## เครื่องที่ใช้ในการ login
			$ip_face = substr(GetipFaceIn($idcard),0,-3); ## เครื่องที่ face หน้าเข้างาน
			$num_login = intval(GetDayLogin($staffid,$day_id));
			#echo "$ip_login :: $ip_face <hr>";
			#echo "การ login : ".$num_login;die();
			
			if($num_login < 1){ # กรณีไม่สามารถเข้าสู่ระบบได้
				#if($ip_login == $ip_face){ ## กรณี  ip เครื่องที่ face หน้าเข้างานเป็นเครื่องเดียวกัน
					$arr_holiday_label = GetLabelHoliday($staffid);
					foreach($arr_authority as $key => $val){
						
						$msg_alert .=$val['dd']." เวลา ".$val['time_start']."  ถึง ".$val['time_end'] ."||";	
					}
					if(count($arr_holiday_label) > 0){ ## ตรวจสอบวันหยุดที่สามารถเข้าสู่ระบบได้
						foreach($arr_holiday_label as $k => $v){
							if($msg_alert1 > 0) $msg_alert1 .= "||";
							$msg_alert1 .= DBThaiLongDateFull($k)." ". $v;
						}
					}
					if($msg_alert1 != ""){ $txt_msg = "|| และวันหยุดราชการดังนี้ ||".$msg_alert1;}else{ $txt_msg = "";}
					
				$arr_result[0]='0';
				$arr_result[1]= "คุณสามารถเข้าระบบได้ในวันและเวลาดังนี้  ||".$msg_alert.$txt_msg;
			/*	}else{ # กรณีเครืองที่ face หน้ากับเครื่องที่ login เป็นคนละเครื่องกัน
					$arr_result[0]='1';
					$arr_result[1]= "";
				}*/
			}else{ # กรณีวันและเวลาที่ login ตรงกับสิทธิที่ได้รับและสามารถ login เข้าสู่ระบบได้
				$arr_result[0]='1';
				$arr_result[1]= "";
			}
		

}else{ # กรณีเป็นวันหยุดราชการ
			$arr_result[0]='1';
			$arr_result[1]='';
		}	
	}else{ ## หากไม่อยู่ในกลุ่มการจัดสิทธิการเข้าใช้งานระบบ
		$arr_result[0]='1';
		$arr_result[1]='';
	}// end if($num_authority > 0)
	
	return $arr_result;
}


?>