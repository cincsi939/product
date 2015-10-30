<?php
### ��Ǩ�ͺ�ѹ��ش
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
## ��Ǩ�ͺ�ѹ�������ö login �������к���
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

## ��Ǩ�ͺ�������ѡ�ҹ���١��˹��Է�ԡ�������ҹ�к�
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

## ��Ǩ�ͺ�Է�ԡ���������к�
function CheckAuthorityLogin($staffid,$idcard,$day_id){
	$arr_authority = CheckGroupLogin($staffid); ##  ���ѹ�������㹡�������ҹ�к�
	#echo "<pre>";
	#print_r($arr_authority);
	$num_authority = count($arr_authority); ## �Ѻ����繡�����������㹡�èѴ�Է�ԡ�������ҹ�к��������
	#echo "xxx => $num_authority";die();
	if($num_authority > 0){ # �ó�����㹡������èѴ�Է�ԡ�������ҹ�к�
		$num_holiday = intval(GetHoliday($staffid)); ## ��Ǩ�ͺ������ѹ��ش
		#echo "�ӹǹ�ѹ��ش : ".$num_holiday."";die();
		if($num_holiday < 1){ ## �ó�������ѹ��ش
			$ip_login = substr(GET_IPADDRESS(),0,-3); ## ����ͧ�����㹡�� login
			$ip_face = substr(GetipFaceIn($idcard),0,-3); ## ����ͧ��� face ˹����ҧҹ
			$num_login = intval(GetDayLogin($staffid,$day_id));
			#echo "$ip_login :: $ip_face <hr>";
			#echo "��� login : ".$num_login;die();
			
			if($num_login < 1){ # �ó��������ö�������к���
				#if($ip_login == $ip_face){ ## �ó�  ip ����ͧ��� face ˹����ҧҹ������ͧ���ǡѹ
					$arr_holiday_label = GetLabelHoliday($staffid);
					foreach($arr_authority as $key => $val){
						
						$msg_alert .=$val['dd']." ���� ".$val['time_start']."  �֧ ".$val['time_end'] ."||";	
					}
					if(count($arr_holiday_label) > 0){ ## ��Ǩ�ͺ�ѹ��ش�������ö�������к���
						foreach($arr_holiday_label as $k => $v){
							if($msg_alert1 > 0) $msg_alert1 .= "||";
							$msg_alert1 .= DBThaiLongDateFull($k)." ". $v;
						}
					}
					if($msg_alert1 != ""){ $txt_msg = "|| ����ѹ��ش�Ҫ��ôѧ��� ||".$msg_alert1;}else{ $txt_msg = "";}
					
				$arr_result[0]='0';
				$arr_result[1]= "�س����ö����к�����ѹ������Ҵѧ���  ||".$msg_alert.$txt_msg;
			/*	}else{ # �ó����ͧ��� face ˹�ҡѺ����ͧ��� login �繤�������ͧ�ѹ
					$arr_result[0]='1';
					$arr_result[1]= "";
				}*/
			}else{ # �ó��ѹ������ҷ�� login �ç�Ѻ�Է�Է�����Ѻ�������ö login �������к���
				$arr_result[0]='1';
				$arr_result[1]= "";
			}
		

}else{ # �ó����ѹ��ش�Ҫ���
			$arr_result[0]='1';
			$arr_result[1]='';
		}	
	}else{ ## �ҡ�������㹡������èѴ�Է�ԡ�������ҹ�к�
		$arr_result[0]='1';
		$arr_result[1]='';
	}// end if($num_authority > 0)
	
	return $arr_result;
}


?>