<?
require_once("../../config/conndb_nonsession.inc.php");
$count_yy = date("Y")+543;
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");


	function GetSubtractPointAll($yy){
		global $dbnameuse;
		$sql = "SELECT
		t1.staffid,
		t1.idcard,
		sum(t1.num_point*t3.point_subtract) as sumpoint
FROM
		validate_checkdata as t1
		Inner Join validate_datagroup as t2  ON t1.checkdata_id = t2.checkdata_id
		Inner Join validate_mistaken as t3 ON t2.mistaken_id = t3.mistaken_id
WHERE
t1.datecal LIKE  '$yy%'
group by t1.staffid, t1.idcard";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]][$rs[idcard]] = $rs[sumpoint];
				
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr;
	}// end function GetSubtractPointAll($yy){

	function GetSubtractPoint($idcard,$staffid){
			global $dbnameuse;
			$sql = "SELECT
		sum(t1.num_point*t3.point_subtract) as sumpoint
		FROM
		validate_checkdata as t1
		Inner Join validate_datagroup as t2  ON t1.checkdata_id = t2.checkdata_id
		Inner Join validate_mistaken as t3 ON t2.mistaken_id = t3.mistaken_id
		WHERE
		t1.idcard =  '$idcard' and t1.staffid='$staffid'
		group by t1.idcard";	
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()." LINE ::".__LINE__);
			$rs = mysql_fetch_assoc($result);
			return intval($rs[sumpoint]);
	}//end function GetSubtractPoint($idcard,$staffid){
	
	
	function ShowDateThai($get_date){
		global $mname;
		$arr = explode(" ",$get_date);
		if($arr > 1){
			$get_date = $arr[0];
		}
		if($get_date != "0000-00-00"){
			$arr1 = explode("-",$get_date);	
			return intval($arr1[2])." ".$mname[intval($arr1[1])]." ".substr(($arr1[0]+543),-2);
		}else{
			return "";	
		}
}//end function ShowDateThai($get_date){
	
	#### fucntion แสดงชื่อพนักงานคนบันทึกข้อมูล
function ShowStaffKey($get_staffid){
	$db = DB_USERENTRY;
	$sql = "SELECT staffid,prename,staffname,staffsurname FROM keystaff WHERE staffid='$get_staffid'";
	$result = mysql_db_query($db,$sql);
	$rs = mysql_fetch_assoc($result);
	return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function ShowStaffKey($get_staffid){


function ShowArea($get_siteid){
		global $dbnamemaster;
		$sql = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[secname];	
}// end function ShowArea($get_siteid){
	
	

	function GetPointKey($yymm){
			global $dbnameuse;
			$sql = "SELECT
keystaff.staffid,
stat_user_keyin.datekeyin,
stat_user_keyin.numkpoint

FROM
keystaff
Inner Join stat_user_keyin ON keystaff.staffid = stat_user_keyin.staffid
WHERE
stat_user_keyin.datekeyin LIKE  '$yymm%'
order by 
keystaff.staffid,stat_user_keyin.datekeyin asc";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<hr>LINE::".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]][$rs[datekeyin]]	 = $rs[numkpoint];
		}
		return $arr;
	}//END 	function GetPointKey($yymm){
	
