<?
$path_config = "../../../";
set_time_limit(0);
include("../checklist2.inc.php");
require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";
if($_GET['debug'] == "on"){
		echo "����� : ";
		echo "HOST =>".HOST."  USERNAME_HOST => ".USERNAME_HOST."  PASSWORD_HOST => ".PASSWORD_HOST;die();
}

$sheetname = "��ª��ͺؤ�ҡ�";
$filename = GenidcardSys($xsiteid,"7").".xls"; // ��������ӡ�õ�Ǩ�ͺ������
SaveLogExcelGen($profile_id,$xsiteid,$filename); // �� log ��� gen ��� excel

//$filename = date("His").".xls";
LogImpExpExcel($xsiteid,$profile_id,"��ǹ���Ŵ������excel �ó����ࢵ����");
$fname = tempnam("tmp_export_excel", "$filename");
$workbook = &new writeexcel_workbook($fname);
$worksheet1 =& $workbook->addworksheet($sheetname);
$worksheet2 =& $workbook->addworksheet('�����������˹��§ҹ�ç���¹');

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
$worksheet1->set_column("P:P", 15);//�����ç���¹
$worksheet1->set_column("Q:Q", 15);//�����ç���¹
$worksheet1->set_column("R:R", 15);//page new
$worksheet1->set_column("S:S", 15);//pic new


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
$line7 = 7;

$worksheet1->write($line0, 0," ", $h_LT);
$worksheet1->write($line0, 1," ", $h_T);
$worksheet1->write($line0, 2," ", $h_T);
$worksheet1->write($line0, 3," ", $h_T);
$worksheet1->write($line0, 4," ", $h_T);
$worksheet1->write($line0, 5," ", $h_T);// ���˹觻Ѩ�غѹ
$worksheet1->write($line0, 6," ", $h_T);
$worksheet1->write($line0, 7," ", $h_T);
$worksheet1->write($line0, 8,"", $h_T);
$worksheet1->write($line0, 9,"�ӹǹ��", $h_T);
$worksheet1->write($line0, 10,"�ӹǹ", $h_T);
$worksheet1->write($line0, 11,"���͡���", $h_T);
$worksheet1->write($line0, 12,"��ѡ�ҹ", $h_T);
$worksheet1->write($line0, 13,"ʶҹ�(1=������ª�������", $h_T);
$worksheet1->write($line0, 14,"�Ţ�ѵû�ЪҪ�", $h_T);
$worksheet1->write($line0, 15,"�ѹ��͹��", $h_T);
$worksheet1->write($line0, 16,"�ѹ�����", $h_T);
$worksheet1->write($line0, 17,"�ӹǹ��", $h_T);
$worksheet1->write($line0, 18,"�ӹǹ", $h_T);



$worksheet1->write($line1, 0,"�ӴѺ", $h_L);
$worksheet1->write($line1, 1,"�Ţ�ѵû�ЪҪ�", $h_LR);
$worksheet1->write($line1, 2,"�ӹ�˹�Ҫ���", $h_LR);
$worksheet1->write($line1, 3,"����", $h_LR);
$worksheet1->write($line1, 4,"���ʡ��", $h_LR);
$worksheet1->write($line1, 5,"���˹觻Ѩ�غѹ", $h_LR);
$worksheet1->write($line1, 6,"�ç���¹", $h_LR);
$worksheet1->write($line1, 7,"�����ç���¹", $h_LR);
$worksheet1->write($line1, 8,"�����", $h_LR);
$worksheet1->write($line1, 9,"�͡���", $h_LR);
$worksheet1->write($line1, 10,"�ٻ", $h_LR);
$worksheet1->write($line1, 11,"(1 =�ջ�", $h_LR);
$worksheet1->write($line1, 12,"����Ǩ�ͺ", $h_LR);
$worksheet1->write($line1, 13,"0 = ��ª������", $h_LR);
$worksheet1->write($line1, 14,"���١��ͧ", $h_LR);
$worksheet1->write($line1, 15,"�Դ", $h_LR);
$worksheet1->write($line1, 16,"��Ժѵ��Ҫ���", $h_LR);
$worksheet1->write($line1, 17,"�͡���", $h_LR);
$worksheet1->write($line1, 18,"�ٻ�Ҿ", $h_LR);

