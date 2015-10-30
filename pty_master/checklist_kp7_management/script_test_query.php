<?


session_start();


include("checklist2.inc.php");


if($action == "process"){
	
	
	function ChecklistSchoolSite($siteid){
	global $dbnamemaster;
	$sql = "SELECT id FROM allschool WHERE siteid='$siteid'";	
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[id]] = $rs[id];
	}
	return $arr;
}
	
	$ins = "";
	$arrch = ChecklistSchoolSite("5003");
	if(count($arrch) > 0){
			foreach($arrch as $k => $v){
					if($ins > "") $ins .= ",";
					$ins .= "'$v'";
			}
	}
	if($ins != ""){
		
		$xconif .= " or schoolid NOT IN($ins)";	
	}else{
		$xconif = "";	
	}
	
				$sql = "SELECT
	if(schoolid='' or schoolid IS NULL or schoolid='0' $xconif,'',schoolid) as schid,

		Count(idcard) AS NumAll,
		
		Sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0'  and page_upload>0  ,1,0 )) as NumUpload,
		
		Sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0' and page_upload > 0 ,1,0)) as NumUpNomain, 
		
		Sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0' ,1,0 )) as NumPass, 
		
		Sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ,1,0 )) as NumNoPass, 
		sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' and status_id_false='0' ,1,0)) as NumDisC, 
		
		sum(if(status_numfile='1' and status_id_false='1' ,1,0)) as numidfalse,
		sum(if(status_numfile='0' and status_id_false='0' ,1,0)) as numnorecive,
		sum(if(status_numfile='0' and status_id_false='1' ,1,0)) as numnorecive_idfalse
FROM
edubkk_checklist.tbl_checklist_kp7
WHERE  profile_id='6' AND edubkk_checklist.tbl_checklist_kp7.siteid='5003' GROUP BY edubkk_checklist.tbl_checklist_kp7.schoolid  ";
echo $sql."<br>";
		$result=  mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){

		
		if($rs[schid] == "" or $rs[schid] == "0"){
			echo "ไม่ระบุหน่วยงาน =>".$rs[NumAll]."<br>";
			$idsch = "";	
		}else{
			echo  "$rs[schid] =>".$rs[NumAll]."<br>";
			$idsch = $rs[schid];
		}
		
		
		
		$arr[$idsch]['NumAll'] = $arr[$idsch]['NumAll']+$rs['NumAll'];
		$arr[$idsch]['NumUpload'] = $arr[$idsch]['NumUpload']+$rs['NumUpload'];
		$arr[$idsch]['NumUpNomain'] = $arr[$idsch]['NumUpNomain']+$rs['NumUpNomain'];
		$arr[$idsch]['NumPass'] = $arr[$idsch]['NumPass']+$rs['NumPass'];
		$arr[$idsch]['NumNoPass'] = $arr[$idsch]['NumNoPass']+$rs['NumNoPass'];
		$arr[$idsch]['NumNoMain'] = $arr[$idsch]['NumNoMain']+$rs['NumNoMain'];
		$arr[$idsch]['numidfalse'] = $arr[$idsch]['numidfalse']+$rs['numidfalse'];
		$arr[$idsch]['numnorecive_idfalse'] = $arr[$idsch]['numnorecive_idfalse']+$rs['numnorecive_idfalse'];
		$arr[$idsch]['numnorecive'] = $arr[$idsch]['numnorecive']+$rs['numnorecive'];
		$arr[$idsch]['numidfalse'] = $arr[$idsch]['numidfalse']+$rs['numidfalse'];
		
		
		}
		
		
		
		echo "<pre>";
		print_r($arr);
}//end if($action == "process"){


echo "<a href='?action=process'>คลิ๊กประมวลผล</a>";

echo "OK $i รายการ";
?>
