<?php
	require_once("../../config/conndb_nonsession.inc.php");
	######  check �ѹ�������㹡�� login  by kamonchai ######
	
	function getCheckDay($profileid,$groupid,$dayid_login,$staffid,$time_login){
	global $dbnameuse;
		$sqlDay = "SELECT profile_id, group_id, day_id, time_id
							FROM authority_login 
							WHERE profile_id = '".$profileid."' 
						  	AND group_id = '".$groupid."' 
						  	AND day_id = '".$dayid_login."'
						   ORDER BY day_id ASC, time_id ASC ";
		$queryDay = mysql_db_query($dbnameuse,$sqlDay) or die(mysql_error().' sqlDay : '.$sqlDay);
		//echo $sqlDay;
		$rows = mysql_num_rows($queryDay);
		if($rows == 0){ // login ���ç�Ѻ�ѹ���ӡ��
			$sqlDay = "SELECT
							authority_login.profile_id,
							authority_login.group_id,
							authority_login.day_id,
							authority_login.time_id,
							authority_day.day_label
							FROM
							authority_login
							INNER JOIN authority_day ON authority_login.day_id = authority_day.day_id
							WHERE profile_id = '".$profileid."' AND group_id = '".$groupid."' 
							ORDER BY authority_login.day_id ASC";
			$queryDay = mysql_db_query(DB_USERENTRY,$sqlDay) or die(mysql_error().' sqlDay : '.$sqlDay);
			$day = array();
			$i = 0;
			while($dataDay = mysql_fetch_assoc($queryDay)){
				$day[$i] = array('day_label' => $dataDay['day_label']);
				//echo $dataDay['day_label'];
				$i++;
			}
			$day = array_unique($day);
			$day_work = "";
			$i_day = 1;
			foreach($day as $id=>$val){
				if($i_day != count($day)){ $comma = ',';}else{ $comma='';};
				$day_work .= $val['day_label'].$comma;
				$i_day++;
			}
			//echo $day_work;
			//$checkTime = getCheckTime($staffid,$profileid,$time_login,$dayid_login);
			return '- �ѹ�ӡ�âͧ��ҹ ��� '.$day_work.'';
		} //end if(rows == 0)
		else{ // �ç�Ѻ�ѹ�ӡ�� �������ҷ�� login
			$checkTime = getCheckTime($staffid,$profileid,$time_login,$dayid_login);  // ��Ǩ�ͺ���� login
			//echo $checkTime;
			//return true;
			if($checkTime != '1'){
				return $checkTime;
			}
			else{
				return true;
			}
		}
		
		exit;
	}// end getCheckDay
	
	function getCheckTime($staffid,$profile_id,$time_login,$dayid_login){
		$sqlTime2 = "SELECT keystaff.staffid,
							authority_math_profile.profile_id,
							authority_profile.profile_name,
							authority_login.day_id,
							authority_login.time_id,
							authority_time.start_time,
							authority_time.end_time,
							authority_day.day_label
							FROM keystaff
							INNER JOIN authority_math_profile ON keystaff.staffid = authority_math_profile.staffid
							INNER JOIN authority_profile ON authority_math_profile.profile_id = authority_profile.profile_id
							INNER JOIN authority_login ON authority_profile.profile_id = authority_login.profile_id
							INNER JOIN authority_time ON authority_login.time_id = authority_time.time_id
							INNER JOIN authority_day ON authority_login.day_id = authority_day.day_id
							WHERE authority_math_profile.staffid = '".$staffid."' AND authority_math_profile.profile_id = '".$profile_id."' 
							AND authority_login.day_id = '".$dayid_login."'
							ORDER BY authority_login.time_id ASC";
		//echo  $sqlTime;
		//exit;
		$queryTime2 = mysql_db_query(DB_USERENTRY,$sqlTime2) or die(mysql_error().' sqlTime2 : '.$sqlTime2);
		$rows2 = mysql_num_rows($queryTime2);
		$i_time = 0;
		$time1 = array();
		$time2 = array();
		$arr = array();
		$day = array();
		while($dataTime2 = mysql_fetch_assoc($queryTime2)){
			$start_time = strtotime($dataTime2['start_time']);
			$end_time = strtotime($dataTime2['end_time']);
			$timeStart[$i_time] = substr($dataTime2['start_time'],0,-3);
			$timeStart[$i_time] = str_replace(':','.',$timeStart[$i_time]);
			//echo $timeStart[$i_time];
			$timeEnd[$i_time] = substr($dataTime2['end_time'],0,-3);
			$timeEnd[$i_time] = str_replace(':','.',$timeEnd[$i_time]);
			//echo $timeEnd[$i_time];
			if($time_login>=$start_time && $time_login<=$end_time){
				$arr[$i_time] = 1;
			}
			else{
				$arr[$i_time] = 0;
			}
			//$day[$i_time] = array('day_label' => $dataTime2['day_label']);
			//echo $dataDay['day_label'];
			$i_time++;
		}
		//print_r($day);
		//exit;
		$count = count($arr);
		//echo $count;
		$checkTrue = 0;
		//exit;
		for($i_count=0; $i_count<$count; $i_count++){
			$checkTrue += $arr[$i_count];
		}
		//print_r($arr);
		$time_work = '- ����㹡������к��ͧ��ҹ��ѹ��� ��� ���� ';
		$time = "";
		//echo $checkTrue;
		if($checkTrue==0){ // ��ҡѺ 0 �ʴ��������㹪�ǧ���ҷ���������ö login
			$k = 0;
			for($i = 0; $i < $count; $i++){
					$k ++;
					if($k != $count){ $comma = ' , ';}else{ $comma='';};
					$time .= $timeStart[$i].' �. - '.$timeEnd[$i].' �.'.$comma;
			}
			return $time_work .= $time;
		}
		else{
			return true;
		}
		exit;
	}// end getCheckTime	

	function getCheckHoliday($groupid,$date_login){
		$sqlHoliday = "SELECT
								authority_group_holiday.group_id,
								authority_group_holiday.group_name,
								authority_math_group_holiday.holiday_id,
								authority_holiday.date_holiday,
								authority_holiday.label_holiday
								FROM
								authority_group_holiday 
								INNER JOIN authority_math_group_holiday ON authority_group_holiday.group_id = authority_math_group_holiday.group_id 
								INNER JOIN authority_holiday ON authority_math_group_holiday.holiday_id = authority_holiday.holiday_id 
								WHERE authority_group_holiday.group_id = '".$groupid."' 
								ORDER BY authority_math_group_holiday.holiday_id ASC";
		$queryHoliday = mysql_db_query(DB_USERENTRY,$sqlHoliday) or die(mysql_error().' sqlHoliday : '.$sqlHoliday);
		while($dataHoliday = mysql_fetch_assoc($queryHoliday)){
			if($date_login==$dataHoliday['date_holiday']){
				/*echo "<script>alert('�������ö�������к��� ���ͧ�ҡ�ѹ������ѹ��ش����� (".$dataHoliday['label_holiday'].")'); location.href='login.php';</script>";
				exit;*/
				return "- �ѹ������ѹ��ش����� (".$dataHoliday['label_holiday'].")";
			}
			else{
				//echo "getCheckHoliday<br>�ѹ����ѹ�ӧҹ����<br><br>";
				return true;
			}
		}
	}// end getCheckHoliday	
	