$worksheet1->write($line2, 0," ", $h_LR);
$worksheet1->write($line2, 1," ", $h_LR);
$worksheet1->write($line2, 2," ", $h_LR);
$worksheet1->write($line2, 3," ", $h_LR);
$worksheet1->write($line2, 4," ", $h_LR);
$worksheet1->write($line2, 5," ", $h_LR);
$worksheet1->write($line2, 6," ", $h_LR);
$worksheet1->write($line2, 7," ", $h_LR);
$worksheet1->write($line2, 8," ", $h_LR);
$worksheet1->write($line2, 9,"(��)", $h_LR);
$worksheet1->write($line2, 10,"(�ٻ)", $h_LR);
$worksheet1->write($line2, 11,"0=����ջ�)", $h_LR);
$worksheet1->write($line2, 12," ", $h_LR);
$worksheet1->write($line2, 13,"2= ź��ª����͡", $h_LR);
$worksheet1->write($line2, 14," ", $h_LR);
$worksheet1->write($line2, 15," ", $h_LR);
$worksheet1->write($line2, 16," ", $h_LR);
$worksheet1->write($line2, 17,"��ǹ����", $h_LR);
$worksheet1->write($line2, 18,"��ǹ����", $h_LR);

$worksheet1->write($line3, 0," ", $h_BTM);
$worksheet1->write($line3, 1," ", $h_BTM);
$worksheet1->write($line3, 2," ", $h_BTM);
$worksheet1->write($line3, 3," ", $h_BTM);
$worksheet1->write($line3, 4," ", $h_BTM);
$worksheet1->write($line3, 5," ", $h_BTM);
$worksheet1->write($line3, 6," ", $h_BTM);
$worksheet1->write($line3, 7," ", $h_BTM);
$worksheet1->write($line3, 8," ", $h_BTM);
$worksheet1->write($line3, 9," ", $h_BTM);
$worksheet1->write($line3, 10," ", $h_BTM);
$worksheet1->write($line3, 11," ", $h_BTM);
$worksheet1->write($line3, 12," ", $h_BTM);
$worksheet1->write($line3, 13,"3=�͡��ä�ҧ�Ѻ", $h_BTM);
$worksheet1->write($line3, 14," ", $h_BTM);
$worksheet1->write($line3, 15," ", $h_BTM);
$worksheet1->write($line3, 16," ", $h_BTM);
$worksheet1->write($line3, 17," ", $h_BTM);
$worksheet1->write($line3, 18," ", $h_BTM);




$worksheet1->write($line3, 19,"�����˵�", $h_BNK);
$worksheet1->write($line3, 20,"�ժ��� ����͡����������ó�", $h_BNK_Pink);
$worksheet1->write($line4,20,"�տ�� ��� �͡��âҴ����Сͺ", $h_BNK_Blue);
$worksheet1->write($line5,20,"������ͧ ��� �͡����Ţ�ѵ��������ó�", $h_BNK_orange);
$worksheet1->write($line6,20,"���� ��� �Ţ�ѵ��������ó�ҡ pobec ��Шӹǹ����ҧ�Ѻ�͡���", $h_BNK_grey);

######  start data
#### ���ç���¹ �Ѹ���͡���͵Ѵ�͡

 ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);

$sql = "SELECT
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.mainpage,
t1.staff_upload_pic,
t1.birthday,
t1.begindate,
t2.office,
t2.id,
t2.moiareaid,
if(status_id_false='1',2,1)  as ty,
t1.page_num as page_num,
t1.pic_num as pic_num,
t1.page_num_new,
t1.pic_num_new_cut,
'Y' as xtype
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
'' as mainpage,
'' as staff_upload_pic,
'' as birthday,
'' as begindate,
t4.office,
t4.id,
t4.moiareaid,
 '2' as ty,
  '' as page_num,
 '' as pic_num,
 '' as page_num_new ,
 '' as pic_num_new_cut,
 'N' as xtype
