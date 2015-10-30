<?

$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
function ShowDateTH($d){
global $shortmonth;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $shortmonth[intval($d1[1])] . " " . (intval($d1[0]) + 543);
	
}//end function ShowDateTH($d){
	
function GetStaffidFormData($idcard="",$name_th="",$surname_th=""){
		global $dbnameuse;
		
		if($idcard != ""){
				$conv .= "  AND t1.idcard LIKE '%$idcard%'";
		}
		if($name_th != ""){
				$conv .= " AND t1.fullname LIKE '%$name_th%'";	
		}
		if($surname_th != ""){
				$conv .= " AND t1.fullname LIKE '%$surname_th%' ";	
		}
		$sql = "SELECT t2.staffid FROM tbl_assign_key AS t1 Inner Join tbl_assign_sub AS t2  ON t1.ticketid = t2.ticketid WHERE t1.profile_id >= '4'  $conv  GROUP BY t2.staffid";
		//echo "<hr>sql :: ".$sql."</hr><br>";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$numr1 = mysql_num_rows($result);
		if($numr1 > 0){
			$in_staff = "";
			while($rs = mysql_fetch_assoc($result)){
					if($in_staff > "") $in_staff .= ",";
					$in_staff .= "'$rs[staffid]'";
			}
		}else{
			$in_staff = "";	
		}
		return $in_staff;
		
}//end function GetStaffidFormData(){

function GetDataKp7Key($staffid,$idcard="",$name_th="",$surname_th=""){
	global $dbnameuse;
	
		if($idcard != ""){
				$conv .= "  AND t2.idcard LIKE '%$idcard%'";
		}
		if($name_th != ""){
				$conv .= " AND t2.fullname LIKE '%$name_th%'";	
		}
		if($surname_th != ""){
				$conv .= " AND t2.fullname LIKE '%$surname_th%' ";	
		}
		
		if($conv != ""){
				$conhaving = "";
		}else{
			$conhaving = " having noapprove > 0";	
		}

	$sql = "SELECT
t1.ticketid,
t1.recive_date,
COUNT(t2.idcard) AS num1,
sum(if(t2.approve <> '2',1,0)) as noapprove,
sum(if(t2.userkey_wait_approve='1',1,0)) as key_approve,
sum(if(t2.userkey_wait_approve='1' and t2.approve='2' and (t2.staff_apporve IS NULL or t2.staff_apporve=''),1,0 )) as sys_approve,
sum(if(t2.userkey_wait_approve='1' and t2.approve<> '2',1,0)) as wait_approve,
sum(if(t2.userkey_wait_approve='1' and t2.approve='2' and (t2.staff_apporve IS NOT NULL and  t2.staff_apporve<>''),1,0 ) ) as sup_approve
FROM
tbl_assign_sub as t1
Inner Join tbl_assign_key  as t2 ON t1.ticketid = t2.ticketid
where t1.staffid='$staffid' AND t1.profile_id >= '4' $conv
GROUP BY t1.ticketid $conhaving";	
//echo "<hr>".$sql."</hr><br>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[ticketid]]['numall'] = $rs[num1];
		$arr[$rs[ticketid]]['noapprove'] = $rs[noapprove];
		$arr[$rs[ticketid]]['key_approve'] = $rs[key_approve];
		$arr[$rs[ticketid]]['sys_approve'] = $rs[sys_approve];
		$arr[$rs[ticketid]]['wait_approve'] = $rs[wait_approve];
		$arr[$rs[ticketid]]['sup_approve'] = $rs[sup_approve];
		$arr[$rs[ticketid]]['date_ticketid'] = ShowDateTH($rs[recive_date]);
		
	}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}// end function GetDataKp7Key(){


?>