<?
set_time_limit(1000);
include "../../inc/conndb_nonsession.inc.php";

function Query1($sql){
	$result  = mysql_query($sql);
	echo mysql_error();
	$rs = mysql_fetch_array($result);
	return $rs[0];
}

function conn($host){
	$myconnect = mysql_connect($host,"sapphire","sprd!@#$%") OR DIE("Unable to connect to database :: $host ");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");
}

$n=0;
$sql = " SELECT
area_info.intra_ip,
eduarea.secid
FROM
area_info
Inner Join eduarea ON area_info.area_id = eduarea.area_id ORDER BY  area_info.intra_ip DESC ;";
$result = @mysql_db_query("obec",$sql);
while ($rs=mysql_fetch_assoc($result)){

		$n++;
		$newdb = "obec_" . $rs[secid] ;
		$org_name = $rs[secname];
		conn($rs[intra_ip]);
		echo "<br>$n) Database $newdb  :  $rs[intra_ip]<br>";
		
		$result1 = mysql_db_query($newdb," SELECT  MAX(id) AS maxid  FROM  `app_list`  ") ; 
		$rs1 = mysql_fetch_assoc($result1);
		$maxplus = $rs1[maxid]+1;

		$str1 = " INSERT INTO `app_list` VALUES ('$maxplus', '2' , 'reportinputdata', '���ҧ��ػ��º�¡�á�˹�˹��§ҹ����Ң���������Ѻ�ͧ��������µ�Ǫ���Ѵ-�����', '../../images_sys/app.gif', '../approve/_allvar_upapp_area3.php','_blank');";
		mysql_db_query($newdb,$str1);
		echo mysql_error();
		echo "$str1 <br> ";
		
		$str2 = " INSERT INTO `app_authority` SET   appid = '$maxplus', gid = '0',staffid =  '1',  authority = '1' ";
		mysql_db_query($newdb,$str2);	
		echo mysql_error();
		echo " $str2 <hr> ";

//		mysql_db_query($newdb," update app_list set app_url = '../register/register_report.php'  WHERE id = 44 ");
/*		
		mysql_db_query($newdb,"  TRUNCATE `app_authority`  ");

		$sql1=" SELECT * FROM  login WHERE  id = 1  ";
		$result1 = mysql_db_query($newdb,$sql1);
		while($rs1=mysql_fetch_array($result1)){



		$sql1 = " DELETE FROM login WHERE username LIKE 'webmaster%' ";
		$sql1 = " INSERT INTO `login` VALUES ('webmaster.$rs[secid]', 'logon', '1111', 'webmaster', '0', '0', '1', '1' ); " ;
		mysql_db_query($newdb,$sql1);

		mysql_db_query($newdb," DROP  TABLE IF EXISTS app_list ");
		mysql_db_query($newdb," DROP  TABLE IF EXISTS app_authority ");
		mysql_db_query($newdb," CREATE TABLE `app_list` (   `id` int(11) NOT NULL auto_increment,  `appname` varchar(255) default NULL,  `caption` varchar(255) default NULL,  `icon` varchar(255) default NULL,  `app_url` varchar(255) default NULL,  PRIMARY KEY  (`id`)) ENGINE=MyISAM AUTO_INCREMENT=11112 DEFAULT CHARSET=utf8;  ");
		mysql_db_query($newdb,"CREATE TABLE `app_authority` (   `id` int(11) NOT NULL auto_increment,  `appid` varchar(11) default NULL,  `gid` varchar(11) default '0',  `staffid` varchar(11) default '0',  `authority` tinyint(1) default '1',  PRIMARY KEY  (`id`)) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;   ");

			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('19', 'pathkpi', '�ѧ�ç���ҧ��Ǫ���Ѵ', '../../images_sys/window_sidebar.png', '../relation/');");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('8', 'Approve', '������Ѻ�ͧ������', '../../images_sys/window_add.png', '../approve/'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('22', 'kpibuilder', '�к������èѴ��õ�Ǫ���Ѵ', '../../images_sys/kchart.gif', '../management/'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('23', 'AuthorityManagement', '�к������èѴ����Է��', '../../images_sys/app.gif', '../authority/organization.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('24', 'KPITemplate', '���������ŵ��Ǫ���Ѵ', '../../images_sys/app.gif', '../management/kpi_attach_list.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('25', 'usermanagement', 'usermanagement', '../../images_sys/app.gif', '../user2/organization.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('26', 'ReportUserInfoadmin', '��§ҹ�ʴ���ª���/���ʼ�ҹ�ͧ infoadmin ��ࢵ��鹷��', '../../images_sys/emblem-documents.gif', '../tool/report_admin.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('47', 'ReportSchoolName', '��§ҹ��ª����ç���¹����ӹѡ�ҹࢵ��鹷�����֡��', '../../images_sys/emblem-documents.gif', '../tool/report_school.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('28', 'ReportSchoolUsernamePassword', '��§ҹ��ª����ç���¹ /username&password ����ӹѡ�ҹࢵ��鹷�����֡��', '../../images_sys/emblem-documents.gif', '../tool/report_school_userpwd.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('29', 'SystemLog', '�к� System Log', '../../images_sys/app.gif', '../logsystem/'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('27', 'ReportAssignUpload', '�������Ǩ�ͺ �ӹǹ����÷���ç���¹ download ��', '../../images_sys/abiword_48.gif', '../tool/qpass_upload.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('30', 'SchoolCompare', '��§ҹ�ӹǹ�ç���¹���º��º�Ѻ�����ž�鹰ҹ', '../../images_sys/emblem-documents.gif', '../tool/compare_sc.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('48', 'QueryReportsystem', '�к���§ҹʶԵԡ�û�����', '../../images_sys/app.gif', '../tool/stat_query_report.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('32', 'UserOnline', '��§ҹʶҹм�����к�', '../../images_sys/app.gif', '../tool/online.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('33', 'SiteSetup', '�к������èѴ���Application���database', '../../images_sys/app.gif', '../sitesetup/'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('34', 'ReportUploadDownload', '��Ǩ�ͺ��¡�â����� upload/download �ͧ�ç���¹ ', '../../images_sys/app.gif', '../tool/qpass_upload.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('35', 'ReportApproveStatus', '��§ҹ��Ǩ�ͺ��¡���Ѻ�ͧ������', '../../images_sys/app.gif', '../tool/qpass_approvevar.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('36', 'cactinetwork', '��§ҹʶҹ� Network', '../../images_sys/app.gif', '/cacti/'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('37', 'keyin', '����� Download �ء�ç���¹', '../../images_sys/app.gif', '../form/downloadall/downloadall.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('38', 'reportcallcenter', '��§ҹ��ػ�ӹǹ���Դ���� callcenter', '../../images_sys/app.gif', '../callcenterbusy/call_report.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('39', 'Qpassport', '�к������èѴ�������Ѻ Infoadmin', '../../images_sys/Q.gif', '../admin/annou_index.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('40', 'Qpassport', '�к������èѴ�������Ѻ User', '../../images_sys/Q.gif', '../admin/user_index.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('41', 'Qpassport', '��§ҹ��ṹ���', '../../images_sys/app.gif', '../admin/kpi_report.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('42', 'Qpassport', '��§ҹ��ṹ���', '../../images_sys/emblem-documents.gif', '../management/allpoint.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('43', 'Qpassport', '��§ҹ��ػ��Ǫ���Ѵ', '../../images_sys/emblem-documents.png', '../admin/kpi_report.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('44', 'register', '��ª��ͼ��ŧ����¹�Ѻ���ʼ�ҹ', '../../images_sys/emblem-documents.gif', '..../register/register_report.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('45', 'report', '��ª����ç���¹��ѧ�Ѵ', '../../images_sys/emblem-documents.gif', '../tool/admin_report_school.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('46', 'report', '��§ҹ�����Ҷ֧������ (ʶԵԡ�� Login/Download/Upload)', '../../images_sys/page.gif', '../tool/log_report.php'); ");
			mysql_db_query($newdb," INSERT INTO `app_list` VALUES ('31', 'All KPI Report', 'All KPI Report', '../../images_sys/abiword_48.png', '../management/allpoint.php'); ");

		$a = " INSERT INTO `app_authority` SET   appid = '44', gid = '0',staffid =  '$rs1[id]',  authority = '1' ";
		@mysql_db_query($newdb,$a);	
		@mysql_db_query($newdb," INSERT INTO app_authority SET   appid = '39', gid = '0',staffid =  '$rs1[id]',  authority = '1' ;");
		}

		$sql2=" SELECT * FROM  login WHERE (username like 'sc%') OR (username like 'area%') ";
		//echo "$sql2<hr>";
		$result2 = @mysql_db_query($newdb,$sql2);
		while($rs2=@mysql_fetch_array($result2)){
			@mysql_db_query($newdb," INSERT INTO `app_authority` SET   appid = '40', gid = '0',staffid =  '$rs2[id]',  authority = '1' ");	
		}

		$sql3=" SELECT * FROM  login WHERE username like 'webmaster%' ";
		$result3 = @mysql_db_query($newdb,$sql3);
		while($rs3=@mysql_fetch_array($result3)){
			@mysql_db_query($newdb," INSERT INTO `app_authority` SET  appid = '23', gid = '0',staffid =  '$rs3[id]',  authority =  '1' ");	
		}
*/



}
?>
<BR>
Done.