<?
set_time_limit(0);

include ("../../common/common_competency.inc.php")  ;
include("checklist.inc_checkpdf_false.php");
//
//						$xtemp = CheckFileError("$xfile");
//						echo "result :: ".$xtemp;
//
//						
//						echo "<br>";
//						
////						$xtemp1 = CheckFilePDF($xfile);
////						echo "result1 ::".$xtemp1;
////							if($temp_page == "error"){
////										echo "error";
////								}else{
////										echo "ok";
////								}//end if($temp_page == false){
//									die;
//
function XCount_Page($file){
        if(file_exists($file)) { 
		
                        //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
						
                    }else { 
                          $contents = fread($handle, 1000); 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
						//echo "<pre>";
						//print_r($found);
						//$count_file = $found['1'];
                        // return $found[1]; 
                        } 
                    } 
                    $i++; 
                } //end   while (!feof($handle)) { 
				}
			}
		return $found[1];
		//fclose($handle); 
	}//end function Count_Page(){




/*require_once('fpdi/fpdf.php');
require_once('fpdi/FPDI_Protection.php');
### function นับจำนวนหน้า pdf by พี่น้อย
function CountPageSystem($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}


function getFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}

function get_picture($id){
	
	global $folder_img;	
	$ext_array	= array("jpg","jpeg","png","gif");
	if ($id <= "") return "";

		for ($i=0;$i<count($ext_array);$i++){
			$img_file = $folder_img . $id . "." . $ext_array[$i];
			if(file_exists($img_file)) return $img_file;
		}

	return "";
}
*/
function read_file_folder($xfolder,$get_site){
		$Dir_Part="../../../$xfolder/$get_site/";
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
	// edit_pic----------------------------------------------------------------------------------------
	
	## function count จำนวนคน กับไฟล์ pdf
	function CountPersonPdf($get_siteid){
		global $dbname_temp;	
		$sql = "SELECT 
		count(idcard) as NumPerson,
		sum(if(page_upload > 0,1,0)) as NumPdf,
		sum(if(page_upload > 0 and page_upload <> page_num,1,0)) as NumPageFail
		FROM tbl_checklist_kp7 WHERE siteid='$get_siteid'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr['NumPdf'] = $rs[NumPdf];
		$arr['NumPerson'] = $rs[NumPerson];
		$arr['NumPageFail'] = $rs[NumPageFail];
		return $arr;
	}
	
	###
	function AddLogPdf($get_idcard,$get_siteid,$get_action){
		global $dbname_temp;
		$sql = "INSERT INTO tbl_log_upload_pdf SET idcard='$get_idcard',siteid='$get_siteid',action='$get_action'";
		mysql_db_query($dbname_temp,$sql);
	}
	###  สร้าง โฟล์เดอร์
	function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}


#########################################

$sql_temp = "SELECT * FROM temp_site  ORDER BY siteid";
//echo $sql_temp;die;
$rs_temp = mysql_db_query("competency_system",$sql_temp);
while($rst = mysql_fetch_assoc($rs_temp)){
	$xsecid = $rst[siteid];
	$file_pdf = read_file_folder("kp7file",$xsecid);
	$count = 1;
	
	//$path_n = "../../../checklist_kp7file/$xsecid/";
	$path_n = "../../../".PATH_KP7_FILE."/$xsecid/";
	$pdf = ".pdf";
		if(count($file_pdf) > 0){
		$j=0;
		$n=0;
			foreach($file_pdf as $k => $v){
				$sql_c= "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$v' AND siteid='$xsecid'";
				//echo $sql_c."<br>";
				
				$result_c = mysql_db_query($dbname_temp,$sql_c);
				$rs_c = mysql_fetch_assoc($result_c);
					if($rs_c[idcard] != ""){// กรณีมีข้อมูลในเขตนี้เท่านั้น
					$n++;
						$file_dest = $path_n.$v.$pdf;
																			
								echo "$n :: <a href='$file_dest' target='_blank'>$v</a><br>";
								$temp_page = CheckFileError($file_dest);
								if($temp_page == "error"){
										$sql = "REPLACE INTO log_check_pdf_error SET idcard='$rs_c[idcard]', siteid='$rs_c[siteid]'";
										mysql_db_query("competency_system",$sql);
								}else{
										$sql_del = "DELETE FROM log_check_pdf_error WHERE idcard='$rs_c[idcard]' AND siteid='$rs_c[siteid]' ";	
										mysql_db_query("competency_system",$sql_del);
								}//end if($temp_page == false){

					}//end if($rs_c[idcard] != ""){
			}//end foreach($file_pdf as $k => $v){
		}//end if(count($file_pdf) > 0){
}/// end while($rst = mysql_fetch_assoc($rs_temp)){
	//$sql_uptemp = "UPDATE temp_site SET status_siteid='1' WHERE siteid='$rst[siteid]'";
//	mysql_db_query("competency_system",$sql_uptemp);
	
?>

