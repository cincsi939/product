<?
set_time_limit(0);
include("../checklist2.inc.php");
require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";
$sheetname = "��ª��ͺؤ�ҡ�";
$filename = GenidcardSys($xsiteid,"7").".xls"; // ��������ӡ�õ�Ǩ�ͺ������
SaveLogExcelGen($profile_id,$xsiteid,$filename); // �� log ��� gen ��� excel

//$filename = date("His").".xls";
LogImpExpExcel($xsiteid,$profile_id,"��ǹ���Ŵ������excel �ó����ࢵ����");
$fname = tempnam("tmp_export_excel", "$filename");
$workbook = &new writeexcel_workbook($fname);
$worksheet1 =& $workbook->addworksheet($sheetname);

$worksheet1->set_column("A:A", 8); // �ӴѺ
$worksheet1->set_column("B:B", 20);// �Ţ�ѵû�ЪҪ�
$worksheet1->set_column("C:C", 10);// �ӹ�˹�Ҫ���
$worksheet1->set_column("D:D", 20);// ���� 
$worksheet1->set_column("E:E", 20); // ���ʡ��
$worksheet1->set_column("F:F", 20);// �ç���¹
$worksheet1->set_column("G:G", 20);// �����
$worksheet1->set_column("H:H", 15);// �ӹǹ���͡���(��)
$worksheet1->set_column("I:I", 15);// �ӹǹ�ٻ(�ٻ)
$worksheet1->set_column("J:J", 15);// ���͡���(1 =�ջ�,0=����ջ�)
$worksheet1->set_column("K:K", 15);// ��ѡ�ҹ����Ǩ�ͺ
$worksheet1->set_column("L:L", 20);//ʶҹ�(1=������ª������� 0 = ��ª������ 2= ź��ª����͡
$worksheet1->set_column("M:M", 15);//�Ţ�ѵ÷��١��ͧ
$worksheet1->set_column("N:N", 15);//�ѹ��͹���Դ
$worksheet1->set_column("O:O", 15);//�ѹ�������Ժѵ��Ҫ���


# Some common formats
# 0x2f = ����
# 0x34 = �����
# 0x2C = �տ��
# 0x6 = �ժ���
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
#����鹢ͺ left
$h_BNK_Pink_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_Blue_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����տ��
$h_BNK_orange_border =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ���������
$h_BNK_grey_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������
# ����鹢ͺ�ç center
$h_BNK_Pink_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x6,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_Blue_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����տ��
$h_BNK_orange_border_center =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ���������
$h_BNK_grey_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������

# ����鹢ͺ�ç left
$h_BNK_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_g_border  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������
# ����鹢ͺ�ç center
$h_BNK_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // �����ժ���
$h_BNK_g_border_center  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1)); // ������


//
#write
$line0 = 0;
$line1 = 1;
$line2 = 2;
$line3 = 3;
$line4 = 4;
$line5 = 5;
$line6 = 6;
$worksheet1->write($line0, 0," ", $h_LT);
$worksheet1->write($line0, 1," ", $h_T);
$worksheet1->write($line0, 2," ", $h_T);
$worksheet1->write($line0, 3," ", $h_T);
$worksheet1->write($line0, 4," ", $h_T);
$worksheet1->write($line0, 5," ", $h_T);
$worksheet1->write($line0, 6," ", $h_T);
$worksheet1->write($line0, 7,"�ӹǹ��", $h_T);
$worksheet1->write($line0, 8,"�ӹǹ", $h_T);
$worksheet1->write($line0, 9,"���͡���", $h_T);
$worksheet1->write($line0, 10,"��ѡ�ҹ", $h_T);
$worksheet1->write($line0, 11,"ʶҹ�(1=������ª�������", $h_T);
$worksheet1->write($line0, 12,"�Ţ�ѵû�ЪҪ�", $h_T);
$worksheet1->write($line0, 13,"�ѹ��͹��", $h_T);
$worksheet1->write($line0, 14,"�ѹ�����", $h_T);



$worksheet1->write($line1, 0,"�ӴѺ", $h_L);
$worksheet1->write($line1, 1,"�Ţ�ѵû�ЪҪ�", $h_LR);
$worksheet1->write($line1, 2,"�ӹ�˹�Ҫ���", $h_LR);
$worksheet1->write($line1, 3,"����", $h_LR);
$worksheet1->write($line1, 4,"���ʡ��", $h_LR);
$worksheet1->write($line1, 5,"�ç���¹", $h_LR);
$worksheet1->write($line1, 6,"�����", $h_LR);
$worksheet1->write($line1, 7,"�͡���", $h_LR);
$worksheet1->write($line1, 8,"�ٻ", $h_LR);
$worksheet1->write($line1, 9,"(1 =�ջ�", $h_LR);
$worksheet1->write($line1, 10,"����Ǩ�ͺ", $h_LR);
$worksheet1->write($line1, 11,"0 = ��ª������", $h_LR);
$worksheet1->write($line1, 12,"���١��ͧ", $h_LR);
$worksheet1->write($line1, 13,"�Դ", $h_LR);
$worksheet1->write($line1, 14,"��Ժѵ��Ҫ���", $h_LR);

