<?
include ("../../../../config/conndb_nonsession.inc.php")  ;
include ("../../../../common/Script_CheckIdCard.php")  ;
include('function_check_data.inc.php') ;
$db_call= "edubkk_userentry";
$db_temp = "edubkk_checklist";
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	#####  แสดงชื่อเขตพืีนที่การศึกษา
function ShowArea1($get_siteid){
	global $dbnamemaster;
	$xsql1 = "SELECT secname FROM eduarea WHERE secid='$get_siteid'";
	$xresult1 = mysql_db_query($dbnamemaster,$xsql1);
	$xrs1 = mysql_fetch_assoc($xresult1);
	return $xrs1[secname];
}

if($_GET['action'] == "process"){
	$sql = "SELECT * FROM tbl_check_data_excutive";
	$result = mysql_db_query($db_temp,$sql);
	$sql_del = mysql_db_query($db_temp,"DELETE FROM tbl_check_data_excutive_detail");// ลบก่อนทำการตรวจสอบ
	$arrcheck = array();
	while($rs = mysql_fetch_assoc($result)){
		$arrcheck = CheckPersonData($rs[siteid],$rs[idcard]);
		if(count($arrcheck) > 0){
			$flag_check = 0;
			
			foreach($arrcheck as $k => $v){
					foreach($v  as $k1 => $v1){
						$sqlsave = "INSERT INTO tbl_check_data_excutive_detail SET idcard='$rs[idcard]' , code_error='$v1'";
						mysql_db_query($db_temp,$sqlsave);
					}
			}
				
		}else{
			$flag_check = 1;
		}
		
		$sql_up = "UPDATE tbl_check_data_excutive SET flag_check='$flag_check'  WHERE idcard='$rs[idcard]'";
		mysql_db_query($db_temp,$sql_up);
		unset($arrcheck);
	}
	/*echo "<script>location.href='?action=&show=view';</script>";*/
}//end if($_GET['action'] == "process"){


if($show == ""){ $show = "view";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F60;
}
a:active {
	color: #000;
}
</style>
</head>
<body>

<?
$sql = "SELECT * FROM tbl_check_data_excutive";
$result = mysql_db_query($db_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql1 = "SELECT position_now FROM view_general WHERE CZ_ID='$rs[idcard]'";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$sql_up = "UPDATE tbl_check_data_excutive SET position_now='$rs1[position_now]' WHERE idcard='$rs[idcard]'";
	mysql_db_query($db_temp,$sql_up);
		
}// end while($rs = mysql_fetch_assoc($result)){

?>
</body>
</html>
