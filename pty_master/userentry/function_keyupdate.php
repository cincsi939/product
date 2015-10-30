<?
$ticketYY = (date("Y")+543)."".(date("md"))."".(date("His"));
## จำนวนชุดเอกสารที่ค้างบันทึกข้อมูล update
function GetNumDataKeyupdate(){
		global $dbnamemaster;
		#echo $dbnamemaster."<hr>";
		$sql = "SELECT count(CZ_ID) as num,siteid FROM `view_general` where(user_approve <> '1'  or flag_kp7 <> '1') and siteid IN(select site from eduarea_config where group_type='edu_pre' ) group by siteid";
	#	echo $sql."<hr>";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs['siteid']] = $rs['num'];
		}
		return $arr;
}

### สุ่มตัวเลข
 function random_digi($num_require=7) {
	$alphanumeric = array(0,1,2,3,4,5,6,7,8,9);
	$rand_key = array_rand($alphanumeric , $num_require);
	for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
	return $randomstring;
}

function CreateTicket($staffid,$idcard,$siteid,$fullname,$profile_id=100){
	global $ticketYY,$dbnameuse;
			$TicketId = "TK-".$ticketYY."".random_digi(7);
			
			$sql = "SELECT * FROM tbl_assign_sub WHERE staffid='$staffid' AND profile_id='$profile_id'";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			$rs = mysql_fetch_assoc($result);
			if($rs[ticketid] == ""){
				$sql_sub = "INSERT INTO tbl_assign_sub SET ticketid='$TicketId' , staffid='$staffid' , profile_id='$profile_id',assign_date='".date("Y-m-d")."', admin_id='system_update', localtion_key='IN' ,mode_assign='DAY'";
				#echo "$sql_sub<hr>";
				mysql_db_query($dbnameuse,$sql_sub) or die(mysql_error()."$sql_sub<br>LINE__".__LINE__);
				$last_ticket = 	$TicketId;
			}else{
				$last_ticket = 	$rs['ticketid'];
			}
			
			#### บันทึกข้อมูลใน ใบงาน
			$sql_assign = "SELECT COUNT(idcard) as num FROM  tbl_assign_key WHERE idcard='$idcard' AND profile_id='$profile_id' AND ticketid='$last_ticket'";
			$result_assign = mysql_db_query($dbnameuse,$sql_assign) or die(mysql_error()."$sql_assign<br>LINE__".__LINE__);
			$rsa = mysql_fetch_assoc($result_assign);
			if($rsa[num] < 1){ ## บันทึกในใบงาน
				$sql_insert = "INSERT INTO tbl_assign_key(ticketid,idcard,siteid,fullname,profile_id,status_keydata,approve,comment_approve,dateassgin,staff_apporve,userkey_wait_approve)VALUES('$last_ticket','$idcard','$siteid','$fullname','$profile_id','1','2','รับรองการคีย์อัตโนมัติจากการ login เข้าบันทึกข้อมูล update',NOW(),$staffid,'1')";
				#echo "$sql_insert<hr>";
				mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
			}
			
			
			$str_sql = " replace INTO  monitor_keyin(staffid,idcard,siteid,keyin_name,timeupdate,timestamp_key,status_user,timeupdate_user) VALUES ('$_SESSION[session_staffid]','$idcard','$siteid','$fullname',NOW(),NOW(),'1',NOW()) ";
			mysql_db_query($dbnameuse,$str_sql) or die(mysql_error()."$str_sql<br>LINE__".__LINE__);
}


?>
