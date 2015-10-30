<?
require_once("../../config/conndb_nonsession.inc.php");
$host_face = "202.129.35.101";
$user_face = "sapphire";
$pass_face = "sprd!@#$%";
$dbface = "faceaccess";
$dbnameuse = "edubkk_userentry";

$host = HOST;
$user = "cmss";
$pass = "2010cmss";

$arrstaff = array('19'=>'NOR','34'=>'QC','35'=>'AC','16'=>'CALLCENTER','12'=>'SCAN','18'=>'GRAPHIC','40'=>'site_area');// site งาน




function GetStaffFace($pin,$date_start,$xtype=""){
	global $dbface,$dbnameuse,$host_face,$user_face,$pass_face;
	if($xtype == "delete" and $pin != ""){
		ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
		$sql_logdel = "INSERT INTO keystaff_log_delete (staffid,prename,staffname,staffsurname,username,password,period_time,card_id,sapphireoffice,status_permit,status_extra,keyin_group,timeupdate)
  SELECT keystaff.staffid,keystaff.prename,keystaff.staffname,keystaff.staffsurname,keystaff.username,keystaff.password,keystaff.period_time,keystaff.card_id,keystaff.sapphireoffice,keystaff.status_permit,keystaff.status_extra,keystaff.keyin_group,NOW()
  FROM keystaff  WHERE keystaff.card_id ='$pin' and keystaff.card_id <> '' and keystaff.card_id  IS NOT NULL";
  echo $dbnameuse." :: ".$sql_logdel;die;
  		mysql_db_query($dbnameuse,$sql_logdel);
		mysql_db_query($dbnameuse,"DELETE FROM keystaff WHERE card_id='$pin' and card_id <> '' and card_id  IS NOT NULL");
			
	}else{
	ConHost($host_face,$user_face,$pass_face); // connect faceaccess
	$sql = "SELECT
t1.pin,
t1.firstname,
t1.surname,
t2.prename_th,
t1.status_id,
t1.office,
t1.email,
t1.phone_number,
t1.username,
t1.`password`,
t3.time_start,
t1.firstname_eng,
t1.surname_eng,
t1.period_group_id
FROM faceacc_officer as t1 left join tbl_prename as t2 ON t1.prename=t2.id
left join faceacc_officer_to_status as t3 ON t1.officer_id=t3.officer_id
WHERE t1.pin='$pin'";
	$result = mysql_db_query($dbface,$sql) or die(mysql_error());
	$rs = mysql_fetch_assoc($result);
	if($rs[pin] != ""){
		ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); // connect cmss server
		if($xtype == "in"){
			$sub_user = $rs[firstname_eng].".".substr($rs[surname_eng],0,3);
			if($rs[period_group_id] == "3"){
				$keyin_group = "4";	
			}else if($rs[period_group_id] == "1"){
				$keyin_group = "3";		
			}//end 	if($rs[period_group_id] == "3"){
				
				if($arrstaff[office] == ""){
					$status_extra = "NOR";
				}else{
					$status_extra = $arrstaff[office];	
				}//end 	if($arrstaff[office] == ""){
				
				
				
			$sql_insert_staff= "INSERT INTO keystaff SET prename='$rs[prename_th]',staffname='$rs[firstname]',staffsurname='$rs[surname]',card_id='$rs[pin]',status_permit='YES',email='$rs[email]',username='$sub_user',password='logon',telno='$rs[phone_number]',status_extra='".$status_extra."',sapphireoffice='0',engname='$rs[firstname_eng]',engsurname='$rs[surname_eng]',keyin_group='$keyin_group'";
			mysql_db_query($dbnameuse,$sql_insert_staff);
		}else if($xtype == "out" and  $rs[status_id] != "1"){

			$sql_update_staff	 = "UPDATE keystaff SET retire_date='$date_start' WHERE card_id='$pin' ";
			mysql_db_query($dbnameuse,$sql_update_staff);
		}else if($xtype == "turn_back"){
			$sql_return_staff = "UPDATE keystaff SET status_permit='YES',retire_date='$date_start' WHERE card_id='$pin'";
			mysql_db_query($dbnameuse,$sql_return_staff);
		}//end 	if($xtype == "in"){
			
	}//end if($rs[pid] != ""){
	}//end if($xtype == "delete" and $pin != ""){
}//end function GetStaffFace(){
	
	
#####################  proces #########################3
$pin = "1509900068819";
$xtype = "delete";
$date_start = "2011-03-09";

	GetStaffFace($pin,$date_start,$xtype);  //  in คือ พนักงานเข้างานใหม่ out คือ พนักงานที่ออกงาน
	
	

?>