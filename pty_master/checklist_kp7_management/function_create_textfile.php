<?

$path_file_sql = "../../../textfile_idcardfalse/";
$path_fileall = "../../../textfile_idcardfalse/fileall/";

function xRmkdir1($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}

		
function CreateFile($profile_id){
	global $path_file_sql;
	$filename1 = date("YmdHis");
	SaveLogGenfile($filename1.".txt",$profile_id);
	$filename_sql = $path_file_sql."$filename1".".txt";
	$handle = @fopen($filename_sql, "w+");	
	chmod("$filename_sql",0777);
	return $filename_sql;

}//end function CreateFile(){
	
	
function GetGender($prename_th){
	global $dbnamemaster;
	$sql = "SELECT gender FROM prename_th WHERE prename_th='$prename_th'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[gender];
		
}//end function GetGender($prename_th){

function SaveTableFile($profile_id){
	global $dbname_temp;
	$filename = CreateFile($profile_id); // สร้างไฟล์ sql
	
	
	
		$xstr = "เลขบัตรเดิม \t\t\t\t|ชื่อ \t\t\t\t| นามสกุล \t\t\t\t| เพศ \t\t\t\t| วันเดือนปีเกิด \n";
		if(is_writable($filename)) {
				
		 if (!$handle = fopen($filename, 'a')) {
				echo "!พบข้อผิดพลาด: ไม่สามารถเปิดไฟล์ได้ ($filename)";
				exit;
		   }//end  if (!$handle = fopen($filename, 'a')) { 
		   if (fwrite($handle, $xstr) === FALSE) {
      	 		echo "!พบข้อผิดพลาด: ไม่สามารถเขียนไฟล์ได้ ($filename)";
      			 exit;
  			}//end   if (fwrite($handle, $somecontent) === FALSE) 
			fclose($handle);
					
	}else{
				echo "ไฟล์  $filename ไม่สามารถบันทึกได้\n";
				exit();	
	}//end if(is_writable($filename)) {

	$sql = "SELECT
tbl_checklist_kp7_false.idcard,
tbl_checklist_kp7_false.siteid,
tbl_checklist_kp7_false.prename_th,
tbl_checklist_kp7_false.name_th,
tbl_checklist_kp7_false.surname_th,
tbl_checklist_kp7_false.birthday,
concat(tbl_checklist_kp7_false.name_th,tbl_checklist_kp7_false.surname_th,tbl_checklist_kp7_false.siteid) as fullname
FROM
tbl_checklist_kp7_false
WHERE
tbl_checklist_kp7_false.profile_id =  '$profile_id' AND
tbl_checklist_kp7_false.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
tbl_checklist_kp7_false.status_chang_idcard LIKE  '%NO%' 
AND (tbl_checklist_kp7_false.name_th <> '' and tbl_checklist_kp7_false.surname_th <> '' )

UNION
SELECT
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.siteid,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.birthday,
concat(tbl_checklist_kp7.name_th,tbl_checklist_kp7.surname_th,tbl_checklist_kp7.siteid) as fullname
FROM `tbl_checklist_kp7`
WHERE  tbl_checklist_kp7.profile_id='$profile_id' AND tbl_checklist_kp7.status_id_false='1' 
AND (tbl_checklist_kp7.name_th <> '' and tbl_checklist_kp7.surname_th <>'' )
ORDER  BY name_th ASC ";
$result = mysql_db_query($dbname_temp,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	
//echo $rs[fullname] ." :: ".$temp_fullname."<br>";
	if($rs[fullname] != $temp_fullname){ // เอาที่ชื่อมันไม่ซ้ำกันในระบบ

	$i++;
	
	
			$gender = GetGender($rs[prename_th]);
			$arr1 = explode("-",$rs[birthday]);
			$birthday =$arr1[2]."-".$arr1[1]."-".$arr1[0];
			$str .= $rs[idcard]."\t\t\t\t|".$rs[name_th]."\t\t\t\t|".$rs[surname_th]."\t\t\t\t|".$gender."\t\t\t\t|".$birthday."\n";
				
			$temp_fullname = $rs[fullname];
	}//end 	if($rs[fullname] != $temp_fullname){
}//end while($rs = mysql_fetch_assoc($result)){  \t 

		################################  รายละเอียด

	
		if(is_writable($filename)) {
				
			 if (!$handle = fopen($filename, 'a')) {
				echo "!พบข้อผิดพลาด: ไม่สามารถเปิดไฟล์ได้ ($filename)";
				exit;
		   }//end  if (!$handle = fopen($filename, 'a')) {
		   
		   if (fwrite($handle, $str) === FALSE) {
      	 		echo "!พบข้อผิดพลาด: ไม่สามารถเขียนไฟล์ได้ ($filename)";
      			 exit;
  			}//end   if (fwrite($handle, $somecontent) === FALSE) {

			fclose($handle);
					
			}else{
				echo "ไฟล์  $filename ไม่สามารถบันทึกได้\n";
				//exit();	
			}//end if(is_writable($filename)) {



	return $filename;

}//end function trn_tbl($tblname,$ipsource,$ipdest,$dbsource,$dbtarget,$id,$cond_f){
	
function SaveLogGenfile($file_name,$profile_id){
	global $dbname_temp;
	$sql = "INSERT tbl_loggentextfile_idcardfalse SET staffid='".$_SESSION['session_staffid']."',file_name='$file_name',profile_id='$profile_id',time_create=NOW()";	
	mysql_db_query($dbname_temp,$sql);
}
?>