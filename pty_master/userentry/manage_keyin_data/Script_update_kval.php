<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalScore";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::29/07/2011
#LastUpdate::29/07/2011
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
//die;
			set_time_limit(0);
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			
			$time_start = getmicrotime();
			$k12 = 0.1051;
			$percenadd = 5;
			
			function GetPersonKey($datekeyin,$staffid){
				global $dbnameuse;
				$sql = "SELECT t2.idcard, t1.staffid FROM
keystaff as t1
Inner Join stat_user_keyperson as t2 ON t1.staffid = t2.staffid
where t2.datekeyin='$datekeyin'  and t1.staffid='$staffid'
group by  t2.idcard";	
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				while($rs = mysql_fetch_assoc($result)){
						if($in_id > "") $in_id .= ",";
						$in_id .= "'$rs[idcard]'";
				}
			}
			
			
	
			
			
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
					//if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					//}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($yymm){
	
	
function GetModule(){
	global $db_competency;
	$sql = "SELECT
appname,
filename
FROM appfile_timequery";	
	$result = mysql_db_query($db_competency,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		if($inapp > "") $inapp .= ",";
		$inapp .= "'$rs[appname]'";
		
	}
	return $inapp;
}

function GetFile(){
	global $db_competency;
	$sql = "SELECT
appname,
filename
FROM appfile_timequery";	
	$result = mysql_db_query($db_competency,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		if($inapp > "") $inapp .= ",";
		$inapp .= "'$rs[filename]'";
		
	}
	return $inapp;
}



function GetAvgTime($datekeyin,$staffid){
	global $db_competency,$dbnameuse;
	$inidcard = "";
	$inmodule = "";
	$infile = "";
		$inidcard = GetPersonKey($datekeyin,$staffid);
		$inmodule = GetModule();
		$infile = GetFile();
		if($inidcard != ""){
				$conuser = " AND (username IN($inidcard) OR username='$staffid')";
		}
		
if($inmodule != ""){
		$conM = " AND appname IN($inmodule)";
}
if($infile != ""){
	$conF = " AND filename IN($infile)";	
}

$sql = "SELECT
avg(system_timequery.timequery) as avgtime
FROM `system_timequery`
where date(system_timequery.timeupdate) ='$datekeyin'
$conuser $conM $conF
group by date(system_timequery.timeupdate)";
//echo $sql."<br>";die;
$result = mysql_db_query($db_competency,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
$rs = mysql_fetch_assoc($result);
		
return $rs[avgtime];
	
}//end function GetAvgTime($datekeyin,$staffid){
			

$yymm = "2011-07";
$arrDayOfmonth = ShowDayOfMonth($yymm);
if(count($arrDayOfmonth) > 0){
	foreach($arrDayOfmonth as $k => $v){
		foreach($v as $k1 => $v1){
			$sql1 = "SELECT
t1.datekeyin,
t1.staffid,
t1.numkpoint,
t2.spoint,
if(t1.rpoint > 0 and t1.rpoint IS NOT NULL,t2.spoint * t1.rpoint,if(t2.point_ratio > 0 and t2.point_ratio IS NOT NULL,t2.spoint * t2.point_ratio,t2.spoint * 1)) as subpoint,
if(t1.rpoint > 0 and t1.rpoint IS NOT NULL,t1.rpoint,if(t2.point_ratio > 0 and t2.point_ratio IS NOT NULL, t2.point_ratio,1)) as rpoint
FROM
stat_user_keyin as t1
Left Join stat_subtract_keyin as t2 ON t1.datekeyin = t2.datekey AND t1.staffid = t2.staffid
where t1.datekeyin='$v1'
group by t1.staffid";
			$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
			while($rs1 = mysql_fetch_assoc($result1)){
				$avgtime = GetAvgTime($rs1[datekeyin],$rs1[staffid]);
				$kvalue = (($avgtime-$k12)*100)/$k12;
				
				$kpoint5percen = $rs1[numkpoint]+(($rs1[numkpoint]*$percenadd)/100);
				if($kvalue > 0){
						$kvalue = $kvalue ;
				}else{
						$kvalue = 0;
				}
				
				$sql_update = "REPLACE INTO report_staffkeyin_add SET staffid='$rs1[staffid]',datekeyin='$rs1[datekeyin]',kpoint='$rs1[numkpoint]',kpoint5percen='$kpoint5percen',kvalue='$kvalue',spoint='$rs1[spoint]',rpoint='$rs1[rpoint]',netspoint='$rs1[subpoint]' ";
				
				//echo $sql_update."<br>";
				mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE___".__LINE__);
					
					$avgtime = 0;
					$kvalue = 0;
				
			}//end while($rs1 = mysql_fetch_assoc($result1)){
				
		}
			
	}
		
}// end if(count($arrDayOfmonth) > 0){



##  end เขียนข้อมูลใส่ใน ranking 
$time_end = getmicrotime();
echo "เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";
 writetime2db($time_start,$time_end);




 echo "<h1>Done...................";
 ?>