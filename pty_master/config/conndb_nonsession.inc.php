<?php
/**
* @comment ���١���ҧ���������Ѻconnect �ҹ������
* @projectCode 56EDUBKK01
* @tor 
* @package core
* @author Suwat.k
* @access private
* @created 24/05/2014
*/


#@modify 28/08/2015 ��С�ȻԴ�к����ͻ�Ѻ��ا������
$dd = date('d');
$mm = date('m');
$yy = date('Y');
$hh = date('H');
#echo "yy = $yy :: mm= $mm :: dd = $dd :: hh = $hh";
if(($yy == "2015" and $mm == "08" and $dd >= 28) and ($yy == "2015" and $mm == "08" and $dd < 31)){
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-874\">";
	echo "<table width=\"640\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"background:#FC0; font-style:italic; border-bottom-color:#F00; color:#F00; font-size:24px\">
	
  <tr>
    <td align=\"center\">!��С�ȻԴ�к��ҹ�����ŷ���¹����ѵ����ͻ�Ѻ��ا������ͧ�����Ţͧ�к��<br />
 ��ѹ��� 28 �ԧ�Ҥ� 2558 ���� 15:00 �.  <br />
�¨��Դ����ԡ���ա����ѹ��� 31 �ԧ�Ҥ�  2558  ���� 09:00 �.<br />
������㹤�������дǡ  </td>
  </tr>
</table>";	
die;
}
#include("function_pingip.php");
#$check_intra_ip = "192.168.5.5";
#$mode_connect = "intra"; 
## �óյ�ͧ��� connect ip �

/*if(pingAddress($check_intra_ip) == 1){
	include("cmss_var_intra.php");
}else{
	include("cmss_varx.php");	
}
echo "--->".HOST."<br>";*/
include("define_config_db.php");
include("cmss_var.inc.php");
//echo "--->".HOST."<br>";
include("cmss_var_config_linepagekp7.php");
include("cmss_define.php");
include("config_define_tables.php");

//require_once("../common/Script_CheckIdCard.php");
$SERVER_ID=1; //man server www.pdc-obec.com
if ($ob_bypass ==""){  ob_start(); } 
if ($secid_bypass != ""){ $_SESSION[secid]= $secid_bypass ; }
$db_name =STR_PREFIX_DB."master"  ;
$dbnamemaster=STR_PREFIX_DB."master";
$dbname = STR_PREFIX_DB."master";
$dbsystem = STR_PREFIX_DB."system";
 $dbcallcenter = STR_PREFIX_DB."userentry";    
//system data base
$sysdbname =""  ;
$aplicationpath=STR_PREFIX_DB."master";
//gov data
$gov_name = ""    ;
$ministry_name = "";
$gov_name_en = ""    ;
$connect_status =   ""   ;
$mainwebsite = "http://".HOST."/edubkk_master/"  ;
$admin_email    = "";  
$servergraph = "202.129.35.106";
$masterserverip = "";
$policyFile="";
$array_full_siteid = array('5001','5002','5003','5004','5005','5006','4001','6002','6601','4005','6302','4101','7102','3405');
$array_notfull_siteid = array('3303','6502','6702','6301','8602','5101','7002','7103','7302','4802','5701','7203');
//echo "host = ".HOST ." user = ". USERNAME_HOST." pass = ". PASSWORD_HOST;
$myconnect = mysql_connect(HOST, USERNAME_HOST, PASSWORD_HOST) OR DIE("Unable to connect to database");
@mysql_select_db($dbname) or die( "<center>�������ö�Դ��Ͱҹ�����ŷ���ҹ���¡�� <br> �Ҩ�Դ�ҡ��ҹ������ʾ�鹷��(Siteid, $dbname )�Դ <br> ��سҵ�Ǩ�ͺ�ա����</center>");
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");
$xarrmonth = array("","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹","�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$dbname = $db_name;

?>