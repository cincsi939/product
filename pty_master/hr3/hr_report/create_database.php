<?
set_time_limit(1000);

include "../../inc/conndb_nonsession.inc.php";


$result = mysql_query("select * from eduarea ");
while ($rs=mysql_fetch_assoc($result)){
	$newdb = "obec_" . $rs[secid] ;

echo " database $newdb<br>";

$result_a = mysql_db_query($newdb," SELECT *  FROM `app_authority`  WHERE  appid = 93  ");
$numrows = mysql_num_rows($result_a);
echo "num = $numrows   " ;
if($numrows > 1){
$result_b = mysql_db_query($newdb," SELECT *  FROM `app_authority`  WHERE  appid = 93  limit 1  ");
$rs_b = mysql_fetch_assoc($result_b);

$sql = " update `app_authority` SET `appid` =  '44', `gid` = '0', `staffid` = '1', `authority` = '1'  WHERE  appid = 93 AND id = '$rs_b[id]' ;  ";
mysql_db_query($newdb,$sql);
echo "$sql <hr>";

}


/*
//===============================================================
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('19', '2', 'pathkpi', 'ผังโครงสร้างตัวชี้วัด', '../../images_sys/window_sidebar.png', '../relation/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('8', '1', 'Approve', 'โปรแกรมรับรองข้อมูล', '../../images_sys/window_add.png', '../approve/', '_top' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('22', '1', 'KPI Builder', 'ระบบบริหารจัดการตัวชี้วัด', '../../images_sys/kchart.gif', '../management/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('23', '1', 'AuthorityManagement', 'ระบบบริหารจัดการสิทธิ', '../../images_sys/app.gif', '../authority/organization.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('24', '2', 'KPITemplate', 'ข้อมูลเทมเพลตตัวชี้วัด', '../../images_sys/app.gif', '../management/kpi_attach_list.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('25', '1', 'usermanagement', 'usermanagement', '../../images_sys/app.gif', '../user2/organization.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('26', '2', 'ReportUserInfoadmin', 'รายงานแสดงรายชื่อ/รหัสผ่านของ infoadmin แต่เขตพื้นที่', '../../images_sys/emblem-documents.gif', '../tool/report_admin.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('47', '2', 'ReportSchoolName', 'รายงานรายชื่อโรงเรียนตามสำนักงานเขตพื้นที่การศึกษา', '../../images_sys/emblem-documents.gif', '../tool/report_school.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('28', '2', 'ReportSchoolUsernamePassword', 'รายงานรายชื่อโรงเรียน /username&password ตามสำนักงานเขตพื้นที่การศึกษา', '../../images_sys/emblem-documents.gif', '../tool/report_school_userpwd.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('29', '1', 'SystemLog', 'ระบบ System Log', '../../images_sys/app.gif', '../logsystem/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('27', '2', 'ReportAssignUpload', 'โปรแกรมตรวจสอบ จำนวนตัวแปรที่โรงเรียน download ได้', '../../images_sys/abiword_48.gif', '../tool/qpass_upload.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('30', '2', 'SchoolCompare', 'รายงานจำนวนโรงเรียนเปรียบเทียบกับข้อมูลพื้นฐาน', '../../images_sys/emblem-documents.gif', '../tool/compare_sc.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('48', '1', 'QueryReportsystem', 'ระบบรายงานสถิติการประมวล', '../../images_sys/app.gif', '../tool/stat_query_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('32', '1', 'UserOnline', 'UserOnline', '../../images_sys/app.gif', '../tool/online.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('33', '2', 'SiteSetup', 'ระบบบริหารจัดการApplicationและdatabase', '../../images_sys/app.gif', '../sitesetup/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('34', '2', 'ReportUploadDownload', 'ตรวจสอบรายการข้อมูล upload/download ของโรงเรียน ', '../../images_sys/app.gif', '../tool/qpass_upload.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('35', '2', 'ReportApproveStatus', 'รายงานตรวจสอบรายการรับรองข้อมูล', '../../images_sys/app.gif', '../tool/qpass_approvevar.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('36', '2', 'cactinetwork', 'รายงานสถานะ Network', '../../images_sys/app.gif', '/cacti/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('37', '2', 'keyin', 'โปรแกรม Download ทุกโรงเรียน', '../../images_sys/app.gif', '../form/downloadall/downloadall.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('38', '2', 'reportcallcenter', 'รายงานสรุปจำนวนผู้ติดต่อใน callcenter', '../../images_sys/app.gif', '../callcenterbusy/call_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('39', '1', 'Qpassport', 'ระบบบริหารจัดการสำหรับ Infoadmin', '../../images_sys/Q.gif', '../admin/annou_index.php', '_top' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('40', '1', 'Qpassport', 'ระบบบริหารจัดการสำหรับ User', '../../images_sys/Q.gif', '../admin/usr_index.php', '_top' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('41', '2', 'Qpassport', 'รายงานคะแนนรวม', '../../images_sys/app.gif', '../admin/kpi_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('42', '2', 'Qpassport', 'รายงานคะแนนรวม', '../../images_sys/emblem-documents.gif', '../management/allpoint.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('43', '2', 'Qpassport', 'รายงานสรุปตัวชี้วัด', '../../images_sys/emblem-documents.png', '../admin/kpi_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('44', '1', 'register', 'รายชื่อผู้ลงทะเบียนรับรหัสผ่าน', '../../images_sys/emblem-documents.gif', '../register/register_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('45', '2', 'report', 'รายชื่อโรงเรียนในสังกัด', '../../images_sys/emblem-documents.gif', '../tool/admin_report_school.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('46', '2', 'report', 'รายงานการเข้าถึงข้อมูล (สถิติการ Login/Download/Upload)', '../../images_sys/page.gif', '../tool/log_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('31', '2', 'All KPI Report', 'All KPI Report', '../../images_sys/abiword_48.png', '../management/allpoint.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('51', '1', 'Approve status  Report', 'รายงาน สถานะการรับรองข้อมูล', '../../images_sys/percent.png', '../approve/allvar.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('61', '2', 'Report', 'ข้อมูลสนับสนุนการปฏิบัติราชการตามคำรับรอง สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน ', '../../images_sys/emblem-documents.gif', '../report/report_preview.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('62', '1', 'blockgrant', 'รายงานตัวชี้วัดที่กระจายจากกรม', '../../images_sys/abiword_48.gif', '../management/grant_user.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('72', '1', 'Tranfer_kpi2Qpass', 'ทำสำเนาจาก KPI Prov เข้าสู่ QPassport', '../../images_sys/refresh.png', '../tranfer_kpi/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('82', '1', 'Reportbuilder', 'Reportbuilder', '../../images_sys/doc1.gif', '../reportbuilder/report_manage.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('91', '1', 'KPIAuthorityManagement', 'โปรแกรมบริหารจัดการสิทธิการเข้าถึงรายงานตัวชี้วัด', '../../images_sys/app.gif', '../authority_kpi/organization.php', '_blank' " ) ;

//=====================================
*/


}
?>