$worksheet1->write($line2, 0," ", $h_BTM);
$worksheet1->write($line2, 1," ", $h_BTM);
$worksheet1->write($line2, 2," ", $h_BTM);
$worksheet1->write($line2, 3," ", $h_BTM);
$worksheet1->write($line2, 4," ", $h_BTM);
$worksheet1->write($line2, 5," ", $h_BTM);
$worksheet1->write($line2, 6," ", $h_BTM);
$worksheet1->write($line2, 7,"(��)", $h_BTM);
$worksheet1->write($line2, 8,"(�ٻ)", $h_BTM);
$worksheet1->write($line2, 9,"0=����ջ�)", $h_BTM);
$worksheet1->write($line2, 10," ", $h_BTM);
$worksheet1->write($line2, 11,"2= ź��ª����͡", $h_BTM);
$worksheet1->write($line2, 12," ", $h_BTM);
$worksheet1->write($line2, 13," ", $h_BTM);
$worksheet1->write($line2, 14," ", $h_BTM);


$worksheet1->write($line3, 15,"�����˵�", $h_BNK);
$worksheet1->write($line3, 16,"�ժ��� ����͡����������ó�", $h_BNK_Pink);
$worksheet1->write($line4,16,"�տ�� ��� �͡��âҴ����Сͺ", $h_BNK_Blue);
$worksheet1->write($line5,16,"������ͧ ��� �͡����Ţ�ѵ��������ó�", $h_BNK_orange);
$worksheet1->write($line6,16,"���� ��� �Ţ�ѵ��������ó�ҡ pobec ��Шӹǹ����ҧ�Ѻ�͡���", $h_BNK_grey);

######  start data
#### ���ç���¹ �Ѹ���͡���͵Ѵ�͡
 ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
$sql_area ="SELECT schoolid FROM allschool_math_sd WHERE siteid='$xsiteid'";
//echo $dbnamemaster." :: ".$sql_area."<br>";
$result_area = mysql_db_query($dbnamemaster,$sql_area) or die(mysql_error());
while($rsa = mysql_fetch_assoc($result_area)){
		if($inschoolid > "") $inschoolid .= ",";
		$inschoolid .= "'$rsa[schoolid]'";
}//end while($rsa = mysql_fetch_assoc($result_area)){

if($inschoolid != ""){
		$conW = " AND t1.schoolid NOT IN($inschoolid)";	
		$conW1 = " AND t3.schoolid NOT IN($inschoolid)";	
			
}else{
	 	$conW = "";
		$conw1 = "";	
}
//$subid = substr($xsiteid,0,2);
//if(($xsiteid == "1001" or $xsiteid == "1002" or $xsiteid == "1003" or $xsiteid == "0101" or $xsiteid == "0102" or $xsiteid == "0134" or $subid == "50" or $subid == "58") and $profile_id == "4"){// �ó���ࢵ ����¡�Ѹ����л�ж�����
		//$conw1 = "";
//}



$sql = "SELECT
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t2.office,
t2.moiareaid,
if(status_id_false='1',2,1)  as ty,
t1.page_num as page_num,
t1.pic_num as pic_num
FROM
edubkk_checklist.tbl_checklist_kp7 as t1
Left Join edubkk_master.allschool as t2 ON t1.schoolid = t2.id
WHERE
t1.siteid =  '$xsiteid' AND t1.profile_id='$profile_id' $conW

UNION
SELECT
t3.idcard,
t3.prename_th,
t3.name_th,
t3.surname_th,
t3.position_now,
t4.office,
t4.moiareaid,
 '2' as ty,
  '' as page_num,
 '' as pic_num
FROM
tbl_checklist_kp7_false as t3
Left Join edubkk_master.allschool as t4 ON  t3.schoolid=t4.id
WHERE t3.profile_id =  '$profile_id' AND
t3.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
t3.status_chang_idcard LIKE  '%NO%' AND t3.siteid='$xsiteid' $conW1
order by ty asc";
//echo $dbname_temp." :: ".$sql;die;
$result = mysql_db_query($dbname_temp,$sql);
$int_line = $line2;
$i=0;
while($rs = mysql_fetch_assoc($result)){
$int_line++;
$i++;
	if($rs[ty] == 1){
			$sy_b = $h_BNK_border;
			$sb_bc = $h_BNK_border_center;
	}else{
			$sy_b = $h_BNK_g_border;
			$sb_bc = $h_BNK_g_border_center;
	}
	
	$ampur = GetArea($xsiteid,$rs[moiareaid],"Aumpur");
	
	if($rs[page_num] > 0 or $rs[pic_num] > 0){
		$status_ch = "0";
	}else{
		$status_ch = "";	
	}

	
	$worksheet1->write($int_line, 0,"$i", $sb_bc);
	$worksheet1->write($int_line, 1," $rs[idcard] ", $sb_bc);
	$worksheet1->write($int_line, 2,"$rs[prename_th]", $sy_b);
	$worksheet1->write($int_line, 3,"$rs[name_th]", $sy_b);
	$worksheet1->write($int_line, 4,"$rs[surname_th]", $sy_b);
	$worksheet1->write($int_line, 5," $rs[office]", $sy_b);
	$worksheet1->write($int_line, 6," $ampur ", $sy_b);
	$worksheet1->write($int_line, 7,"$rs[page_num]", $sy_b);
	$worksheet1->write($int_line, 8,"$rs[pic_num]", $sy_b);
	$worksheet1->write($int_line, 9,"  ", $sy_b);
	$worksheet1->write($int_line, 10," ", $sy_b);
	$worksheet1->write($int_line, 11,"$status_ch", $sy_b);
	$worksheet1->write($int_line, 12," ", $sy_b);
	$worksheet1->write($int_line, 13," ", $sy_b);
	$worksheet1->write($int_line, 14," ", $sy_b);

}//end while($rs = mysql_fetch_assoc($result)){
####  end data
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