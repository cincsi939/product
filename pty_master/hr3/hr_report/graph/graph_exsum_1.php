<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_graph";
$module_code 		= "listj18"; 
$process_id			= "listj18";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################

ini_set("display_errors","1");

include "../../../../config/config_hr.inc.php";
include "../../../../common/common_competency.inc.php";
//include "../../libary/function.php";
include "../phpconfig.php";
//include "../db.inc.php";

include "graph_path.inc.php";

//$time_start = getmicrotime();
conn2DB();

//$today_long = date("j") . " " . $monthname[date("j")] . " " . (date("Y") + 543);
$today = date("j") . "/" . date("m") . "/" . (date("Y") + 543);

$unit = "13000200"; //��§���� ࢵ 2

//�繢���Ҫ��ä����кؤ�ҡ÷ҧ����֡�ҷ�����Է°ҹ�
$krex  = "select  *  from general where persontype2_now = '����Ҫ��ä��'  and   (unit <> '13099999')   ";
$krsultex =  mysql_query($krex);
$krrex = mysql_num_rows($krsultex);
$total1 =  $krrex;

//��§ҹ�����á���֡��
$krex  = "select  *  from general where persontype2_now = '����Ҫ��ä��'  and   (unit <> '13099999') and positiongroup = '1' ";
$krsultex =  mysql_query($krex);
$krrex = mysql_num_rows($krsultex);
$total2 =  $krrex;


//��§ҹ������ʶҹ�֡��
$krex  = "select  *  from general where persontype2_now = '����Ҫ��ä��'  and   (unit <> '13099999') and positiongroup = '3'  ";
$krsultex =  mysql_query($krex);
$krrex = mysql_num_rows($krsultex);
$total3 =  $krrex;


// ��§ҹ���ȡ���֡��
$krex  = "select  *  from general where persontype2_now = '����Ҫ��ä��'  and (unit <> '13099999') and positiongroup = '2'  ";
$krsultex =  mysql_query($krex);
$krrex = mysql_num_rows($krsultex);
$total4 =  $krrex;


// ��§ҹ����͹
$krex  = "select  *  from general where persontype2_now = '����Ҫ��ä��'  and   (unit <> '13099999') and positiongroup = '4'  ";
$krsultex =  mysql_query($krex);
$krrex = mysql_num_rows($krsultex);
$total5 =  $krrex;






//$title="�к�ʹѺʹع��èѴ������ö�кؤ�ҡ÷ҧ����֡��";
//$subtitle="�ѵ����ǹ�ؤ�ҡ÷ҧ����֡�ҷ������ª���㹺ѭ�ն�ͨ����Թ��͹ �.18";

$title="�Ѵ��ǹ�ؤ��ҡ÷ҧ����֡�Ң���Ҫ�����кؤ��ҡ÷ҧ����֡�� �ӹѡ�ҹࢵ��鹷�����֡����§���� ࢵ 2";
//$subtitle = "��ṡ����������ͧ�ؤ�ҡ�";
$subtitle = "��§ҹ � �ѹ��� $today" ;

$namelist = "��§ҹ�����á���֡��;��§ҹ������ʶҹ�֡��;��§ҹ���ȡ���֡��;��§ҹ����͹";
$datalist = "$total2;$total3;$total4;$total5";


$graphurl = $graph_path . "?category=$namelist&data1=$datalist&outputstyle=&numseries=1&seriesname=&graphtype=pie&graphstyle=$graph_style&title=$title&subtitle=$subtitle";


//$time_end = getmicrotime(); writetime2db($time_start,$time_end); 
header("Location: $graphurl");
?>