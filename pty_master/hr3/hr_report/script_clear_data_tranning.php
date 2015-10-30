<?php

session_start();

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "general";
$module_code 		= "add_data";
$process_id 			= "add_persondata";
$VERSION 				= "9.x";
#########################################################
#Developer		::	Suwat 
#DateCreate		::	2010-03-06
#LastUpdate		::	2010-03-06
#DatabaseTabel	::	general
#END


include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include ("../libary/function.php");
include ("timefunc.inc.php");
include("../../../config/phpconfig.php");


if($idcard == ""){
		$idcard = $id;
}
###  ล้างข้อมูลgeneral 
$sql = "UPDATE general  SET birthday_label='',nationality='',citizenship='',startdate_label='',radub='',level_id='',sex='',gender_id='',position='',pid_begin='',blood='',blood_id='0',marry='',marital_status_id='0',home='0',region='',home_add='',contact_add='',father_prename='',father_prename_id='',father_name='',father_surname='',mother_prename='',mother_prename_id='',mother_name='',mother_surname='',mother='',marry_prename='',marry_prename_id='',marry_name='',marry_surname='',member='',education='',subminis='',minis='',position_now='',pid='',dateposition_now='',label_persontype2now='',comeday='',endday='',father_occ='',mother_occ='',marry_occ='',radub_past='',salary='',home_tel='',contact_tel='',positiongroup='',work='',noteref='',secondname_th='',secondname_en='',comment='',approve_status='',req_notapprove='0',retire='',vitaya='',vitaya_id='0',noposition='',marry_kp7='',marital_kp7_status_id='', type_dateshow='',type_dateshow2='',type_showbegindate='',retire_status='',retire_label='',status_gpf='',radub_past_id=''  WHERE id='$idcard'";
//echo "$dbname  :: ".$sql;
@mysql_db_query($dbname,$sql);
@mysql_db_query($dbname,"delete from  getroyal where id='$idcard'");
@mysql_db_query($dbname,"delete from goodman  where id='$idcard'");
@mysql_db_query($dbname,"delete from graduate  where id='$idcard'");
@mysql_db_query($dbname,"delete from hr_absent  where id='$idcard'");
@mysql_db_query($dbname,"delete from hr_nosalary  where id='$idcard'");
@mysql_db_query($dbname,"delete from hr_other  where id='$idcard'");
@mysql_db_query($dbname,"delete from hr_prohibit  where id='$idcard'");
@mysql_db_query($dbname,"delete from hr_specialduty  where id='$idcard'");
@mysql_db_query($dbname,"delete from hr_teaching  where id='$idcard'");
@mysql_db_query($dbname,"delete from req_print_kp7  where id='$idcard'");
@mysql_db_query($dbname,"delete from salary  where id='$idcard'");
@mysql_db_query($dbname,"delete from seminar  where id='$idcard'");
@mysql_db_query($dbname,"delete from seminar_form  where id='$idcard'");
@mysql_db_query($dbname,"delete from special  where id='$idcard'");
@mysql_db_query($dbname,"delete from sheet  where id='$idcard'");
@mysql_db_query($dbname,"delete from vitaya_stat  where id='$idcard'");

@mysql_db_query($dbname,"delete from hr_addhistoryaddress  where gen_id='$idcard'");
@mysql_db_query($dbname,"delete from hr_addhistoryfathername   where gen_id='$idcard'");
@mysql_db_query($dbname,"delete from hr_addhistorymarry   where gen_id='$idcard'");
@mysql_db_query($dbname,"delete from hr_addhistorymothername   where gen_id='$idcard'");
echo "<h3><center>ล้างข้อมูลเรียบร้อยแล้ว</center></h3>";
####    

?>