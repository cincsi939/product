<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_list_person";
$module_code 		= "list_person"; 
$process_id			= "list_person";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::19/2/2551
#LastUpdate	::19/2/2551
#DatabaseTabel::
#END
#########################################################
include("../libary/function.php");
include("../../../config/conndb_nonsession.inc.php");
include("../../../common/common_competency.inc.php");
require_once "../../../common/class.writeexcel_workbook.inc.php";
require_once "../../../common/class.writeexcel_worksheet.inc.php";
$time_start = getmicrotime();


set_time_limit(36000);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;


$nowIPx =  $_SERVER[SERVER_ADDR] ; 
if ($nowIPx == "127.0.0.1"){
	$masterIP = "127.0.0.1";
	$nowIP = "localhost";
}else{
	$masterIP = "192.168.2.12";	
	$nowIP =  HOST ;
} ############### END  if ($nowIP == "127.0.0.1"){
#$masterIP = "192.168.2.12";	
$masterDB = $dbnamemaster ; 
$title 	= "��ṡ����ѧ�Ѵ"; 
$nowdbname = STR_PREFIX_DB. $xsiteid ; 





$sql = " SELECT secname  FROM `eduarea` WHERE `secid` LIKE '$xsiteid'  "; 
$result = mysql_db_query($masterDB , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 

?>
<?
########################################## ������鹵�駤��  EXCEL
$xfilename = "stafflist_". trim($xsiteid) . ".xls"  ; 
$filename =  "../../../../competency__tmpxls/" .  $xfilename;
#$filename=  ".competency__tmpxls/" .  $xfilename;
#$filename=  "xxx.xls"  ;

 
$fname = tempnam(  "../../../../competency__tmpxls/", $xfilename  );
#$fname = tempnam(  "competency__tmpxls/", $xfilename  );
#echo "  xfilename     ::::::::::    $xfilename    <br><br> ";
#echo "  fname     ::::::::::    $fname    <br><br> ";  

$workbook =& new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet('��ª���');
#######################################################################
$header_h1   =& $workbook->addformat(array('align' => 'left','font'=>'Angsana New','color'=>'black','size'=>18,'fg_color'=>0x16,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$header_merge   =& $workbook->addformat(array('align' => 'center','font'=>'Angsana New','color'=>'black','size'=>16,'fg_color'=>0x16,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1 , 'merge'=>1));

$header_row   =& $workbook->addformat(array('align' => 'center','font'=>'Angsana New','color'=>'black','size'=>16,'fg_color'=>0x16,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$data_row   =& $workbook->addformat(array('align' => 'left','font'=>'Angsana New','color'=>'black','size'=>14,'fg_color'=>'0x0E' ,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$data_row_center   =& $workbook->addformat(array('align' => 'center','font'=>'Angsana New','color'=>'black','size'=>14,'fg_color'=>'0x0E' ,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$data_only   =& $workbook->addformat(array('align' => 'left','font'=>'Angsana New','color'=>'black','size'=>14,'fg_color'=>'0x0E' ,'bold'=>0,'bottom'=>0,'right'=>0,'left'=>0,'top'=>0));
/* 
$header_top
$header_top_r
$header_top_l
$header_top_down
*/ 
#######################################################################
#
# Write a general heading
#
$worksheet->set_column('A:B', 6);
$worksheet->set_column('B:C', 10);
#$worksheet->set_column('C:D:E:F:G', 20);
$worksheet->set_column('C:D', 16);
$worksheet->set_column('D:E', 20);
$worksheet->set_column('E:F', 20);$worksheet->set_column('F:G', 10);$worksheet->set_column('G:H', 20);
$worksheet->set_column('H:I', 20);$worksheet->set_column('I:J', 15);$worksheet->set_column('J:K', 20);
$worksheet->set_column('K:L', 20);$worksheet->set_column('L:M', 20);$worksheet->set_column('M:N', 20);
$worksheet->set_column('N:O', 20);$worksheet->set_column('O:P', 15);$worksheet->set_column('P:Q', 20);
$worksheet->set_column('Q:R', 20);$worksheet->set_column('R:S', 20);
#$worksheet->set_column('S:T', 20);
#$worksheet->set_column('G','H', 0,$data_only,0);
$heading  =& $workbook->addformat(array(
align => 'left', 
bold    => 1,
color   => 'blue',
size    => 18,
merge   => 1,
));


$headings = array( "$rssecname" , '' );
$worksheet->write_row('B1', $headings, $heading);

####################################################################### ����õ�駤�� 
#######################################################################
#
# Some text examples
#
$text_format =& $workbook->addformat(array(
bold=> 0,
italic => 0,
color => 'black',
size => 16,
font => 'Angsana New'
));

# �����ç���¹	�����ç���¹ 	�ӹǹ�ͧ / ������ �.�.	�����	�Ӻ�
$worksheet->write('A1', $rssecname  , $data_row  );
$worksheet->write('B1', ""  , $data_row );	$worksheet->write('C1',  ""  , $data_row );
$worksheet->write('D1',  ""  , $data_row );	$worksheet->write('E1',  ""  , $data_row );
$worksheet->write('F1',  ""  , $data_row );	$worksheet->write('G1',  ""  , $data_row );
$worksheet->write('H1',  ""  , $data_row );	$worksheet->write('I1',  ""  , $data_row );
#$worksheet->write('J1',  ""  , $header_merge );	$worksheet->write('K1',  ""  , $header_merge );	
#$worksheet->write('L1',  ""  , $header_merge );	$worksheet->write('M1',  ""  , $header_merge );	
#$worksheet->write('N1',  ""  , $header_merge );	$worksheet->write('O1',  ""  , $header_merge );	
#$worksheet->write('P1',  ""  , $header_merge );	$worksheet->write('Q1',  ""  , $header_merge );	
#$worksheet->write('R1',  ""  , $header_merge );	$worksheet->write('S1',  ""  , $header_merge );	


$month1 = array("", "���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
$th_yy = date("Y")+543 ; 
$month_nm = date("n") ; 
$timenow = date("j") ." ". $month1[$month_nm] ." ". $th_yy   ." (". (int)date("H")   .":". (int)date("i")   .":". (int)date("s")   .")"    ;  # 20 �.�. 2549 (12:30:41)
$worksheet->write('A2', "������ �.�ѹ���   $timenow  "  , $data_only );

$worksheet->write('A3', "�ӴѺ", $header_row);
$worksheet->write('B3', "�ӹ�˹�Ҫ��� ", $header_row);
$worksheet->write('C3', "���� ", $header_row);
$worksheet->write('D3', "ʡ�� ", $header_row);
$worksheet->write('E3', "���ʻ�Шӵ�ǻ�ЪҪ�  ", $header_row );
$worksheet->write('F3', "�ѹ�Դ  ", $header_row );
$worksheet->write('G3', "���˹�  ", $header_row );
$worksheet->write('H3', "�ç���¹  ", $header_row );
$worksheet->write('I3', "����ѵԡ���֡��  ", $header_row );
$worksheet->write('J3', "���˹�����ѵ���Թ��͹  ", $header_row );
$worksheet->write('K3', "�֡ͺ����д٧ҹ  ", $header_row );
$worksheet->write('L3', "����ͧ�Ҫ��������ó�  ", $header_row );
$worksheet->write('M3', "���������� ����ö�����  ", $header_row );
$worksheet->write('N3', "�ӹǹ�ѹ����ش�Ҫ���  �Ҵ �����", $header_row );
$worksheet->write('O3', "�ѹ���������Ѻ�Թ��͹�������Ѻ�Թ��͹������  ", $header_row );
$worksheet->write('P3', "������Ѻ�ɷҧ�Թ��  ", $header_row );
$worksheet->write('Q3', "��û�Ժѵ��Ҫ��þ����  ", $header_row );
$worksheet->write('R3', "��¡����� � ������    ", $header_row );						  	  	  	  	  	   		  	  	


$excelrow=3 ;	$a_row = 3; $b_row = 3; $c_row =3; $d_row = 3; $e_row =3; $f_row = 3; $g_row = 3; 
################################################################ ����ǵ��ҧ
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>��§ҹʶҹС�âͻ�Ѻ��ا������</title>
</head>
<body><?

################### ����ѵԡ���֡��    graduate
$sql = "  SELECT id , count(id) AS countnm   FROM  graduate   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 


while ($rs = mysql_fetch_assoc($query)){ 
#	echo " <br>   $idcard   ";
	$idcard = $rs[id] ; 
	$arr_graduate[$idcard] = $rs[countnm] ; 
} ################### ����ѵԡ���֡��    graduate 
# print_r($arr_graduate ) ; 

################### salary	���˹�����ѵ���Թ��͹  
$sql = "  SELECT id , count(id) AS countnm   FROM  salary   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_salary[$idcard] = $rs[countnm] ; 
} ################### salary	���˹�����ѵ���Թ��͹   

###################      seminar	�֡ͺ����д٧ҹ  
$sql = "  SELECT id , count(id) AS countnm   FROM  seminar   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_seminar[$idcard] = $rs[countnm] ; 
} ################### seminar	�֡ͺ����д٧ҹ   

################### getroyal	����ͧ�Ҫ��������ó�  
$sql = "  SELECT id , count(id) AS countnm   FROM  getroyal   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_getroyal[$idcard] = $rs[countnm] ; 
} ################### getroyal	����ͧ�Ҫ��������ó�   

################### special	��������������ö�����  
$sql = "  SELECT id , count(id) AS countnm   FROM  special   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_special[$idcard] = $rs[countnm] ; 
} ################### special	��������������ö�����   

################### hr_absent	�ӹǹ�ѹ����ش�Ҫ��� �Ҵ�Ҫ��������  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_absent   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_absent[$idcard] = $rs[countnm] ; 
} ################### hr_absent	�ӹǹ�ѹ����ش�Ҫ��� �Ҵ�Ҫ��������   

################### hr_nosalary	�ѹ���������Ѻ�Թ��͹�������Ѻ�Թ��͹������
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_nosalary   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_nosalary[$idcard] = $rs[countnm] ; 
} ################### hr_nosalary	�ѹ���������Ѻ�Թ��͹�������Ѻ�Թ��͹������ 

################### hr_prohibit	������Ѻ�ɷҧ�Թ��  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_prohibit   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_prohibit[$idcard] = $rs[countnm] ; 
} ################### hr_prohibit	������Ѻ�ɷҧ�Թ��   

################### hr_specialduty	��û�Ժѵ��Ҫ��þ����  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_specialduty   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_specialduty[$idcard] = $rs[countnm] ; 
} ################### hr_specialduty	��û�Ժѵ��Ҫ��þ����   

################### hr_other	��¡����� � ������  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_other   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_other[$idcard] = $rs[countnm] ; 
} ################### hr_other	��¡����� � ������   
?><?
################### General 
$sql = " 
SELECT general.id, general.birthday, general.prename_th, 
general.name_th, general.surname_th, general.position_now, 
$masterDB.allschool.office 
FROM  general 
Left Join $masterDB.allschool ON general.schoolid = $masterDB.allschool.id
";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_birthday[$idcard] = $rs[birthday] ; 
	$arr_prename_th[$idcard] = $rs[prename_th] ; 
	$arr_name_th[$idcard] = $rs[name_th] ; 
	$arr_surname_th[$idcard] = $rs[surname_th] ; 
	$arr_position_now[$idcard] = $rs[position_now] ; 
	$arr_office[$idcard] = $rs[office] ; 
} ################### General 
?><?
# print_r($arr_birthday) ; 
 while (list ($idcard, $birthday) = each ($arr_birthday)) {
	 $nonm++ ;  $excelrow++; 
	$a_show = "A" .  $excelrow ; 		$b_show = "B" .  $excelrow ; 		$c_show = "C" .  $excelrow ; 	
	$d_show = "D" .  $excelrow ; 		$e_show = "E" .  $excelrow ; 		$f_show = "F" .  $excelrow ; 	
	$g_show = "G" .  $excelrow ; 		$h_show = "H" .  $excelrow ; 		$i_show = "I" .  $excelrow ; 	
	$j_show = "J" .  $excelrow ; 		$k_show = "K" .  $excelrow ; 		$l_show = "L" .  $excelrow ; 	
	$m_show = "M" .  $excelrow ; 		$n_show = "N" .  $excelrow ; 		$o_show = "O" .  $excelrow ; 	
	$p_show = "P" .  $excelrow ; 	$q_show = "Q" .  $excelrow ; 	$r_show = "R" .  $excelrow ; 


	if (!( $arr_graduate[$idcard] >0  )){  $arr_graduate[$idcard] = 0 ; } 
	if (!( $arr_salary[$idcard]  )){  $arr_salary[$idcard] = 0 ; } 
	if (!( $arr_seminar[$idcard]  )){  $arr_seminar[$idcard] = 0 ; } 
	if (!( $arr_getroyal[$idcard]  )){  $arr_getroyal[$idcard] = 0 ; } 
	if (!( $arr_special[$idcard]  )){  $arr_special[$idcard] = 0 ; } 
	if (!( $arr_hr_absent[$idcard]  )){  $arr_hr_absent[$idcard] = 0 ; } 
	if (!( $arr_hr_nosalary[$idcard]   )){  $arr_hr_nosalary[$idcard] = 0 ; } 
	if (!( $arr_hr_prohibit[$idcard]   )){  $arr_hr_prohibit[$idcard] = 0 ; } 
	if (!( $arr_hr_specialduty[$idcard]  )){  $arr_hr_specialduty[$idcard] = 0 ; } 
	if (!( $arr_hr_other[$idcard]  )){  $arr_hr_other[$idcard] = 0 ; } 

	$worksheet->write("$a_show", "$nonm", $data_row);
	$worksheet->write("$b_show", "$arr_prename_th[$idcard]", $data_row);
	$worksheet->write("$c_show", "$arr_name_th[$idcard]", $data_row);
	$worksheet->write("$d_show", "$arr_surname_th[$idcard]", $data_row);
	$worksheet->write("$e_show", " $idcard", $data_row);
	$worksheet->write("$f_show", "$birthday", $data_row);
	$worksheet->write("$g_show", "$arr_position_now[$idcard]", $data_row);
	$worksheet->write("$h_show", "$arr_office[$idcard]", $data_row);
	$worksheet->write("$i_show", "$arr_graduate[$idcard]", $data_row);
	$worksheet->write("$j_show", "$arr_salary[$idcard]", $data_row);
	$worksheet->write("$k_show", "$arr_seminar[$idcard]", $data_row);
	$worksheet->write("$l_show", "$arr_getroyal[$idcard]", $data_row);
	$worksheet->write("$m_show", "$arr_special[$idcard]", $data_row);
	$worksheet->write("$n_show", "$arr_hr_absent[$idcard]", $data_row);
	$worksheet->write("$o_show", "$arr_hr_nosalary[$idcard]", $data_row);
	$worksheet->write("$p_show", "$arr_hr_prohibit[$idcard]", $data_row);
	$worksheet->write("$q_show", "$arr_hr_specialduty[$idcard]", $data_row);
	$worksheet->write("$r_show", "$arr_hr_other[$idcard]", $data_row);

#$worksheet->write('N3', "�ӹǹ�ѹ����ش�Ҫ���  �Ҵ �����", $header_row );
#$worksheet->write('O3', "  ", $header_row );
#$worksheet->write('P3', "�ѹ���������Ѻ�Թ��͹�������Ѻ�Թ��͹������  ", $header_row );
#$worksheet->write('Q3', "������Ѻ�ɷҧ�Թ��  ", $header_row );
#$worksheet->write('R3', "��û�Ժѵ��Ҫ��þ����  ", $header_row );
#$worksheet->write('S3', "��¡����� � ������    ", $header_row );		

# if ($nonm > 50 ){ die; } 
}
?><?
################################################################ �Դ��÷ӧҹ 
$workbook->close();
# echo $fname;

$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
# echo " <hr> $contents   ";
$dlfile=fopen( $filename , "w");
$w = fwrite($dlfile,$contents);
fclose($dlfile);

# header ("Location: $filename ");    die;	
#header('Content-Disposition: attachment; filename="$filename"');

echo " <meta http-equiv=\"refresh\" content=\"0;URL= $filename \"> " ; 


?>