<?
$filename = $_POST[filename];
$yy = $_POST[yy];
$mm = $_POST[mm];
$userid = $_POST[userid];
$username_login = $_POST[username];
$office = $_POST[office];

/*
$filename = "KeyinForm.xls";
$yy = "2550";
$mm = "3";
$userid = "720074";
$username_login = "sc720074.1001";
$office = "���Ե��Է�����";
*/

$filename2 = "KeyinForm_Userid".$userid."[".$yy."].xls";
include "../../../inc/conndb.inc.php";
include "../../../common/common.inc.php";
include "../random_string.php";
$moduleid = "Keyin_001";
//conndb.inc.php
//mysql_connect("192.168.1.12","sapphire","sprd!@#$%") or die("�������ö����������");
//mysql_select_db("obec") or die( "���͡�ҹ�����������");
//$siteid = 0;
//=====
/* �ѧ��蹡�����Ѻ�����¹ log
$user : ���ͼ����
$md : ���� module �����ѧ��ҹ
$pcid : ���� Process ID ����ҧ process_log
$pcrs : ���Ѿ��ͧ process �Ҩ�� seccess , error , unknow , 
$msg : ��ͤ���������Һ�ͧ�����
$filename : file �����ѧ�ѹ�����
$siteid : ������������ѹ����� 
 function write_log($usr,$md,$pcid,$pcrs,$msg,$filename,$siteid);
*/



set_time_limit(40);
require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";

function insertlog_keyin($st,$msg,$msgcode){
	GLOBAL $userid,$yy,$mm,$filename2,$myfile;
	$inssql = "INSERT INTO `log_keyin` (`id`,`updatetime`,`userid`,`yy`,`mm`,`operation`,`src_filename`,`dst_filename`,`status`,`msg`,`msgcode`) VALUES (NULL,NOW(),'$userid','$yy','$mm','0','$filename2','$myfile.xls','$st','$msg','$msgcode')";
	mysql_query($inssql);
}


$fname = tempnam("/tmp", "$filename");
$workbook = &new writeexcel_workbook($fname);
$worksheet1 =& $workbook->addworksheet('������ѹ�֡������');

$worksheet1->set_column("A:A", 8);
$worksheet1->set_column("B:B", 86);
$worksheet1->set_column("C:C", 14);
$worksheet1->set_column("D:D", 10);
$worksheet1->set_column("E:E", 17);

