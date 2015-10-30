<?

	define("CMSS_HOST","61.19.255.74");
	define("CMSS_USER","cmss");
	define("CMSS_PWD","2010cmss");
	
	function ConHost($host,$user,$pass){
				$myconnect = mysql_connect($host,$user,$pass) OR DIE("Unable to connect to database :: $host ");
				$iresult = mysql_query("SET character_set_results=tis-620");
				$iresult = mysql_query("SET NAMES TIS620");
			return $myconnect;
	}

	function GetDataChecklist($idcard){
		global $dbname_temp;
		ConHost(CMSS_HOST,CMSS_USER,CMSS_PWD);
		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' and pic_num > 0  ORDER BY  profile_id DESC LIMIT 1";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql <br>LINE :: ".__LINE__);
		$rs = mysql_fetch_assoc($result);
		$arr['prename_th'] = $rs[prename_th];
		$arr['name_th'] = $rs[name_th];
		$arr['surname_th'] = $rs[surname_th];
		$arr['fullname'] = "$rs[prename_th]$rs[name_th] $rs[surname_th]";
		$arr['pic_num'] = $rs[pic_num];
		$arr['pic_upload'] = $rs[pic_upload];
		return $arr;
	}// end GetDataChecklist($idcard,$profile_id){
		

	
	
$xidcard = "4670200007278";
$profile_id = "1";
$arr = GetDataChecklist($xidcard);
echo "<pre>";
print_r($arr);



?>