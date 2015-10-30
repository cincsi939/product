<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_percen_entry_CCfile";
$module_code 		= "percen_entry_CCfile"; 
$process_id			= "percen_entry_CCfile";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::05/102007
#LastUpdate	::05/102007
#DatabaseTabel::
#END
#########################################################
include("../libary/function.php");
include("../../../config/conndb_nonsession.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();


set_time_limit(36000);
if ($maxlimit = ""){ $maxlimit=200 ; } 


$nowIPx =  $_SERVER[SERVER_ADDR] ; 
if ($nowIPx == "127.0.0.1"){
	$masterIP = "127.0.0.1";
	$nowIP = "localhost";
}else{
	$masterIP = "192.168.2.12";	
	$nowIP =  HOST;
} ############### END  if ($nowIP == "127.0.0.1"){
#$masterIP = "192.168.2.12";	

$localDB = "democmss_db";
$masterDB = $dbnamemaster ; 
$title 	= "จำแนกตามสังกัด"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>คำนวน สถานะการนำเข้า</title>


</head>
<body  >
<?
echo "  <CENTER><h4>  $nowIP  <br>  $masterIP  </h4> </CENTER>";
# die (__LINE__) ; 
conn($masterIP) ; 	
conn("192.168.2.12") ; 

$sql1 = "   SELECT * FROM `view_listdep` ORDER BY `date_rec` DESC LIMIT 0,1  "; 
$result1= mysql_db_query($masterDB , $sql1); 
$rs1 = @mysql_fetch_assoc($result1)  ;
$maxdate = $rs1[date_rec] ;

$sql1 = "   SELECT * FROM `view_listdep`  WHERE  `date_rec` = '$maxdate'  order by count_nm  DESC   "; 
$result1= mysql_db_query($masterDB , $sql1); 
while($rs1 = @mysql_fetch_assoc($result1)){
	$dep_code = $rs1[dep_code] ; 
	$arr_countnm[$dep_code]= $rs1[count_nm] ; 
	$db_lastupdate = $rs1[timestamps] ; 
}

$sql1 = "   SELECT * FROM `eduarea`     ";  
$result1= mysql_db_query($masterDB , $sql1); 
while($rs1 = @mysql_fetch_assoc($result1)){
	$dep_code = $rs1[secid] ; 
	$arr_name[$dep_code] = $rs1[secname] ; 
	$arr_name1[$dep_code] = $rs1[secname] ; 	
}


@reset($arr_name) ; 
@reset($arr_name1) ; 
?>
gocompute

<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
<?
if ($gocompute != ""){ 

$sqlloop = "
SELECT DISTINCT  area_info.intra_ip  , eduarea.secid AS xsiteid  ,  secname  FROM
eduarea  Inner Join area_info ON eduarea.area_id = area_info.area_id
";
$resultloop = @mysql_db_query($masterDB , $sqlloop) ; 
while( $rsloop = @mysql_fetch_assoc($resultloop)){ 
	$xsiteid = $rsloop[xsiteid] ; 
	$arr_siteid[$xsiteid] = $rsloop[intra_ip] ; 
	$i++; 
	if ($xsiteid == 1000 ) { 
		echo "<br>-----------------<br> $masterDB  ||||| $sqlloop  |||||||||   $rsloop[secname] <br>-----------------<br>";
	}
} ##@@@@@@@@@@@@@@  	while( $rsloop = @mysql_fetch_assoc($resultloop)){ 

# print_r($arr_siteid) ; 
#  echo " <hr> ";


@mysql_free_result($result);
 while (list ($xsiteid, $now_intraip) = each ($arr_siteid)) {
	conn($now_intraip) ; 	
	$now_dbname = STR_PREFIX_DB. $xsiteid ; 
	$hr_dbname = $now_dbname ; 
echo " <br>  ============================= $now_intraip == $now_dbname  =======================   ";	
$sqlstd = "
SELECT    Count(general.name_th) AS count_nm,  
$dbnamemaster.area_info.IP,  $dbnamemaster.area_info.intra_ip,  $dbnamemaster.eduarea.secid   FROM   general
		Inner Join $dbnamemaster.eduarea ON general.siteid = $dbnamemaster.eduarea.secid
		Inner Join $dbnamemaster.id_department ON $dbnamemaster.eduarea.beunderid = $dbnamemaster.id_department.dep_code
		Inner Join $dbnamemaster.area_info ON $dbnamemaster.eduarea.area_id = $dbnamemaster.area_info.area_id
WHERE  dep_code =  '20004'   
AND   intra_ip =  '$now_intraip' 
"; 	
	
##################################################################### Start  1 ผอ สพท
	$sql = $sqlstd . "	
AND     position_now like 'ผู้อำนวยการ%' 	
AND   (   position_now like '%สพท%'   OR    position_now like '%สำนักงานเขตพื้นที่%'   )
GROUP BY   secid  
	"; 	
	$result = mysql_db_query($hr_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_head[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
	$sql = $sqlstd . "	
AND approve_status = 'approve' 	  AND     position_now like 'ผู้อำนวยการ%' 	
AND   (   position_now like '%สพท%'   OR    position_now like '%สำนักงานเขตพื้นที่%'   )
GROUP BY   secid 
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_head_approve[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 	
##################################################################### END 1 ผอ สพท
########### arrdb_area_head ||  arrdb_area_head_approve
##################################################################### Start 2 รอง ผอ สพท
# echo "<hr>  <pre>  $sql  ";  print_r($arrdb_area_head) ;   echo " </pre>  ";
	$sql = $sqlstd . "	
AND   (   position_now like '%สพท%'   OR    position_now like '%สำนักงานเขตพื้นที่%'   )
AND   (   position_now like '%รอง%'   OR    position_now like '%ผู้ช่วย%'   )
GROUP BY   secid 
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_voice[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 


	
	$sql = $sqlstd . "	
AND approve_status = 'approve' 		
AND   (   position_now like '%สพท%'   OR    position_now like '%สำนักงานเขตพื้นที่%'   )
AND   (   position_now like '%รอง%'   OR    position_now like '%ผู้ช่วย%'   )
GROUP BY   secid 
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_voice_approve[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 

	
# echo " <hr><pre>  $sql  ";  print_r($arrdb_area_voice) ;   echo " </pre> ";
##################################################################### END 2  รอง ผอ สพท
########### arrdb_area_head , arrdb_area_head_approve || arrdb_area_voice  , arrdb_area_voice_approve 
##################################################################### 3 เจ้าหน้าที่เขต    สพท
	$sql = $sqlstd . "	
AND  position_now not  like '%ผู้อำนวยการ%'  	
AND   (   position_now not  like '%ผู้อำนวยการ%สพท%'   AND    position_now  not like '%ผู้อำนวยการ%สำนักงานเขตพื้นที่%'   )
AND       position_now not like '%ครู%'      AND   `position_now` not  LIKE '%ศึกษานิ%'  
GROUP BY   secid 
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_staff[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
	
	$sql = $sqlstd . "	
AND  position_now not  like '%ผู้อำนวยการ%'  	 AND approve_status = 'approve' 			
AND   (   position_now not  like '%ผู้อำนวยการ%สพท%'   AND    position_now  not like '%ผู้อำนวยการ%สำนักงานเขตพื้นที่%'   )
AND       position_now not like '%ครู%'      AND   `position_now` not  LIKE '%ศึกษานิ%'  
GROUP BY   secid  
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_staff_approve[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 	
##################################################################### END 3  เจ้าหน้าที่เขต รอง ผอ สพท
########### arrdb_area_head , arrdb_area_head_approve || arrdb_area_voice  , arrdb_area_voice_approve 
########### arrdb_area_staff , arrdb_area_staff_approve ||
##################################################################### Start 4 ศึกษานิเทศน์ 
	$sql = $sqlstd . "	
AND    `position_now`    LIKE '%ศึกษานิ%'    GROUP BY   secid  

	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_ecuadvice[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
	
	$sql = $sqlstd . "	
AND approve_status = 'approve' 			
AND    `position_now`    LIKE '%ศึกษานิ%'    GROUP BY   secid  
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_area_ecuadvice_approve[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 	
##################################################################### END  4 ศึกษานิเทศน์ 
########### arrdb_area_head , arrdb_area_head_approve || arrdb_area_voice  , arrdb_area_voice_approve 
########### arrdb_area_staff , arrdb_area_staff_approve || arrdb_area_ecuadvice , arrdb_area_ecuadvice_approve
##################################################################### Start 5 ผอ โรงเรียน 
	$sql = $sqlstd . "	
AND  position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'	
AND   (   position_now like 'ผู้อำนวยการ%'     ) 
	
position_now like 'ครูใหญ่%'
GROUP BY   secid  
	"; 	
	เพิ่มครูใหญ่ไปด้วย
	

	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_sc_head[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
	$sql = $sqlstd . "	
AND approve_status = 'approve' 			
AND  position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'	
AND   (   position_now like 'ผู้อำนวยการ%'     )  GROUP BY   secid 
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	
	
if ($secid == 1102){ echo " <br>  $sql    <br>  "; } 		
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_sc_head_approve[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 	
##################################################################### END   5 ผอ โรงเรียน 
########### arrdb_area_head , arrdb_area_head_approve || arrdb_area_voice  , arrdb_area_voice_approve 
########### arrdb_area_staff , arrdb_area_staff_approve || arrdb_area_ecuadvice , arrdb_area_ecuadvice_approve
########### arrdb_sc_head , arrdb_sc_head_approve || 
##################################################################### Start 6 รอง ผอ โรงเรียน 
	$sql = $sqlstd . "	
AND   (   position_now like 'รองผู้อำนวยการ%'  or   position_now like 'ผู้ช่วย%' )  
AND  position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'
GROUP BY   secid  
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_sc_voice[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
	$sql = $sqlstd . "	
AND approve_status = 'approve' 				 
AND   (   position_now like 'รองผู้อำนวยการ%'  or   position_now like 'ผู้ช่วย%' )    
AND  position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%' GROUP BY   secid 
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_sc_voice_approve[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 	
##################################################################### END   6 รอง ผอ โรงเรียน 
########### arrdb_area_head , arrdb_area_head_approve || arrdb_area_voice  , arrdb_area_voice_approve 
########### arrdb_area_staff , arrdb_area_staff_approve || arrdb_area_ecuadvice , arrdb_area_ecuadvice_approve
########### arrdb_sc_head , arrdb_sc_head_approve || 
###########  arrdb_sc_voice , arrdb_sc_voice_approve
##################################################################### Start 7 ครู 
	$sql = $sqlstd . "	
AND   (   position_now like '%ครู%'  )   AND     `schoolid` <> ''  
GROUP BY   secid  
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_sc_teacher[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
	$sql = $sqlstd . "	
AND approve_status = 'approve' 			 
AND   (   position_now like '%ครู%'  )   AND     `schoolid` <> ''     GROUP BY   secid 
	"; 	
	$result = mysql_db_query($now_dbname , $sql); 
	if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
	while( $rs = mysql_fetch_assoc($result) ){
		$rs_siteid = $rs[secid] ; 
		$arrdb_sc_teacher_approve[$rs_siteid] += $rs[count_nm] ; 
	} #######>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 	

##################################################################### END   7 ครู 
########### arrdb_area_head , arrdb_area_head_approve || arrdb_area_voice  , arrdb_area_voice_approve 
########### arrdb_area_staff , arrdb_area_staff_approve || arrdb_area_ecuadvice , arrdb_area_ecuadvice_approve
########### arrdb_sc_head , arrdb_sc_head_approve || 
###########  arrdb_sc_voice , arrdb_sc_voice_approve || arrdb_sc_teacher , arrdb_sc_teacher_approve 




} ##@@@@@@@@@@@@@@@@@@@@@@@@ 	 while (list ($id, $now_intraip) = each ($arr_ip)) {
conn( $masterIP ) ; 	

while (list ($xsecid, $depname) = each ($arr_name)) {
# if ($xsecid == 5002 ){ continue  ; } 
	$a = $arrdb_areaexenum[$xsecid] ;
	$b = $arrdb_exenm[$xsecid];				#  ผู้บริหาร ข้าราชการ ก.พ.  
	$c = $arrdb_scex[$xsecid] ;					# ผอ.รองผอ. โรงเรียน
	$sql1 = " REPLACE INTO `view_listdep_detail` (`date_rec`,`dep_code`,`dep_name`,`area_exe`,`area_staff`,`sc_exe`,`timestamps`) 
	VALUES ( NOW() ,'$depid','$depname','$a','$b','$c', NOW()  )  "; 

$sql1 = " UPDATE `view_percen_entry_dep` SET `area_exe`='$a',`area_staff`='$b',`sc_exe`='$c',
`timestamps`= NOW() WHERE  (`dep_code`='$depid')   ";  
	
########### arrdb_area_head , arrdb_area_head_approve || arrdb_area_voice  , arrdb_area_voice_approve 
###########  arrdb_area_ecuadvice , arrdb_area_ecuadvice_approve || arrdb_area_staff , arrdb_area_staff_approve
########### arrdb_sc_head , arrdb_sc_head_approve || 
###########  arrdb_sc_voice , arrdb_sc_voice_approve || arrdb_sc_teacher , arrdb_sc_teacher_approve 
$ing_1 = $arrdb_area_head[$xsecid] ; 
$ing_2 = $arrdb_area_voice[$xsecid] ; 
$ing_3 = $arrdb_area_ecuadvice[$xsecid] ; 
$ing_4 = $arrdb_area_staff[$xsecid] ; 
$ing_5 = $arrdb_sc_head[$xsecid] ; 
$ing_6 = $arrdb_sc_voice[$xsecid] ; 
$ing_7 = $arrdb_sc_teacher[$xsecid] ; 
#======================================================================= 
$ing_01 = $ing_1 + $ing_2  ;  $ing_02 = $ing_3 + $ing_4  ; $ing_03 = $ing_5 + $ing_6  ; 
#======================================================================= 
$app_1 = $arrdb_area_head_approve[$xsecid] ; 
$app_2 = $arrdb_area_voice_approve[$xsecid] ; 
$app_3 = $arrdb_area_ecuadvice_approve[$xsecid] ; 
$app_4 = $arrdb_area_staff_approve[$xsecid] ; 
$app_5 = $arrdb_sc_head_approve[$xsecid] ; 
$app_6 = $arrdb_sc_voice_approve[$xsecid] ; 
$app_7 = $arrdb_sc_teacher_approve[$xsecid] ; 
#======================================================================= 
$sql1 = " 
UPDATE `view_percen_entry_dep` SET 
`area_exe`='$ing_01',`area_staff`='$ing_02',`sc_exe`='$ing_03',
`area_head`='$ing_1',`area_voice`='$ing_2',`area_eduadvice`='$ing_3',`area_38k2`='$ing_4',
`sc_head`='$ing_5',`sc_voice`='$ing_6',`sc_teacher`='$ing_7',
`app_area_head`='$app_1',`app_area_voice`='$app_2',`app_area_eduadvice`='$app_3',`app_area_38k2`='$app_4',
`app_sc_head`='$app_5',`app_sc_voice`='$app_6',`app_teacher`='$app_7'  , timestamps = NOW()  
WHERE      (`dep_code`='$xsecid')  	
" ; 

echo " <hr>  $depname   <br><br> $sql1     "; 

$result = mysql_db_query($masterDB , $sql1); 
$result = mysql_db_query("cmss" , $sql1); 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   } 

} ###### END while (list ($depid, $depname) = each ($arr_name)) {

#	UPDATE `view_listdep_target` SET `target_nm`='576780',`entry_nm`='443500' 
#	WHERE (`date_rec`='2007-10-09') AND (`dep_code`='20004')  
# --------------------------------------------------------------------------------------------------------------------------------------------------- 
# ------------ 
# ------------ 
# --------------------------------------------------------------------------------------------------------------------------------------------------- 
$sql = "  
SELECT dep_name, dep_code, IP, intra_ip, secid, secname 
FROM   $dbnamemaster.eduarea  
Inner Join $dbnamemaster.id_department ON $dbnamemaster.eduarea.beunderid = $dbnamemaster.id_department.dep_code 
Inner Join $dbnamemaster.area_info ON $dbnamemaster.eduarea.area_id = $dbnamemaster.area_info.area_id 
GROUP BY  dep_code 
" ; 
#05006		9911	สถาบันการพลศึกษา
#18004		1040	กรมศิลปากร
#20002		9912	สํานักงานปลัดกระทรวงศึกษาธิการ
#20004		1001	สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน
#20005		9910	สำนักงานคณะกรรมการการอุดมศึกษา
#20006		9999	สำนักงานคณะกรรมการการอาชีวศึกษา



#} ################ if ($gocompute != ""){   
#if ($gocompute2 != ""){  
	conn( $masterIP ) ;
	#-----------------------------------------------------------------------------> ผอ  / ผอ.รอง โรงเรียน
	$sql = " SELECT Sum(sc_head) AS sum_schead, Sum(voice_exe) AS sum_scvoice FROM allschool " ; 
	$result = mysql_db_query($masterDB , $sql); 
	while($rs = mysql_fetch_assoc($result)){ 
		$sum_schead = $rs[sum_schead] ; 
		$sum_scvoice = $rs[sum_scvoice] ; 		
	} ##################  while($rs = mysql_fetch_assoc($result)){ 
	#-----------------------------------------------------------------------------> บุคลากรในเขต
	$sql = " SELECT
	Sum(area_head) AS sum_areahead,Sum(area_voicehead) AS sum_areavoice,
	Sum(area_eduadvice) AS sum_areaeduadvice,Sum(area_staff) AS sum_areastaff
	FROM   area_staffref  
	WHERE siteid != 1040 and siteid < 9900  
	" ; 
	$result = mysql_db_query($masterDB , $sql); 
	while($rs = mysql_fetch_assoc($result)){ 
		$allareastaff = $rs[sum_areahead] +$rs[sum_areavoice] + $rs[sum_areaeduadvice] + $rs[sum_areastaff] ;
	} ##################  while($rs = mysql_fetch_assoc($result)){ 
	$alltarget = $sum_schead + $sum_scvoice + $allareastaff ; 
	#-----------------------------------------------------------------------------> จำนวนรวม ของ สพท. ใน ปัจจุบัน
	$sql1 = "   SELECT  * 	FROM `view_percen_entry_dep` 
     WHERE  dep_code != 1040  AND  dep_code < 9000  
  "; 
#	  echo $sql1 ;
	$result1= mysql_db_query($masterDB , $sql1); 
	while($rs1 = @mysql_fetch_assoc($result1)){
		$depid = $rs1[dep_code] ; 
		$arrdb_areaexe[$depid] = $rs1[area_exe]  ;
		$arrdb_exenm[$depid] = $rs1[area_staff] ;				#  ผู้บริหาร ข้าราชการ ก.พ.  
		$arrdb_scex[$depid]  = $rs1[sc_exe] ;					# ผอ.รองผอ. โรงเรียน
		if ($depid == 5002) { $arrdb_exenm[$depid]  = 2024  ;  }		
	} ###while($rs1 = @mysql_fetch_assoc($result)){ 
	   $allentry  = (@array_sum($arrdb_areaexe)) + (@array_sum($arrdb_exenm)) +(@array_sum($arrdb_scex)) ; 
	#-----------------------------------------------------------------------------> 
	#-----------------------------------------------------------------------------> เสร็จสิ้น เริ่ม นำเข้าเรียบร้อย
	$sql = " UPDATE `view_percen_entry_target` SET `target_nm`='$alltarget',`entry_nm`='$allentry' 
	WHERE  (`dep_code`='20004')   " ; 
	$result1= mysql_db_query($masterDB , $sql ); 
	
} ################ if ($gocompute2 != ""){   
?>
</body>
</html>