# Some common formats
# header
$hcenter  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'white','size'=>14,'fg_color'=>0x38,'bold'=>1));
$hleft =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'white','size'=>14,'fg_color'=>0x38,'bold'=>1,'bottom'=>1));
$hright =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'white','size'=>14,'fg_color'=>0x38,'bold'=>1,'right'=>1));
$hrightbottom =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'white','size'=>14,'fg_color'=>0x38,'bold'=>1,'right'=>1,'bottom'=>1));
#headder2
$hcenter2  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'white','size'=>14,'fg_color'=>0x17,'bold'=>1,'bottom'=>1));
$hright2 =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'white','size'=>14,'fg_color'=>0x17,'bold'=>1,'right'=>1,'bottom'=>1,'top'=>1,'left'=>1));
$yymmstyle  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x34,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));
#kpi
$kpiidstyle  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x37,'bold'=>1,'bottom'=>1,'right'=>1,'left'=>1));
$kpinamestyle1  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'bottom'=>1,'text_wrap'=>1));
$kpinamestyle2  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2f,'bold'=>1,'bottom'=>1,'right'=>1));
#var
$varidunitstyle  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x09,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1));
$varnamestyle  =& $workbook->addformat(array('align' => 'left','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x09,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'text_wrap'=>1,'top'=>1));
$varvaluestyle  =& $workbook->addformat(array('align' => 'right','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x2C,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));
//app
$approve  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x39,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));
$notapprove  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>'red','bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));
$waitinglist  =& $workbook->addformat(array('align' => 'center','font'=>'CordiaUPC','color'=>'black','size'=>14,'fg_color'=>0x33,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));
//
#write
$worksheet1->write_blank(0, 0,                 $hcenter);
$worksheet1->write(0, 1,"�š�û�Ժѵ��Ҫ��õ�����Ѻ�ͧ��û�Ժѵ��Ҫ���", $hcenter);
$worksheet1->write_blank(0, 2,                 $hcenter);
$worksheet1->write_blank(0, 3,                 $hcenter);
$worksheet1->write_blank(0, 4,                 $hright);

$worksheet1->write_blank(1, 0,                 $hcenter);
$worksheet1->write(1, 1,"�ӹѡ�ҹ��С�����á���֡�Ң�鹾�鹰ҹ", $hcenter);
$worksheet1->write_blank(1, 2,                 $hcenter);
$worksheet1->write_blank(1, 3,                 $hcenter);
$worksheet1->write_blank(1, 4,                 $hright);

$worksheet1->write_blank(2, 0,                 $hcenter);
$worksheet1->write_blank(2, 1,				 $hcenter);
$worksheet1->write(2, 2,"��",$hcenter);
$worksheet1->write(2, 3, "��͹",$hcenter);
$worksheet1->write_blank(2, 4,                 $hright);

$worksheet1->write(3, 0,"$username_login",$hleft);
$worksheet1->write(3, 1,"$office",   $hleft);
$worksheet1->write(3, 2,"$yy",$yymmstyle);
$worksheet1->write(3, 3,"$mm",$yymmstyle);
$worksheet1->write_blank(3, 4,                 $hright);

$worksheet1->write_blank(4, 0,                 $hcenter2);
$worksheet1->write(4, 1,"��Ǫ���Ѵ�š�û�Ժѵ��Ҫ���",   $hcenter2);
$worksheet1->write(4, 2,'��ҵ����',$hright2);
$worksheet1->write(4, 3,'˹����Ѵ',$hright2);
$worksheet1->write(4, 4,"ʶҹ�",$hright2);

//new
/*
SELECT 
  `login`.`username`,
  `login`.`id`,
  `login`.`pri1`,
  `login`.`office`,
  `login_topic`.`detail_id`,
  `login_topic`.`sar_id`,
  `login_topic`.`name`,
  `login_moigroup`.`id1`,
  `login_moigroup`.`label`,
kpi_sar.name
FROM
  `login`
  INNER JOIN `login_detail` ON (`login`.`id` = `login_detail`.`id`)
  INNER JOIN `login_topic` ON (`login_detail`.`detail_id` = `login_topic`.`detail_id`)
  INNER JOIN `login_moigroup` ON (`login_topic`.`moiid` = `login_moigroup`.`id1`)
  INNER JOIN kpi_sar ON `login_topic`.`sar_id`= kpi_sar.id 
  WHERE `login`.`id` = '58' and `login_topic`.`sar_id` != '' and `login_moigroup`.`yy` = '2550' 
  ORDER BY  `login_topic`.`sar_id` ASC 
*/
//
#kpi
$sql = "
SELECT 
  `login`.`username`,
  `login`.`id`,
  `login`.`pri1`,
  `login`.`office`,
  `login_topic`.`detail_id`,
  `login_topic`.`sar_id`,
  `login_topic`.`var_id`,
  `login_topic`.`name` as varname,
  `login_moigroup`.`id1`,
  `login_moigroup`.`label`,
  `kpi_sar`.`name` as kpiname,
  `kpi_sar`.`ref_id`
FROM
  `login`
  INNER JOIN `login_detail` ON (`login`.`id` = `login_detail`.`id`)
  INNER JOIN `login_topic` ON (`login_detail`.`detail_id` = `login_topic`.`detail_id`)
  INNER JOIN `login_moigroup` ON (`login_topic`.`moiid` = `login_moigroup`.`id1`)
  INNER JOIN kpi_sar ON `login_topic`.`sar_id`= `kpi_sar`.`id`  
  WHERE `login`.`id` = '$userid' and `login_topic`.`sar_id` != '' and `login_moigroup`.`yy` = '$yy' 
  ORDER BY  `kpi_sar`.`ref_id` ASC 
";
$result = @mysql_query($sql);

// ��Ǩ�ͺ��� Assign ��Ǫ���Ѵ
$processid = "Keyin_001_001";
if(mysql_errno()){
	write_log($userid,$moduleid,$processid,"incomplete",mysql_error(),__FILE__,$siteid);
	insertlog_keyin(1,"��õ�Ǩ�ͺ��� assign ����üԴ��Ҵ","E001001");
	echo "&error_msg=��ô�ǹ���Ŵ������ �Դ��Ҵ";
	die;
}else{
	//write_log($userid,$moduleid,$processid,"complete","","",$siteid);
}

if(!mysql_num_rows($result)){
	write_log($userid,$moduleid,$processid,"incomplete","not assign this user",__FILE__,$siteid);
	insertlog_keyin(1,"����յ�Ǫ���Ѵ����Ѻ�Դ�ͺ","E001001");
	echo "&error_msg=��ҹ�ѧ�����١��˹�����Ѻ�Դ�ͺ㹡�û�Ѻ��ا�����ŵ�Ǫ���Ѵ";
	die;
}

$row = 5;
while($arr = mysql_fetch_assoc($result)){

if($arr[sar_id]!=$oid){
	$worksheet1->write($row, 0,"��Ǫ���Ѵ",$kpiidstyle);
	//$worksheet1->write($row, 0,"$arr[sar_id]",$kpiidstyle);
	//$worksheet1->write_blank($row, 0,$kpiidstyle);
	$worksheet1->write($row, 1,"$arr[ref_id] $arr[kpiname]",$kpinamestyle1);
	$worksheet1->write_blank($row, 2,$kpinamestyle1);
	$worksheet1->write_blank($row, 3,$kpinamestyle1);
	$worksheet1->write_blank($row, 4,$kpinamestyle2);
	$row++;
	$oid = $arr[sar_id];
}
//insert vardata ���������� record �ҡ�͹

	$vardtsql = "select * from vardata where siteid='$siteid' and yy='$yy' and mm='$mm' and userid = '$userid' and vid='$arr[var_id]' ";
	//echo $vardtsql."<br>";
	$vardtqr = mysql_query($vardtsql);
	if(!mysql_num_rows($vardtqr)){
		$ins = "INSERT INTO `vardata` (`siteid`,`userid`,`vid`,`yy`,`mm`) VALUES ('$siteid','$userid','$arr[var_id]','$yy','$mm')";
		//echo $ins."<br>";
		mysql_query($ins);
	}

//
#var
$sql2 = "
SELECT

`vardata`.`appstatus`,
`vardata`.`value`,
`varinfo`.`unit`

FROM
	`varinfo`
	Inner Join `vardata` ON `varinfo`.`vid` = `vardata`.`vid`
WHERE `varinfo`.`vid`='$arr[var_id]' and `vardata`.`siteid`='$siteid' and `vardata`.`userid`='$userid' and `vardata`.`yy`='$yy' and `vardata`.`mm`='$mm' limit 1

	";

//echo $sql2."<br>";
$result2 = @mysql_query($sql2);

// �֧�����ŵ����
$processid = "Keyin_001_003";
if(mysql_errno()){
	write_log($userid,$moduleid,$processid,"incomplete",mysql_error(),__FILE__,$siteid);
	insertlog_keyin(1,"��ô֧�����ŵ���üԴ��Ҵ","E001003");
	echo "&error_msg=��ô�ǹ���Ŵ������ �Դ��Ҵ";
	die;
}else{
	//write_log($userid,$moduleid,$processid,"complete","","",$siteid);
}

	while($arr2 = mysql_fetch_assoc($result2)){
		if($arr2[appstatus]=="" or $arr2[appstatus]=="waitinglist"){
			$arr2[appstatus] = "waitinglist";
			$appexp = "�͡���Ѻ�ͧ������";
		}else if($arr2[appstatus]=="approve"){
			$appexp = "�Ѻ�ͧ����������";
		}else if($arr2[appstatus]=="notapprove"){
			$appexp = "����ҹ����Ѻ�ͧ������";
		}
		$worksheet1->write($row, 0,"$arr[var_id]",$varidunitstyle);
		$worksheet1->write($row, 1,"$arr[varname]",$varnamestyle);
		$worksheet1->write($row, 2,"$arr2[value]",$varvaluestyle);
		$worksheet1->write($row, 3,"$arr2[unit]",$varidunitstyle);
		$worksheet1->write($row, 4,"$appexp",$$arr2[appstatus]);
		$row++;
	}
}
$workbook->close();
# system force download
//header("Content-Type: application/x-msexcel; name=\"$filename\"");
//header("Content-Type: application/force-download");
//header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Transfer-Encoding: binary ");
//$fh=fopen($fname, "rb");
//fpassthru($fh);
//unlink($fname);
#--------------------------------------------------------------------------------------
$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
$dlfile=fopen("tmp/$filename", "w");

//��ҹ��� XLS
$processid = "Keyin_001_004";
if(!$dlfile){
	write_log($userid,$moduleid,$processid,"incomplete","Cannot open file  tmp / $filename2 ",__FILE__,$siteid);
	insertlog_keyin(1,"��÷��ͺ�����ҹ��� $filename2 �Դ��Ҵ","E001004");
	echo "&error_msg=��ô�ǹ���Ŵ������ �Դ��Ҵ";
	die;
}else{
	//write_log($userid,$moduleid,$processid,"complete","","",$siteid);
}

$w = fwrite($dlfile,$contents);

//���ҧ��� XLS
$processid = "Keyin_001_005";
if(!$w){
	write_log($userid,$moduleid,$processid,"incomplete","Cannot write to file tmp / $filename2 ",__FILE__,$siteid);
	insertlog_keyin(1,"�����¹��� $filename2 �Դ��Ҵ","E001004");
	echo "&error_msg=��ô�ǹ���Ŵ������ �Դ��Ҵ";
	die;
}else{
	//write_log($userid,$moduleid,$processid,"complete","","",$siteid);
}
fclose($dlfile);

//backup file
	$myfile = GetRandomString(7);
while(is_file($myfile.".xls")){
	$myfile = GetRandomString(7);
}
if(!copy("tmp/".$filename,"../download_tmp/".$myfile.".xls")){
	//cannot copy file
	$processid = "Keyin_001_007";
	write_log($userid,$moduleid,$processid,"incomplete","Cannot backup file to download_tmp/$filename2 ",__FILE__,$siteid);
	insertlog_keyin(1,"�������ö Backup ��� $filename2 ��","E001007");
}else{
	//write log keyin
	chmod("../download_tmp/".$myfile.".xls", 0777); 

}
// end backup 

if(PHP_OS=='Linux'){
	$c =	chmod("tmp/$filename", 0777);   


		// change mode
		$processid = "Keyin_001_006";
		if(!$c){
			write_log($userid,$moduleid,$processid,"incomplete","Cannot change mode file tmp / $filename2 ",__FILE__,$siteid);
			insertlog_keyin(1,"�������ö����¹ mode ��èѴ��������","E001006");
			echo "&error_msg=��ô�ǹ���Ŵ������ �Դ��Ҵ";
			die;
		}else{
			//write_log($userid,$moduleid,$processid,"complete","","",$siteid);
		}

}
insertlog_keyin(0,"SUCCESS","S001");

?>