// �礡�������ҹ�к��ѹ�֡����������Ѻ���˹�ҷ��ࢵ� �µ�Ǩ�ͺ������͹��ѹ ���� ��� ip 㹡�� face ˹����ҧҹ
function getCheckLogin($username,$password,$dayid_login,$time_login,$date_login){ 
	$sql = "SELECT
				keystaff.staffid,
				keystaff.gid,
				keystaff.card_id,
				authority_math_profile.profile_id,
				authority_profile.profile_name,
				authority_group_holiday.group_name,
				authority_login.time_id,
				authority_time.start_time,
				authority_time.end_time
				FROM
				keystaff
				INNER JOIN authority_math_profile ON keystaff.staffid = authority_math_profile.staffid
				INNER JOIN authority_profile ON authority_math_profile.profile_id = authority_profile.profile_id
				INNER JOIN authority_login ON authority_profile.profile_id = authority_login.profile_id
				INNER JOIN authority_group_holiday ON authority_login.group_id = authority_group_holiday.group_id
				INNER JOIN authority_time ON authority_login.time_id = authority_time.time_id ,
				authority_day
				WHERE keystaff.username = '".$username."' AND keystaff.password = '".$password."'
				GROUP BY keystaff.staffid";
	$query = mysql_db_query(DB_USERENTRY,$sql) or die(mysql_error().' sql : '.$sql);
	$rows = mysql_num_rows($query);
	$msg_error = "";
	if($rows == 1){
		$data = mysql_fetch_array($query);
		//$time_login = strtotime('00:31:00');  // test
		//$dayid_login = '6'; // test
		$checkDay = getCheckDay($data['profile_id'],$data['gid'],$dayid_login,$data['staffid'],$time_login); // ��Ǩ�ͺ�ѹ login 
		//echo $checkDay;
		//exit;
		//$time_login = strtotime('16:31:00');  // test
		//$checkTime = getCheckTime($data['staffid'],$data['profile_id'],$time_login,$dayid_login);  // ��Ǩ�ͺ���� login
		
		//$date_login = '2012-12-05';  //test
		$checkHoliday = getCheckHoliday($data['gid'],$date_login);  // ��Ǩ�ͺ�ѹ��ش�����
		
		$ipFace = GetipFaceIn($data['card_id']);  //  ip 㹡�� face ˹����ҧҹ
		$ipWork = $_SERVER['REMOTE_ADDR'];   //  ip ����ͧ��� login
		//$ipWork = '192.168.10.184';  //ip test
		if($ipFace == $ipWork){
			$msg_error .= '- ��ҹ���ѧ������ͧ����������㹡�� login ��Һѹ�֡�����Ţͧࢵ 177 ࢵ\n';
		}
		if($checkDay != 1){
			$msg_error .= $checkDay.'\n';
		}
		/*if($checkTime != 1){
			$msg_error .= $checkTime.'\n';
		}*/
		if($checkHoliday != 1){
			$msg_error .= $checkHoliday.'\n';
		}
		
		$return = array();
		if($msg_error != ""){
/*			echo '<script>
			alert("�������ö�������к��� ���ͧ�ҡ\n'.$msg_error.'"); 
			location.href="login.php";
			</script>';*/
			$return[0] = '0';
			$return[1] = $msg_error;
			return $return;
		}
		else{
			$return[0] = true;
			$return[1] = $msg_error;
			return $return;
		}
		//exit;
	}
}// end getCheckLogin	

		#######  end check �ѹ�������㹡��  login  ########
?>