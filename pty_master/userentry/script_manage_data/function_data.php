<?
	function InsertLogApprove($idcard,$siteid,$profile_id,$staffkey){
			global $dbnameuse;
			$sql = "REPLACE INTO tbl_assign_key_approve_auto SET idcard='$idcard',siteid='$siteid',profile_id='$profile_id',staffkey='$staffkey',timeupdate=NOW()";
			mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			
	}// end function InsertLogApprove(){
		
		#########  function ในการ่ตรวจสอบพนักงานกลุ่ม L ที่อายุงานยังไม่เกิน 2 เดือน
		
	function GetStaffLast2month(){
			global $dbnameuse;
			$sql = "SELECT t1.staffid, t1.keyin_group, t1.start_date, TIMESTAMPDIFF(MONTH,t1.start_date,'".date("Y-m-d")."') as work_month FROM keystaff as t1 where t1.keyin_group='2'  having work_month < 3 ";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
					if($in_id > "") $in_id .= ",";
					$in_id .= "'$rs[staffid]'";
			}// end while($rs = mysql_fetch_assoc($result)){
				return $in_id;
	}// end function GetStaffLast2month(){
		
		
 ?>
 	