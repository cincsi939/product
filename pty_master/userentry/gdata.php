<?php   
header("Content-Type: text/plain; charset=windows-874");    
session_start();

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr_general";
$module_code 		= "5002.xx";
$process_id 			= "xxxxxxx";
$VERSION 				= "9.x";
#########################################################
#Developer		::	Alongkot
#DateCreate		::	17/03/2007
#LastUpdate		::	17/03/2007
#DatabaseTabel	::	general
#END
//include ("../libary/function.php");
//include ("checklogin.php");
//include ("../../../config/phpconfig.php");
//include ("timefunc.inc.php");
//����������ǡѺ�ҹ�����ŷ����
include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");

$q =  iconv( 'UTF-8', 'TIS-620', $_GET["q"])  ; 
$pagesize = 50; // �ӹǹ��¡�÷���ͧ����ʴ�   
$table_db="article"; // ���ҧ����ͧ��ä���   
$find_field="arti_topic"; // ��ŷ���ͧ��ä���   

//$sql = "select * from $table_db  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";
$sql="SELECT
allschool.office,
eduarea.secname,
allschool.id
FROM
allschool
Inner Join eduarea ON allschool.siteid = eduarea.secid where   allschool.office like '%$q%' order by allschool.office limit 100"  ;
 $select1  = mysql_db_query(DB_MASTER,$sql)or die(mysql_error()); 
 $name = str_replace("'", "", $sql);   

 while ($row=mysql_fetch_array($select1,MYSQL_ASSOC)){ 
   $xid = $row["id"]; // ��ŷ���ͧ����觤�ҡ�Ѻ   
   $name =  $row["office"]." : ". str_replace("�ӹѡ�ҹࢵ��鹷�����֡��", "ʾ�.", $row["secname"]);    ; // ��ŷ���ͧ����ʴ����   
   // ��ͧ�ѹ����ͧ���� '   
    $name = str_replace("'", "'", $name);   
    // ��˹����˹����Ѻ�ӷ���ա�þ����   
    $display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);   
    echo "<li onselect=\"this.setText('$name').setValue('$xid');\">$display_name</li>"; 
 }

?>