FROM
tbl_checklist_kp7_false as t3
Left Join edubkk_master.allschool as t4 ON  t3.schoolid=t4.id
WHERE (t3.profile_id =  '$profile_id' AND
t3.status_IDCARD LIKE  '%IDCARD_FAIL%' AND
t3.status_chang_idcard LIKE  '%NO%' AND t3.siteid='$xsiteid'  $conW1)
OR(
 (t3.status_IDCARD_REP='IDCARD_REP' OR t3.status_IDCARD_REP='IDCARD_REP_NO_PERSON' OR t3.status_IDCARD_REP='REP_CHECKLISTSITE')
  and (t3.status_id_replace='0' and t3.profile_id =  '$profile_id' and t3.siteid='$xsiteid')
)

order by moiareaid,office,name_th asc";
//echo $dbname_temp." :: ".$sql;die;

/*OR(
 (t3.status_IDCARD_REP='IDCARD_REP' OR t3.status_IDCARD_REP='IDCARD_REP_NO_PERSON' OR t3.status_IDCARD_REP='REP_CHECKLISTSITE')
  and (t3.status_id_replace='0' and t3.profile_id =  '$profile_id' and t3.siteid='$xsiteid')
)
*/
$result = mysql_db_query($dbname_temp,$sql);
$int_line = $line3;
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
	
	if(($rs[page_num] > 0 or $rs[pic_num] > 0) and $rs[staff_upload_pic] != ""){
		$status_ch = "0";
	}else{
		$status_ch = "";	
	}

	
	$worksheet1->write($int_line, 0,"$i", $sb_bc);
	$worksheet1->write($int_line, 1," $rs[idcard] ", $sb_bc);
	$worksheet1->write($int_line, 2,"$rs[prename_th]", $sy_b);
	$worksheet1->write($int_line, 3,"$rs[name_th]", $sy_b);
	$worksheet1->write($int_line, 4,"$rs[surname_th]", $sy_b);
	$worksheet1->write($int_line, 5," $rs[position_now]", $sy_b);
	$worksheet1->write($int_line, 6," $rs[office]", $sy_b);
	$worksheet1->write($int_line, 7,"$rs[id]", $sy_b);
	$worksheet1->write($int_line, 8," $ampur ", $sy_b);
	$worksheet1->write($int_line, 9,"$rs[page_num]", $sy_b);
	$worksheet1->write($int_line, 10,"$rs[pic_num]", $sy_b);
	$worksheet1->write($int_line, 11,"$rs[mainpage]", $sy_b);
	$worksheet1->write($int_line, 12,"$rs[staff_upload_pic]", $sy_b);
	$worksheet1->write($int_line, 13,"$status_ch", $sy_b);
	$worksheet1->write($int_line, 14," ", $sy_b);
	$worksheet1->write($int_line, 15,"$rs[birthday]", $sy_b);
	$worksheet1->write($int_line, 16,"$rs[begindate]", $sy_b);
	$worksheet1->write($int_line, 17,"$rs[page_num_new]", $sy_b);
	$worksheet1->write($int_line, 18,"$rs[pic_num_new_cut]", $sy_b);
	
	if($conF == "1"){ // �ա���׹�ѹ������ࢵ��鹷��
		if($rs[xtype] == "N"){
			UpdateidfalsePobec($rs[idcard],$profile_id,$xsiteid); // function ��˹�ʶҹ��Ţ�ѵ÷�����١��ͧ� ���ҧ  tbl_checklist_idfalse
		}//end if($rs[xtype] == "N"){
	}// end if($conF == "1"){


}//end while($rs = mysql_fetch_assoc($result)){
####  end data
$worksheet2->set_column('A:A', 8 );
$worksheet2->set_column('B:B', 30 );

$worksheet2->write(0, 0,"�����ç���¹", $h_T);
$worksheet2->write(0, 1,"����˹��§ҹ", $h_T);

$sql_org = "SELECT * FROM allschool WHERE siteid='$xsiteid' ORDER BY office ASC";
$result_org = mysql_db_query($dbnamemaster,$sql_org);
$int_line1 = 1;
while($rs_org = mysql_fetch_assoc($result_org)){

			$worksheet2->write($int_line1, 0,"$rs_org[id] ", $sy_b);
			$worksheet2->write($int_line1, 1,"$rs_org[office]", $sy_b);
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