function GetSubtact($yymm){
	global $dbnameuse;
	$sql = "SELECT
keystaff.staffid,
stat_subtract_keyin.datekey,
stat_subtract_keyin.spoint
FROM
keystaff
Inner Join stat_subtract_keyin ON keystaff.staffid = stat_subtract_keyin.staffid
WHERE  stat_subtract_keyin.datekey LIKE '$yymm%'
ORDER BY
keystaff.staffid,stat_subtract_keyin.datekey ASC";	
	$result = mysql_db_query($dbnameuse,$sql)or die(mysql_error()."$sql<hr>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[staffid]][$rs[datekey]] = $rs[spoint];
	}
	return $arr;
}//end function GetSubtact($yymm){
	
	
	function ShowDayOfMonth($yymm){
	$arr_d1 = explode("-",$yymm);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // วันเริ่มต้น
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // ฝันที่สุดท้ายของเดือน
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($yymm){
function CountQCPerPerson(){
	global $dbnameuse;
	$sql = "SELECT count(t1.idcard) as num1,t1.idcard,t1.staffid
FROM
validate_checkdata as t1
Inner Join keystaff as t2 ON t1.staffid = t2.staffid
group by t1.staffid,t1.idcard";
	$result = mysql_db_query($dbnameuse,$sql)or die(mysql_error()."$sql<hr>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[staffid]][$rs[idcard]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountQCPerPerson(){

function AddKeyTemp($yymm){
	global $dbnameuse;
	
	$subyy = substr($yymm,0,4);
	$arrqc = CountQCPerPerson();
	$arrsubp = GetSubtractPointAll($subyy);
	$sql = "SELECT
distinct t1.idcard,
t1.staffid,
date(t1.timeupdate) AS datekey
FROM
monitor_keyin AS t1
Inner Join keystaff ON keystaff.staffid = t1.staffid
where   t1.timeupdate LIKE '$yymm%'
order by t1.staffid asc,date(t1.timeupdate) asc";
	$result = mysql_db_query($dbnameuse,$sql)or die(mysql_error()."$sql<hr>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){		
	
		
		if($arrqc[$rs[staffid]][$rs[idcard]] > 0){
			$temp_qc = 1;	
		}else{
			$temp_qc = 0;	
		}// end if($arrqc[$rs[staffid]][$rs[idcard]] > 0){
					
			$arrstaff[$rs[staffid]][$rs[datekey]]['numkey'] =$arrstaff[$rs[staffid]][$rs[datekey]]['numkey']+1;
			$arrstaff[$rs[staffid]][$rs[datekey]]['numqc'] = $arrstaff[$rs[staffid]][$rs[datekey]]['numqc']+$temp_qc;		
			$arrstaff[$rs[staffid]][$rs[datekey]]['numsub'] = $arrstaff[$rs[staffid]][$rs[datekey]]['numsub']+$arrsubp[$rs[staffid]][$rs[idcard]];		
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arrstaff;	
}//end function AddKeyTemp(){



function XShowGroupQC($get_id){
		global $dbnameuse;
		$sql = "SELECT * FROM validate_datagroup WHERE checkdata_id='$get_id'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[dataname];
}

function ShowPerson($get_idcard,$staffid){
	global $dbnameuse;
	$sql = "SELECT
t1.fullname
FROM
tbl_assign_key as t1
Inner Join tbl_assign_sub as t2 ON t1.ticketid = t2.ticketid
where t1.idcard='$get_idcard' and t2.staffid='$staffid' ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql <hr>LINE :: ".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[fullname];
}


function ShowStartdate($staffid){
	global $dbnameuse;
	$sql = "SELECT start_date FROM `keystaff` where staffid='$staffid' group by staffid";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		return ShowDateThai($rs[start_date]);
	}else{
		return "";	
	}
}

############  แสดงชื่อกลุ่ม
function ShowGroupKeyName($groupkey_id){
	global $dbnameuse;
	$sql = "SELECT  groupname FROM keystaff_group WHERE groupkey_id='$groupkey_id'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[groupname];
}//end function ShowGroupKeyName($groupkey_id){
	
#################################   แสดงรายการที่ถูกคีย์ข้อมูล ##############################################

function GetDataQcPoint($yymm){
	global $dbnameuse;
	$sql = "SELECT datekey, staffid, sum(spoint) as num1 FROM stat_subtract_keyin WHERE  datekey LIKE '$yymm%' and staffid > 0 GROUP BY staffid,datekey ORDER  BY staffid ASC";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]][$rs[datekey]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end end function GetDataQcPoint($yymm){
	
##########  function ตรวจสอบการ QC #############
function GetDataQcPoint1($yymm){
	global $dbnameuse;
	$sql = "SELECT datekeyin, staffid,if(doc_qc > 0 and doc_qc<>num_qc,1,0 ) as flag_false FROM stat_subtract_checkqc WHERE  datekeyin LIKE '$yymm%' ORDER BY staffid,datekeyin ASC";
	$result =mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			if($rs[flag_false] == "1"){
					$flagF = "N";
			}else{
					$flagF = "Y";		
			}
			$arr[$rs[staffid]][$rs[datekeyin]] = $flagF;
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetDataQcPoint1($yymm){


function GetGroupKeyRatio($staffid,$datekeyin){
	global $dbnameuse;
	$sql = "SELECT rpoint  FROM stat_user_keyin  WHERE  staffid='$staffid' AND datekeyin='$datekeyin'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[rpoint];
}// end function CheckGroupKeyRatio($staffid,$datekeyin){
	
#### function CheckQCGroup ratio 1:20
function ProcessCheckQcLast($staffid,$yymm){
	global $dbnameuse;
	$sql = "SELECT flag_qc FROM `stat_user_keyperson` WHERE  staffid='$staffid' and  datekeyin LIKE '$yymm%' and status_approve='1' and status_random_qc='1' group by flag_qc ORDER BY flag_qc ASC ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "SELECT datekeyin,staffid,flag_qc FROM `stat_user_keyperson` WHERE  staffid='$staffid' and  datekeyin LIKE '$yymm%' and status_approve='1' and flag_qc='$rs[flag_qc]'  group by datekeyin ORDER BY datekeyin ASC ";
		$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);	
		while($rs1 = mysql_fetch_assoc($result1)){
			$sql_replace = "REPLACE INTO stat_subtract_checkqc SET datekeyin='$rs1[datekeyin]',staffid='$staffid',flag_qc='$rs[flag_qc]'";
			mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."$sql_replace<br>LINE__".__LINE__);
		}//end while($rs1 = mysql_fetch_assoc($result1)){
	}//end 	while($rs = mysql_fetch_assoc($result)){
	
}//end function ProcessCheckQcLast(){
	
#########  function process กลุ่ม N 1:1
function ProcessCheckQCGroupN1($staffid,$yymm){
		global $dbnameuse;
		$sql = "SELECT
		t1.datekeyin,
t1.staffid,
count(t1.idcard) as numall,
sum(if(t1.status_random_qc='1',1,0)) as numqc,
t1.flag_qc
FROM
stat_user_keyperson as t1
Inner Join stat_user_keyin as t2 ON t1.datekeyin = t2.datekeyin AND t1.staffid = t2.staffid
WHERE t1.staffid='$staffid' and   t1.datekeyin LIKE '$yymm%' and t1.status_approve='1' and t2.rpoint='1'
group by t1.datekeyin,t1.flag_qc
having numall='1'
ORDER BY t1.datekeyin ASC";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
	
		
			
			if($rs[datekeyin] != "$temp_date"){
					$doc_qc = 0;
					$num_qc = 0;
					$temp_date = $rs[datekeyin];
			}// end if($rs[datekeyin] != "$temp_date"){
				$doc_qc += $rs[numall];
				$num_qc += $rs[numqc];
					
				$sql1 = "REPLACE INTO stat_subtract_checkqc SET datekeyin='$rs[datekeyin]',staffid='$staffid',flag_qc='$rs[flag_qc]',doc_qc='$doc_qc',num_qc='$num_qc'";	
				mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
		}//end while($rs = mysql_fetch_assoc($result)){
			
			
}//end function ProcessCheckQCGroupN1(){
	
####  แสดง ชื่อกลุ่มการทำงาน
function ShowGroupName($staffid){
	global $dbnameuse;
	$sql = "SELECT t2.groupname, t1.keyin_group FROM keystaff as t1 Inner Join keystaff_group as t2 ON t1.keyin_group = t2.groupkey_id
WHERE t1.staffid='$staffid' ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$rs = mysql_fetch_assoc($result);
	$arr['groupname'] = $rs[groupname];
	$arr['group_id'] = $rs[keyin_group];
	return $arr;		
}// end function ShowGroupName($staffid){


#################  function หาวันสุดท้ายของเดือน
	function lastdays($Ym){
	  list($Y, $m) = explode("-", $Ym);
	  $m = $m+1;
	  if($m==13){
	    $y=$y+1; $m=1;
	  }
	  $lastdate = mktime(12, 0, 0, $m, 1, $Y);
	  $lastdate = strtotime("-1 day", $lastdate);
	  $lastdate = date("Y-m-d", $lastdate);
	  
	  			$arr_d2 = explode("-",$lastdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] != 0){
					$lastday =   $lastdate;
				}else{
					$xbasedate = strtotime("$lastdate");
					 $xdate = strtotime("-1 day",$xbasedate);
					 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
					 $lastday =   $xsdate;	
				}
			
	  return $lastday;
	
	}//end 	function lastdays($Ym){
	 


?>