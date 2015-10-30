<?
		$disable_query = "on"; // ตัวแปรในการกำหนดการปิดเปิด query  on คือ เปิด  off คือ ปิด
		$delete_sorce = "on";
		$fixipaddress = HOST; //  กำหนดให้เขียนที่ master เครื่อง 104
		$Cpathfile = "../../../image_file/";
			// id
			$arr_tbl1 = array("general","general_pic","getroyal","goodman","graduate","hr_absent","hr_nosalary","hr_other","hr_prohibit",
	"hr_specialduty","hr_teaching","req_print_kp7","salary","seminar","seminar_form","special","sheet","vitaya_stat");
			
			// general_id
			$arr_tbl2 = array( "log_approve","log_req_notapprove" );			
			
			// gen_id
			$arr_tbl3 = array( "hr_addhistoryaddress","hr_addhistoryfathername" , "hr_addhistorymarry" , "hr_addhistorymothername" , "hr_addhistoryname" );			
			
			//CZ_ID
			$arr_tbl4 = array( "view_general" );					

			//username , target_idcard
			$arr_tbl5 = array( "log_update" );					

			/// idcard
			$arr_tbl6 = array( "logupdate_user_dd","logupdate_user_hh" , "logupdate_user_mm" );			

			$arr_tbl_general = array("general","temp_dateremove");

//function Query1($sql){
//	$result  = mysql_query($sql);
//	echo mysql_error();
//	$rs = mysql_fetch_array($result);
//	return $rs[0];
//}



function DeleteDataNew($get_siteid,$get_idcard){
	global $arr_tbl1,$arr_tbl2,$arr_tbl3,$arr_tbl5,$arr_tbl6;
	$db_site = "cmss_$get_siteid";
	  	 foreach($arr_tbl1 as  $tbl1){		
		 	if($tbl1 != "general"){ /// ลบรายการในตารางยกเว้นตาราง general
			   $sql = "DELETE FROM $tbl1 WHERE id='$get_idcard'";
			   mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
			}// end if($tbl != "general"){
		  }
		  foreach($arr_tbl2 as  $tbl2){			
		   	   $sql = "DELETE FROM $tbl2 WHERE general_id='$get_idcard'";
			   mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
		  }
		  foreach($arr_tbl3 as  $tbl3){	
		   		$sql = "DELETE FROM $tbl3 WHERE gen_id='$get_idcard'";
			    mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
		  }
		  foreach($arr_tbl5 as  $tbl5){	
		  		$sql = "DELETE FROM $tbl5 WHERE username='$get_idcard'";
			  	mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
		  }
		  foreach($arr_tbl6 as  $tbl6){			
		  		$sql = "DELETE FROM $tbl6 WHERE idcard='$get_idcard'";
			  	mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__); 
		  }		
}//end function DeleteDataNew($get_siteid,$get_idcard){

			
			
			###  function ลบข้อมูลต้นทางที่ไม่ใช้ 46 เขต
function DeleteDataNotIn($get_siteid,$get_idcard){
	if($get_siteid!=""){ // P'noi
			$db_site = "cmss_$get_siteid";
			$sql = "DELETE FROM general WHERE id='$get_idcard'";
			mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
	}

}//end function DeleteDataNotIn($get_idcard){
###  function ลบข้อมูลต้นทางที่ไม่ใช้ 46 เขต
?>