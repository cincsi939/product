<?
set_time_limit(0);
include("../checklist2.inc.php");
define("DB_MASTER","edubkk_master");
#echo "db:".DB_MASTER."<hr>";

require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";


$filename = GenidcardSys($xsiteid,"7").".xls"; // ��������ӡ�õ�Ǩ�ͺ������
SaveLogExcelGen($profile_id,$xsiteid,$filename); // �� log ��� gen ��� excel

//$filename = date("His").".xls";
LogImpExpExcel($xsiteid,$profile_id,"��ǹ���Ŵ������excel �ó����ࢵ����");
$fname = tempnam("tmp_export_excel", "$filename");
$workbook = &new writeexcel_workbook($fname);
$worksheet1 =& $workbook->addworksheet('�����������˹��§ҹ�ç���¹');


# Some common formats
# 0x2f = ����
# 0x34 = �����
# 0x2C = �տ��
# 0x6 = �ժ���
# 0x3c = �չ�ӵ��
# header
$h_ALL  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1));
$h_T  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'top'=>1,'right'=>1,'left'=>1));
$h_LT  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'top'=>1,'left'=>1));
$h_LR  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'left'=>1));
$h_L  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'left'=>1));
$h_R =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1));
$h_BTM  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'bottom'=>1,'right'=>1,'left'=>1));
$h_BNK  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1));

$h_BNK_Pink  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1)); // �����ժ���
$h_BNK_Blue  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1)); // �����տ��
$h_BNK_orange  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1)); // ���������
$h_BNK_grey  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1)); // ������
$h_BNK_grey1  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x3c,'bold'=>1)); // ���鹹ӵ��
#����鹢ͺ left
$h_BNK_Pink_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_Blue_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����տ��
$h_BNK_orange_border =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ���������
$h_BNK_grey_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������
$h_BNK_grey1_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x3c,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������
# ����鹢ͺ�ç center
$h_BNK_Pink_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_Blue_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����տ��
$h_BNK_orange_border_center =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ���������
$h_BNK_grey_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������
$h_BNK_grey1_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x3c,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������

# ����鹢ͺ�ç left
$h_BNK_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_g_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������
# ����鹢ͺ�ç center
$h_BNK_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_g_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����




####  end data
$worksheet1->set_column('A:A', 10 );
$worksheet1->set_column('B:B', 30 );
/*
$worksheet->write(2, 1, "$secname", $border1);
$worksheet->write_blank(2, 2,                 $border2);*/

$worksheet1->write(0, 0,"�����ç���¹", $h_T);
$worksheet1->write(0, 1,"����˹��§ҹ", $h_T);

$sql_org = "SELECT * FROM allschool WHERE siteid='$xsiteid' ORDER BY office ASC";
#echo $sql_org.":".DB_MASTER;die();
$result_org = mysql_db_query(DB_MASTER,$sql_org) or die(mysql_error()."$sql_org<br>LINE__".__LINE__);
$int_line1 = 1;
while($rs_org = mysql_fetch_assoc($result_org)){

			$worksheet1->write($int_line1, 0,"$rs_org[id] ", $sy_b);
			$worksheet1->write($int_line1, 1,"$rs_org[office]", $sy_b);
			$int_line1++;
}// end while($rs_org = mysql_fetch_assoc($result_org)){





$workbook->close();

#--------------------------------------------------------------------------------------
$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
$dlfile=fopen("tmp_export_excel/$filename", "w");


$w = fwrite($dlfile,$contents);

fclose($dlfile);
header("location: tmp_export_excel/$filename");
die;



?>