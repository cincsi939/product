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
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('19', '2', 'pathkpi', '�ѧ�ç���ҧ��Ǫ���Ѵ', '../../images_sys/window_sidebar.png', '../relation/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('8', '1', 'Approve', '������Ѻ�ͧ������', '../../images_sys/window_add.png', '../approve/', '_top' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('22', '1', 'KPI Builder', '�к������èѴ��õ�Ǫ���Ѵ', '../../images_sys/kchart.gif', '../management/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('23', '1', 'AuthorityManagement', '�к������èѴ����Է��', '../../images_sys/app.gif', '../authority/organization.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('24', '2', 'KPITemplate', '���������ŵ��Ǫ���Ѵ', '../../images_sys/app.gif', '../management/kpi_attach_list.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('25', '1', 'usermanagement', 'usermanagement', '../../images_sys/app.gif', '../user2/organization.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('26', '2', 'ReportUserInfoadmin', '��§ҹ�ʴ���ª���/���ʼ�ҹ�ͧ infoadmin ��ࢵ��鹷��', '../../images_sys/emblem-documents.gif', '../tool/report_admin.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('47', '2', 'ReportSchoolName', '��§ҹ��ª����ç���¹����ӹѡ�ҹࢵ��鹷�����֡��', '../../images_sys/emblem-documents.gif', '../tool/report_school.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('28', '2', 'ReportSchoolUsernamePassword', '��§ҹ��ª����ç���¹ /username&password ����ӹѡ�ҹࢵ��鹷�����֡��', '../../images_sys/emblem-documents.gif', '../tool/report_school_userpwd.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('29', '1', 'SystemLog', '�к� System Log', '../../images_sys/app.gif', '../logsystem/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('27', '2', 'ReportAssignUpload', '�������Ǩ�ͺ �ӹǹ����÷���ç���¹ download ��', '../../images_sys/abiword_48.gif', '../tool/qpass_upload.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('30', '2', 'SchoolCompare', '��§ҹ�ӹǹ�ç���¹���º��º�Ѻ�����ž�鹰ҹ', '../../images_sys/emblem-documents.gif', '../tool/compare_sc.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('48', '1', 'QueryReportsystem', '�к���§ҹʶԵԡ�û�����', '../../images_sys/app.gif', '../tool/stat_query_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('32', '1', 'UserOnline', 'UserOnline', '../../images_sys/app.gif', '../tool/online.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('33', '2', 'SiteSetup', '�к������èѴ���Application���database', '../../images_sys/app.gif', '../sitesetup/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('34', '2', 'ReportUploadDownload', '��Ǩ�ͺ��¡�â����� upload/download �ͧ�ç���¹ ', '../../images_sys/app.gif', '../tool/qpass_upload.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('35', '2', 'ReportApproveStatus', '��§ҹ��Ǩ�ͺ��¡���Ѻ�ͧ������', '../../images_sys/app.gif', '../tool/qpass_approvevar.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('36', '2', 'cactinetwork', '��§ҹʶҹ� Network', '../../images_sys/app.gif', '/cacti/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('37', '2', 'keyin', '����� Download �ء�ç���¹', '../../images_sys/app.gif', '../form/downloadall/downloadall.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('38', '2', 'reportcallcenter', '��§ҹ��ػ�ӹǹ���Դ���� callcenter', '../../images_sys/app.gif', '../callcenterbusy/call_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('39', '1', 'Qpassport', '�к������èѴ�������Ѻ Infoadmin', '../../images_sys/Q.gif', '../admin/annou_index.php', '_top' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('40', '1', 'Qpassport', '�к������èѴ�������Ѻ User', '../../images_sys/Q.gif', '../admin/usr_index.php', '_top' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('41', '2', 'Qpassport', '��§ҹ��ṹ���', '../../images_sys/app.gif', '../admin/kpi_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('42', '2', 'Qpassport', '��§ҹ��ṹ���', '../../images_sys/emblem-documents.gif', '../management/allpoint.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('43', '2', 'Qpassport', '��§ҹ��ػ��Ǫ���Ѵ', '../../images_sys/emblem-documents.png', '../admin/kpi_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('44', '1', 'register', '��ª��ͼ��ŧ����¹�Ѻ���ʼ�ҹ', '../../images_sys/emblem-documents.gif', '../register/register_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('45', '2', 'report', '��ª����ç���¹��ѧ�Ѵ', '../../images_sys/emblem-documents.gif', '../tool/admin_report_school.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('46', '2', 'report', '��§ҹ�����Ҷ֧������ (ʶԵԡ�� Login/Download/Upload)', '../../images_sys/page.gif', '../tool/log_report.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('31', '2', 'All KPI Report', 'All KPI Report', '../../images_sys/abiword_48.png', '../management/allpoint.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('51', '1', 'Approve status  Report', '��§ҹ ʶҹС���Ѻ�ͧ������', '../../images_sys/percent.png', '../approve/allvar.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('61', '2', 'Report', '������ʹѺʹع��û�Ժѵ��Ҫ��õ�����Ѻ�ͧ �ӹѡ�ҹ��С�����á���֡�Ң�鹾�鹰ҹ ', '../../images_sys/emblem-documents.gif', '../report/report_preview.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('62', '1', 'blockgrant', '��§ҹ��Ǫ���Ѵ����Ш�¨ҡ���', '../../images_sys/abiword_48.gif', '../management/grant_user.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('72', '1', 'Tranfer_kpi2Qpass', '�����Ҩҡ KPI Prov ������ QPassport', '../../images_sys/refresh.png', '../tranfer_kpi/', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('82', '1', 'Reportbuilder', 'Reportbuilder', '../../images_sys/doc1.gif', '../reportbuilder/report_manage.php', '_blank' " ) ;
mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('91', '1', 'KPIAuthorityManagement', '����������èѴ����Է�ԡ����Ҷ֧��§ҹ��Ǫ���Ѵ', '../../images_sys/app.gif', '../authority_kpi/organization.php', '_blank' " ) ;

//=====================================
*/


}
?>