<?
	set_time_limit(0);
	include("db.inc.php");

	
	function xread_file_folder($get_siteid){
		$Dir_Part="../../../".PATH_KP7_FILE."/$get_siteid/";
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function read_file_folder($secid){
		//echo "".$temp_siteid."<br>";
			
	$xfile_pdf = xread_file_folder($temp_siteid);
	$temp_path = "../../../".PATH_KP7_FILE."/$temp_siteid/";
	
	//echo "".$temp_siteid."<br>";
	if($xidcard != ""){
				$xfile1 = $temp_path.$xidcard.".pdf";
				echo "<a href='$xfile1' target='_blank'>$xidcard</a><br>";
				$temp_page=	GetCountPageSystem($xfile1);
				//echo "<br>จำนวนแผ่น : ".$temp_page;


					if($temp_page > 0){
						$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$xidcard' AND siteid='$temp_siteid' and profile_id='$profile_id'";
							mysql_db_query(DB_CHECKLIST,$sql_update);
							echo "<br>$sql_update<br>";
						}//end 	if($temp_page > 0){

		
		
		
	}else{
	
	if(count($xfile_pdf) > 1){
		$i=0;
		foreach($xfile_pdf as $k => $v){
			$i++;
			if($v != ""){
				$xfile1 = $temp_path.$v.".pdf";;
				$temp_page = GetCountPageSystem($xfile1);
						if($temp_page > 0){
							$sql_update = "UPDATE tbl_checklist_kp7 SET page_upload='$temp_page' WHERE idcard='$v' AND siteid='$temp_siteid' and profile_id='$profile_id'";
							mysql_db_query(DB_CHECKLIST,$sql_update);
							echo "$sql_update<br>";
					}//end if($temp_page > 0){
			}//end if($v != ""){
		}// end foreach($xfile_pdf as $k => $v){
	}// end if(count($xfile_pdf) > 1){
}//end if($xidcard != ""){
	
	

?>