<?
set_time_limit(0);

include ("../../common/common_competency.inc.php")  ;
$db_temp = DB_CHECKLIST;

function xRmkdir1($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
		mkdir($way);
	}
}//end function xRmkdir($path,$mode = 0777){


//include("checklist.inc.php");
$pathfile = "../../../image_file/";
$pathfile_loss = "../../../image_file_loss/";

//$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid_replace <> '' AND siteid_replace IS NOT NULL";

$sql = "SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.siteid_replace
FROM
tbl_checklist_kp7
Inner Join temp_idcard_pic ON tbl_checklist_kp7.idcard = temp_idcard_pic.idcard";
$result = mysql_db_query($db_temp,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	$db_site = "cmss_".$rs[siteid];
	$sql1 = "SELECT
general_pic.imgname
FROM
general
Inner Join general_pic ON general.idcard = general_pic.id
WHERE
general.idcard =  '$rs[idcard]'";
	$result1 = mysql_db_query($db_site,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$file_c = "$pathfile".$rs[siteid]."/".$rs1[imgname];
		$file_c1 = "$pathfile".$rs[siteid_replace]."/".$rs1[imgname];
		
		//if(is_file($file_c)){

	//	}else{
		$path_n = "$pathfile_loss".$rs[siteid]."/";
		if(!is_dir($path_n)){
			xRmkdir1($path_n);
		}
			$file_bdest = $path_n.$rs1[imgname];
			echo "<a href='$file_bdest' target='_blank'>$file_bdest</a><br>";
			copy($file_c1,$file_bdest);
			@chmod("$file_bdest",0777);	

			$i++;
			echo " <a href='$file_c1' target='_blank'>$file_c1</a> :: <a href='$file_c' target='_blank'>$file_c</a><br>";
			copy($file_c1,$file_c);	
			@chmod("$file_c",0777);	
		//}
	}//end 		
	
	
}//end while($rs = mysql_fetch_assoc($result)){

echo "จำนวนไฟล์รูปทั้งหมดที่ทำการคัดลอกมาได้มีจำนวน  $i  รายการ";
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>เครื่องมือในการจัดการไฟล์ pdf</title>
</head>
<body bgcolor="#EFEFFF">
</body>
</html>
