<?
set_time_limit(0);
include("checklist2.inc.php");
include("function_tranfer_script.php");
echo " ปิด script ";die;
function CopyPic($site_sorce,$site_dest,$idcard){
	$db_site = "cmss_".$site_sorce;
		$path_source = "../../../image_file/$site_sorce/";
		$path_dest = "../../../image_file/$site_dest/";
		$sql = "SELECT * FROM general_pic where id='$idcard'";
		$result = mysql_db_query($db_site,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$img_sorece = $path_source.$rs[imgname];
			$img_dest = $path_dest.$rs[imgname];
			@copy($img_sorece,$img_dest);
			@chmod($img_dest,0777);
				
		}

}//end function CopyPic(){
	
function CopyPDF($site_sorce,$site_dest,$idcard){
	$path_source = "../../../".PATH_KP7_FILE."/$site_sorce/$idcard".".pdf";
	$path_dest = "../../../".PATH_KP7_FILE."/$site_dest/$idcard".".pdf";
	@copy($path_source,$path_dest);
	@chmod($path_dest,0777);
}//end function CopyPDF(){




if($action == "process"){
	echo " ปิด script ";die;
	$site_source = "0139";
	$site_dest = "6502";
	$ipsource = "202.129.35.121";
	//$ipsource = "123.242.173.130";
	$ipdest = "202.129.35.121";
	$dbsource = "cmss_".$site_source;
	$dbdest = "cmss_".$site_dest;
	$xidcard = "3100503217976";
	//echo "<pre>";
	//print_r($_GET);die;
	
	//echo "$tbl :: $ipsource :: $ipdest :: $dbsource ::  $dbdest ::  $xidcard :: id<br>";
									foreach($arr_tbl1 as  $tbl){			
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"id");
									}
									foreach($arr_tbl2 as  $tbl){			
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"general_id");
									}
									foreach($arr_tbl3 as  $tbl){	
										 trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"gen_id");		
									}
									foreach($arr_tbl5 as  $tbl){	
										trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"username");		
									}
									foreach($arr_tbl6 as  $tbl){			
										trn_tbl($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"idcard");	
									}
									
									CopyPic($site_source,$site_dest,$xidcard);
									CopyPDF($site_source,$site_dest,$xidcard);
/*			//die;								####  ทำการคัดลอกไฟล์รูป
		if($pic == "Y"){
			CopyPic($site_source,$site_dest,$xidcard);
		}//end 	if($pic == "Y"){
		
		if($pdf == "Y"){
			CopyPDF($site_source,$site_dest,$xidcard);
		}
*/
									
									
									//CHECK_DATA  พร้อมลบข้อมูลเขตต้นทาง
									 foreach($arr_tbl1 as  $tbl){			
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"id");
									}
									foreach($arr_tbl2 as  $tbl){			
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"general_id");
									}
									foreach($arr_tbl3 as  $tbl){	
									 DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"gen_id");		
									}
									foreach($arr_tbl4 as $tbl){
										DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"CZ_ID");			
									}
									foreach($arr_tbl5 as  $tbl){	
									DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"username");		
									}
									foreach($arr_tbl6 as  $tbl){			
									DEL_SOURCE($tbl,$ipsource,$ipdest,"$dbsource","$dbdest",$xidcard,"idcard");	
									}	


}//end if($action == "process"){
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/tooltip_checklist/css/style.css" rel="stylesheet" type="text/css" />
<script src="../../common/tooltip_checklist/jquery_1_3_2.js"></script>
<script src="../../common/tooltip_checklist/script.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
</head>
<body>
<a href="?action=process">ประมวลผลย้ายข้อมูล</a>
</body>
</html>
